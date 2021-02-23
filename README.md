# API Librería

Para este proyecto se utilizaron los siguientes  métodos de petición HTTP.

|  Método HTTP|Descripción  |
|--|--|
| GET |Recupera una lista de registros.|
| GET/1|Recupera un registros con ID 1.|
| POST| Crea un nuevo registro.|
| PUT/1|  Actualiza un registro con ID 1.|
| DELETE/1|Elimina un registro con ID 1.|


# Probar API
Para probar el API puede usar [Insomnia](https://insomnia.rest/download/), y configurar las  peticiones dependiendo de la ruta del proyecto.


## Libro

**1.**  Obtener libros: **GET :  http://localhost/API_Library/book**
**2.**  Obtener libros por ID : **GET :  http://localhost/API_Library/book/100**
**3.**  Nuevo libro : **POST:  http://localhost/API_Library/book**
> En el cuerpo del json colocar la siguiente estructura.
```json
{
	"name"        :  "New book",
	"pages"       :  250,
	"point"       :  99,
	"authorCode"  :  15,
	"typeCode"    :  18
}
```
**4.**  Actualizar libro: **PUT    http://localhost/API_Library/book/100**
> En el cuerpo del json colocar la siguiente estructura.

```json
{
	"name"        :  "Update book",
	"pages"       :  250,
	"point"       :  99,
	"authorCode"  :  15,
	"typeCode"    :  18
}
```
**5.**  Eliminar libro: **DELETE :  http://localhost/API_Library/book/100**
