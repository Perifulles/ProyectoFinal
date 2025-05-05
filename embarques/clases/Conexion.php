<?php
class Conexion
{
    private $host;
    private $userName;
    private $password;
    private $db;
    private $conn;
    private $configFile = "conf.json";

    public function __construct()
    {
        $this->connect();
    }

    public function __destruct()
    {
        $this->conn = null;
    }

    public function connect()
    {
        if (!file_exists($this->configFile)) {
            die("Unable to open file!");
        }

        $configData = file_get_contents($this->configFile);
        $config = json_decode($configData, true);

        $this->host = $config['host'];
        $this->userName = $config['userName'];
        $this->password = $config['password'];
        $this->db = $config['db'];

        $dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";

        try {
            $this->conn = new PDO($dsn, $this->userName, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConn()
    {
        return $this->conn;
    }
}
