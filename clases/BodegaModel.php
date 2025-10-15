<?php
require_once 'Database.php';

class BodegaModel
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    private function sanitizarInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizarInput'], $input);
        }
        if (is_string($input)) {
            return strip_tags(trim($input));
        }
        return $input;
    }

    public function obtenerListas()
    {
        try {
            $stmt = $this->pdo->query("SELECT obtener_listas() AS resultado");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['resultado'];
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function guardarProducto($id, $nombre, $precio, $descripcion, $id_bodega, $id_sucursal, $id_moneda, $materiales, $creado_por)
    {
        try {

            $id = $this->sanitizarInput($id);
            $nombre = $this->sanitizarInput($nombre);
            $precio = $this->sanitizarInput($precio);
            $descripcion = $this->sanitizarInput($descripcion);
            $id_bodega = $this->sanitizarInput($id_bodega);
            $id_sucursal = $this->sanitizarInput($id_sucursal);
            $id_moneda = $this->sanitizarInput($id_moneda);
            $materiales = $this->sanitizarInput($materiales);
            $creado_por = $this->sanitizarInput($creado_por);

            $id_bodega = (int) $id_bodega;
            $id_sucursal = (int) $id_sucursal;
            $id_moneda = (int) $id_moneda;

            $materiales_json = json_encode($materiales);
            if ($materiales_json === false) {
                return ['error' => 'json_encode error: ' . json_last_error_msg()];
            }
            $sql = "SELECT insertar_producto(:id, :nombre, :precio, :descripcion, :id_bodega, :id_sucursal, :id_moneda, :materiales::json, :creado_por) AS resultado";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_STR);
            $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindValue(':precio', $precio, PDO::PARAM_STR);
            $stmt->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
            $stmt->bindValue(':id_bodega', $id_bodega, PDO::PARAM_INT);
            $stmt->bindValue(':id_sucursal', $id_sucursal, PDO::PARAM_INT);
            $stmt->bindValue(':id_moneda', $id_moneda, PDO::PARAM_INT);
            $stmt->bindValue(':materiales', $materiales_json, PDO::PARAM_STR);
            $stmt->bindValue(':creado_por', $creado_por, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row === false) {
                return ['error' => 'No se obtuvo resultado de la consulta'];
            }

            return $row['resultado'];
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function existeProducto($id) {
        try {
            $id = $this->sanitizarInput($id);
            $stmt = $this->pdo->prepare("SELECT existe_producto(:id) AS existe");
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['existe'] === true;
        } catch (PDOException $e) {
            return ['error' => 'Error al verificar el producto: ' . $e->getMessage()];
        }
    }

}
