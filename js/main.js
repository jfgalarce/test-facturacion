let sucursales = [];
function obtenerListas() {
  const xhr = new XMLHttpRequest();
  xhr.open('GET', './ajax/obtener_listas.php', true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      const listas = JSON.parse(xhr.responseText);
      llegarListas('selectBodega', listas.bodegas);
      sucursales = listas.sucursales;
      llegarListas('selectMoneda', listas.monedas);
      llegarCheckbox('materiales', listas.materiales);
    } else {
      alert('Error al cargar las tareas')
    }
  };
  xhr.send();
}

function llegarListas(nombreLista, arrayListas) {
  const lista = document.getElementById(nombreLista);
  const optionMoneda = document.createElement('option');
  optionMoneda.value = '0';
  optionMoneda.textContent = '';
  lista.appendChild(optionMoneda);
  arrayListas.forEach(elemento => {
    const option = document.createElement('option');
    option.value = elemento.id;
    option.textContent = elemento.nombre;
    lista.appendChild(option);
  });

}

function llegarCheckbox(nombreCheckbox, arrayCheckbox) {
  const div = document.getElementById(nombreCheckbox);
  arrayCheckbox.forEach(elemento => {
    const checkbox = document.createElement('input');
    checkbox.type = 'checkbox';
    checkbox.id = 'material' + elemento.id;
    checkbox.name = 'material' + elemento.id;
    checkbox.value = elemento.id;

    const label = document.createElement('label');
    label.htmlFor = 'material' + elemento.id;
    label.textContent = elemento.nombre;

    div.appendChild(checkbox);
    div.appendChild(label);
  });
}

function guardarProducto(e) {
  e.preventDefault();
  const id = document.getElementById('inputCodigo').value;
  const nombre = document.getElementById('inputNombre').value;
  const descripcion = document.getElementById('inputDescripcion').value;
  const precio = document.getElementById('inputPrecio').value;
  const bodega = document.getElementById('selectBodega').value;
  const sucursal = document.getElementById('selectSucursal').value;
  const moneda = document.getElementById('selectMoneda').value;

  const materiales = [];
  const checkboxes = document.querySelectorAll('#materiales input[type="checkbox"]');

  checkboxes.forEach(checkbox => {
    if (checkbox.checked) {
      materiales.push(checkbox.value);
    }
  });

  if (!id || id.trim() === "" || !nombre || nombre.trim() === "" || !descripcion || descripcion.trim() === "" || !precio || precio.trim() === "" || bodega === "0" || sucursal === "0" || moneda === "0") {
    alert("Por favor, complete todos los campos obligatorios.");
    return false;
  }

  if (materiales.length < 2) {
    alert("Debe seleccionar al menos dos materiales para el producto.");
    return false;
  }


  const productoData = {
    id: id,
    nombre: nombre,
    descripcion: descripcion,
    precio: precio,
    id_bodega: bodega,
    id_sucursal: sucursal,
    id_moneda: moneda,
    materiales: materiales,
    creado_por: "user"
  };


  const xhr = new XMLHttpRequest();
  xhr.open('POST', './ajax/guardar_producto.php', true);
  xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
  xhr.onload = function () {
    console.log(xhr.responseText);
    if (xhr.status === 200) {
      const respuesta = JSON.parse(xhr.responseText);
      if (respuesta.estado) {
        alert('Producto guardado con éxito');
        document.getElementById('selectSucursal').innerHTML = '';
        document.getElementById('formProducto').reset();
      } else {
        alert('Error al guardar el producto: ' + respuesta.mensaje);
      }
    } else {
      alert('Error en la solicitud');
    }
  }
  xhr.send(JSON.stringify(productoData));

}

function existeProducto(input) {
  const id = input.value;

  if (!id || id.trim() === "") {
    input.value = "";
    alert("El código del producto no puede estar en blanco.");
    return false;
  }

  const regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z0-9]{5,15}$/;
  if (!regex.test(id)) {
    input.value = "";
    alert("El código del producto debe contener letras y números.");
    return false;
  }

  if (id.length < 5 || id.length > 15) {
    input.value = "";
    alert("El código del producto debe tener entre 5 y 15 caracteres.");
    return false;
  }


  const xhr = new XMLHttpRequest();
  xhr.open('GET', './ajax/existe_producto.php?id=' + id, true);
  xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
  xhr.onload = function () {
    if (xhr.status === 200) {
      const respuesta = JSON.parse(xhr.responseText);
      if (respuesta.estado) {
        input.value = "";
        alert("El código del producto ya está registrado.");
        return false;
      } else {
        return true;
      }
    } else {
      input.value = "";
      return false;
    }
  };
  xhr.send();
}

function validarNombre(input) {
  const nombre = input.value;
  if (!nombre || nombre.trim() === "") {
    input.value = "";
    alert("El nombre del producto no puede estar en blanco.");
    return false;
  }

  if (nombre.length < 2 || nombre.length > 50) {
    input.value = "";
    alert("El nombre del producto debe tener entre 2 y 50 caracteres.");
    return false;
  }
}

function validarPrecio(input) {
  const precio = input.value;
  if (!precio || precio.trim() === "") {
    input.value = "";
    alert("El precio del producto no puede estar en blanco.");
    return false;
  }

  const regex = /^\d+(\.\d{1,2})?$/;
  if (!regex.test(precio)) {
    input.value = "";
    alert("El precio del producto debe ser un número positivo con hasta dos decimales.");
    return false;
  }
}

function validarBodega(select) {
  const valor = select.value;
  document.getElementById('selectSucursal').innerHTML = '';
  if (valor === "0") {
    select.value = "0";
    alert("Debe seleccionar al menos dos materiales para el producto.");
    return false;
  } else {
    llegarListas('selectSucursal', sucursales);
  }
}

function validarSucursal(select) {
  const valor = select.value;
  if (valor === "0") {
    select.value = "0";
    alert("Debe seleccionar una sucursal para la bodega seleccionada.");
    return false;
  }
}

function validarMoneda(select) {
  const valor = select.value;
  if (valor === "0") {
    select.value = "0";
    alert("Debe seleccionar una moneda para el producto.");
    return false;
  }
}

function validarDescripcion(input) {
  const descripcion = input.value;
  if (!descripcion || descripcion.trim() === "") {
    input.value = "";
    alert("La descripción del producto no puede estar en blanco.");
    return false;
  }

  if (descripcion.length < 10 || descripcion.length > 1000) {
    input.value = "";
    alert("La descripción del producto debe tener entre 10 y 1000 caracteres.");
    return false;
  }
}
obtenerListas();