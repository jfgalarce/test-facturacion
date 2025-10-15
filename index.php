<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test Facturación</title>
  <?php
  $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
  ?>
  <base href="<?php echo $base; ?>">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="container">

    <form class="form-container" id="formProducto" onsubmit="guardarProducto(event)">
      <h1>
        Formulario de Producto
      </h1>
      <div class="grid">
        <div class="group">
          <label for="inputCodigo">Código</label>
          <input type="text" id="inputCodigo" name="inputCodigo" placeholder="PROD00K" minlength="5" maxlength="15" onblur="existeProducto(this)">
        </div>

        <div class="group">
          <label for="inputNombre">Nombre</label>
          <input type="text" id="inputNombre" name="inputNombre" placeholder="Caja de clavos" minlength="2" maxlength="50" onblur="validarNombre(this)">
        </div>

        <div class="group">
          <label for="selectBodega">Bodega</label>
          <select id="selectBodega" name="selectBodega" onchange="validarBodega(this)">
          </select>
        </div>

        <div class="group">
          <label for="selectSucursal">Sucursal</label>
          <select id="selectSucursal" name="selectSucursal" onchange="validarSucursal(this)">
          </select>
        </div>

        <div class="group">
          <label for="selectMoneda">Moneda</label>
          <select id="selectMoneda" name="selectMoneda" onchange="validarMoneda(this)">
          </select>
        </div>

        <div class="group">
          <label for="inputPrecio">Precio</label>
          <input type="number" id="inputPrecio" name="inputPrecio" placeholder="100.99" min="0" step="0.01" onblur="validarPrecio(this)">
        </div>
      </div>

      <div class="group">
        <label for="inputMaterial">Material del Producto</label>
        <div id="materiales" class="group-checkbox">
        </div>
      </div>
      <div class="group">
        <label for="inputMaterial">Descripción</label>
        <textarea id="inputDescripcion" name="inputDescripcion" rows="4" placeholder="Descripción del producto..." minlength="10" maxlength="1000" onblur="validarDescripcion(this)"></textarea>
      </div>
      <div style="text-align: center;">
        <button type="submit">Guardar Producto</button>
      </div>
    </form>
  </div>
  <script src="js/main.js"></script>
</body>
</html>