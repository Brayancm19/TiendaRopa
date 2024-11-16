<h1>Proyecto 2</h1>
<h2>Curso: Desarrollo con Plataformas abiertas</h2> 
<h2>Brayan Josué Chacón Molina</h2>

<img src="Diagrama.png" alt="Logo" class="logo">

<hr>
<h3>Obtener todas las marcas</h3> 
Método: GET

URL: http://localhost/TiendaRopa/API/public/index.php/marcas

<hr>

<h3>Crear una nueva marca</h3> 
Método: POST

URL: http://localhost/TiendaRopa/API/public/index.php/marcas

{
  "nombre": "NuevaMarca"
}
<hr>

<h3>Actualizar una marca</h3> 
Método: PUT

URL: http://localhost/TiendaRopa/API/public/index.php/marcas

{
  "id": 1,
  "nombre": "MarcaActualizada"
}
<hr>

<h3>Eliminar una marca</h3>
Método: DELETE

URL: http://localhost/TiendaRopa/API/public/index.php/marcas 

{
  "id": 1
}
<hr>

<h3>Obtener todas las prendas</h3> 
Método: GET

URL: http://localhost/TiendaRopa/API/public/index.php/prendas

<hr>

<h3>Crear una nueva prenda</h3> 
Método: POST

URL: http://localhost/TiendaRopa/API/public/index.php/prendas

{
  "nombre": "NuevaPrenda",
  "talla": "M",
  "cantidad_stock": 100,
  "marca_id": 1
}
<hr>

<h3>Obtener todas las ventas</h3> 
Método: GET

URL: http://localhost/TiendaRopa/API/public/index.php/ventas

<hr>

<h3>Crear una nueva venta</h3> 
Método: POST

URL: http://localhost/TiendaRopa/API/public/index.php/ventas

{
  "prenda_id": 1,
  "cantidad": 10,
  "fecha": "2024-10-01"
}