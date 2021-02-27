# API Librería

Para este proyecto se utilizaron los siguientes métodos de petición HTTP.

| Método HTTP | Descripción                      |
| ----------- | -------------------------------- |
| GET         | Recupera una lista de registros. |
| GET/1       | Recupera un registros con ID 1.  |
| POST        | Crea un nuevo registro.          |
| PUT/1       | Actualiza un registro con ID 1.  |
| DELETE/1    | Elimina un registro con ID 1.    |

# Probar API

Para probar el API puede usar [Insomnia](https://insomnia.rest/download/), y configurar las peticiones dependiendo de la ruta del proyecto.

## Libro

**1.** Obtener libros: **GET : http://localhost/API_Library/book**

**2.** Obtener libros por ID : **GET : http://localhost/API_Library/book/100**

**3.** Nuevo libro : **POST: http://localhost/API_Library/book**

> En el cuerpo del json colocar la siguiente estructura.

```json
{
  "name": "New book",
  "pages": 250,
  "point": 99,
  "authorCode": 15,
  "typeCode": 18
}
```

**4.** Actualizar libro: **PUT http://localhost/API_Library/book/100**

> En el cuerpo del json colocar la siguiente estructura.

```json
{
  "name": "Update book",
  "pages": 250,
  "point": 99,
  "authorCode": 15,
  "typeCode": 18
}
```

**5.** Eliminar libro: **DELETE : http://localhost/API_Library/book/100**

## Autor

**1.** Obtener autores: **GET : http://localhost/API_Library/author**

**2.** Obtener autor por ID : **GET : http://localhost/API_Library/author/100**

**3.** Nuevo author: **POST: http://localhost/API_Library/author**

> En el cuerpo del json colocar la siguiente estructura.

```json
{
  "name": "primer nombre",
  "surname": "primer apellido"
}
```

**4.** Actualizar author: **PUT http://localhost/API_Library/author/100**

> En el cuerpo del json colocar la siguiente estructura.

```json
{
  "name": "actualizar nombre",
  "surname": "actualizar apellido"
}
```

**5.** Eliminar author: **DELETE : http://localhost/API_Library/author/100**

Estudiante

{
"name": "nombre",
"surname": "apellido",
"birthday": "2020-01-01",
"gender": "M",
"point": 200,
"class": "AB"
}


Borrow
localhost/API_Library/borrow/6376
localhost/API_Library/borrow





    {
      "studentCode": 400,
      "bookCode": 105,
      "broughtDate": "2001-05-01",
      "takenDate": "2002-07-04"
    }


Date
    {


      "initialDate": "2015-01-01",
      "finalDate": "2016-01-01"
    }
