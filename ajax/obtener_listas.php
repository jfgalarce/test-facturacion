<?php

require_once '../clases/BodegaModel.php';

$model = new BodegaModel();
header('content-type: application/json');
echo $model->obtenerListas();