<?php

/**
 * Exception class for circuit breaker errors
 */
class CircuitBreakerException extends Exception
{
}
interface ICircuitBreakerInterface
{
    /**
     * Check the availability of a  service
     * @param string $serviceName Name of the service to check
     * @return bool True if the circuit is closed (calls allowed), False if open
     */
    public function isServiceAvailable(string $serviceName): bool;

    /**
     * Executes the provided operation while handling circuit breaker logic
     *
     * @param string $serviceName Name of the service to call
     * @param callable $operation The operation to execute (should return the service response)
     * @param int $timeout (Optional) The timeout in milliseconds for the operation
     *@throws CircuitBreakerException if the circuit is open or the operation fails
     *
     * @return mixed The response from the service operation (if successful)
     */
    public function execute(string $serviceName, callable $operation,int $timeout = 5000): mixed;
}


class SimpleCircuitBreaker implements ICircuitBreakerInterface
{
    private const CIRCUIT_OPEN_DURATION = 10000;
    private const FAILURE_THRESHOLD  = 5; // Number of consecutive failures to open circuit
    private array $serviceStates = [];

    public function isServiceAvailable(string $serviceName): bool
    {
        if(!isset($this->serviceStates[$serviceName]))
        {
            $this->serviceStates = [
                "isOpen"        => false,
                "lastFailure"   =>  null
            ];
        }
        $currentState = &$this->serviceStates[$serviceName];
        return !$currentState["isOpen"] || microtime(true) - $currentState['lastFailure'] > self::CIRCUIT_OPEN_DURATION / 1000;
    }

    public function execute(string $serviceName, callable $operation, int $timeout = 5000): mixed
    {
        if (!$this->isServiceAvailable($serviceName)) {
            throw new CircuitBreakerException("Circuit breaker is open for service: $serviceName");
        }

        try {
            $startTime = microtime(true);
            $response = $operation();
            $elapsedTime = (microtime(true) - $startTime) * 1000;

            if ($elapsedTime > $timeout) {
                throw new CircuitBreakerException("Service call timed out: $serviceName ($elapsedTime ms)");
            }

            // Successful call, reset failure counter if needed
            if (isset($this->serviceStates[$serviceName]['lastFailure'])) {
                unset($this->serviceStates[$serviceName]['lastFailure']);
            }

            return $response;
        } catch (Exception $e) {
            $this->serviceStates[$serviceName]['lastFailure'] = microtime(true);
            // Track consecutive failures and potentially open the circuit
            if (count($this->serviceStates[$serviceName]['lastFailure']) >= self::FAILURE_THRESHOLD) {
                $this->serviceStates[$serviceName]['isOpen'] = true;
            }
            throw $e;
        }
    }
}

// Example usage
try {
    $circuitBreaker = new SimpleCircuitBreaker();

    // Simulate a service call (replace with your actual service call logic)
    $response = $circuitBreaker->execute('user-service', function () {
        // ... Call the user service ...
        return ['user' => 'John Doe'];
    }, 2000);

    var_dump($response);
} catch (CircuitBreakerException $e) {
    echo "Error: " . $e->getMessage();
}
