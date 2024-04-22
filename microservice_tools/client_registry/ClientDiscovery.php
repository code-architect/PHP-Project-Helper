<?php

/**
 * Interface for client discovery functionality
 */
interface ClientDiscoveryInterface
{
    /**
     * Discovers a specific service client based on its name
     *
     * @param string $serviceName Name of the service to discover
     * @throws ClientDiscoveryException if the service is not found
     * @return string The address (URL or hostname) of the discovered service client
     */
    public function getServiceAddress(string $serviceName): string;
}

/**
 * Exception class for client discovery errors
 */
class ClientDiscoveryException extends Exception
{
}

/**
 * Simple client discovery implementation using a local registry file
 */
class LocalClientRegistry implements ClientDiscoveryInterface
{
    private const REGISTRY_FILE = 'service.json';

    /**
     * Discovers a specific service client based on its name
     *
     * @param string $serviceName Name of the service to discover
     * @throws ClientDiscoveryException if the service is not found
     * @return string The address (URL or hostname) of the discovered service client
     */
    public function getServiceAddress(string $serviceName): string
    {
        if (!file_exists(self::REGISTRY_FILE)) {
            throw new ClientDiscoveryException("Client registry file not found: " . self::REGISTRY_FILE);
        }

        $registryData = json_decode(file_get_contents(self::REGISTRY_FILE), true);
        if (!isset($registryData[$serviceName])) {
            throw new ClientDiscoveryException("Service not found: " . $serviceName);
        }

        return $registryData[$serviceName];
    }
}

// Example usage
try {
    $clientDiscovery = new LocalClientRegistry();
    $userServiceAddress = $clientDiscovery->getServiceAddress('user-service');
    echo "User service address: $userServiceAddress";
} catch (ClientDiscoveryException $e) {
    echo "Error: " . $e->getMessage();
}

