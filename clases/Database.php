<?php
class Database
{
  private $host = '172.17.0.3';   // Cambiar por la IP o hostname correcto
  private $port = '5432';         // Cambiar por el puerto correcto si es diferente
  private $dbname = 'db_test';    // Cambiar por el nombre de la base de datos
  private $user = 'user';         // Cambiar por el usuario de la base de datos
  private $pass = 'password';     // Cambiar por la contraseña del usuario
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
