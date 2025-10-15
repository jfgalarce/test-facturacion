<?php

require_once '../clases/BodegaModel.php';

$model = new BodegaModel();
header('content-type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);
  $id = $data['id'] ?? null;
  $nombre = $data['nombre'] ?? null;
  $precio = $data['precio'] ?? null;
  $descripcion = $data['descripcion'] ?? null;
  $id_bodega = $data['id_bodega'] ?? null;
  $id_sucursal = $data['id_sucursal'] ?? null;
  $id_moneda = $data['id_moneda'] ?? null;
  $materiales = $data['materiales'] ?? null;
  $creado_por = $data['creado_por'] ?? null;
  $resultado = $model->guardarProducto($id, $nombre, $precio, $descripcion, $id_bodega, $id_sucursal, $id_moneda, $materiales, $creado_por);
  echo json_encode(['estado' => $resultado, 'mensaje' => '']);
} else {
  echo json_encode(['estado' => false, 'mensaje' => 'Método no permitido']);
}
