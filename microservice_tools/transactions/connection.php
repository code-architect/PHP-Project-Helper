<?php
require '../vendor/autoload.php';
use Dotenv\Dotenv as DotEnv;

// load env file
$dotenv = DotEnv::createImmutable(__DIR__);
$dotenv->load();


class Connection
{
    private static $instance;

    // Private constructor to prevent instantiation from outside
    private function __construct()
    {
    }

    // Method to get the singleton instance
    public static function getInstance(): Connection
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(string $type): object
    {
        switch ($type) {
            case 'pdo':
                return $this->connection_pdo();
            case 'mysqli':
                return $this->connection_mysqli();
            default:
                throw new InvalidArgumentException('Invalid connection type');
        }
    }

    public function connection_pdo()
    {
        try{
            $host = $_ENV['DB_HOST'];
            $dbName = $_ENV['DB_NAME'];
            return new PDO("mysql:host={$host};dbname={$dbName}", $_ENV['DB_USER'], $_ENV['PASSWORD'], array(
                PDO::ATTR_PERSISTENT => true
            ));
        }catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public function connection_mysqli()
    {
        // Create a persistent connection
        try{
            return new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['PASSWORD'], $_ENV['DB_NAME'],null, null);
        }catch (mysqli_sql_exception $e)
        {
            die('Connection failed: ' . $e->getMessage());
        }

    }

}