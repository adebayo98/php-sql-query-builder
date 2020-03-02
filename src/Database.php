<?php


namespace Adebayo\QueryBuilder;

use PDO;


class Database
{

    private ?PDO $connection = null;

    private string $driver;

    private string $dbname;

    private string $host;

    private int $port;

    private string $username;

    private string $password;

    private ?string $version;

    private ?string $charset;


    public function __construct(string $driver, string $dbname, string $host, string $username, string $password, array $options = [])
    {
        $this->driver = $driver;
        $this->dbname = $dbname;
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->port = $options['port'] ?? 3306;
        $this->version = $options['version'] ?? null;
        $this->charset = $options['charset'] ?? 'utf8';
    }

    public function getQueryBuilder(string $tableName)
    {
        return new QueryBuilder($tableName, []);
    }

    public function getConnection(): PDO
    {
        if ($this->connection === null){
            try{
                $this->connection = new PDO(
                    "{$this->driver}:host={$this->host};dbname={$this->dbname};port={$this->port};charset={$this->charset}",
                    $this->username,
                    $this->password,
                    [PDO::ATTR_PERSISTENT => true]
                );
            }catch (\Exception $exception){
                die("Database connection error: " . $exception->getMessage());
            }
        }

        return $this->connection;
    }

}