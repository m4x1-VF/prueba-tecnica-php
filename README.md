# Emais Technical Test

## Descripción

Sistema de gestión de una colección de VHS en el cual se pueda dar de alta una película, editarla, eliminarla y listarla. Para almacenar los datos se utilizará una base de datos de MariaDB. Para el alta de la película se pasará por parámetro el nombre de la película y el id en la base de datos de moviedb. Con el id de moviedb se obtendrán los detalles de la película haciendo una consulta a la siguiente API:

```
https://developer.themoviedb.org/reference/movie-popular-list

```

Para obtener los ID's de moviedb se debe realizar una consulta al siguiente endpoint:

```
https://api.themoviedb.org/3/movie/popular?api_key=<<api_key>>&language=en-US&page=1

```

## Endpoints

- **Listar todas las películas (GET)**

  - 'http://localhost:8000//movie'

- **Añadir una película (POST)**

  - 'http://localhost:8000//movie/add'

- **Lista una película (GET)**

  - 'http://localhost:8000//movie/{id}

- **Modificar una película (PUT)**

  - 'http://localhost:8000//movie/{id}

- **Borrar una película (DELETE)**
  - 'http://localhost:8000//movie/{id}

## Tecnologías

- Sympfony 6
- PHP 8+
- MariaDB
- Doctrine

## Repositorio

```
https://github.com/m4x1-VF/prueba-tecnica-php

```
