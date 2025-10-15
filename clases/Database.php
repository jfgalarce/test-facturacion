<?php
class Database
{
  private $host = '172.17.0.3';
  private $port = '5432';
  private $dbname = 'db_test';
  private $user = 'user';
  private $pass = 'password';
  private $pdo;

  public function __construct()
  {
    try {
      $this->pdo = new PDO(
        "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}",
        $this->user,
        $this->pass
      );
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->pdo->exec("SET search_path TO facturacion, public");
    } catch (PDOException $e) {
      die("Error de conexión: " . $e->getMessage());
    }
  }

  public function getConnection()
  {
    return $this->pdo;
  }
}
