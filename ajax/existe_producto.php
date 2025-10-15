<?php
require_once '../clases/BodegaModel.php';
header('content-type: application/json');

$model = new BodegaModel();
$id = $_GET['id'] ?? null;
$existe = $model->existeProducto($id);

echo json_encode(['estado' => $existe]);
