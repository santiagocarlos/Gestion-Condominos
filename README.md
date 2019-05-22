# Gestión Condomininos
Aplicación web para gestión de condominios. 
## Instalación

### Requerimientos
* Linux/Windows
* PHP 7.0
* Composer version 1.7.*
* nodejs v8.*
* MySQL/mariaDB v10.3.*
* phpMyAdmin
* Laravel 5

### Dependencias

Ejecutar

```composer install```

## Uso

Crear una base de datos en MySQL/mariaDB llamada gestion_condominios.

Modificar en archivo .env las siguientes variables globales

```
DB_DATABASE=gestion_condominios
DB_USERNAME=(nombre de usuario de la BD)
DB_PASSWORD=(password)
```
Una vez hecho esto iniciar el servidor de laravel
 
```php artisan serve```


Luego ejecutar las migraciones con los seeders

```php artisan migrate --seed```

Se crearán las tablas en la base de datos.


## Rutas

En el archivo de rutas /routes/web.php 

se encuentran las rutas de todo el sistema.

Para la primera configuración se usan estas rutas:

```
  Route::get('admin/config/towers', ['as' => 'configTowersInitial', 'uses' => 'AdminConfigInitialController@index']);
  Route::post('registerTowers', ['as' => 'registerTowers', 'uses' => 'AdminConfigInitialController@storeTowers']);

  Route::get('admin/config/apartment-admin', ['as' => 'apartAdmin', 'uses' => 'AdminConfigInitialController@apartAdmin']);
  Route::post('registerApartAdmin', ['as' => 'registerApartAdmin', 'uses' => 'AdminConfigInitialController@registerApartAdmin']);
  ```

Ingresar en

localhost:8000/register

Para obtener la primera vista del proceso de configuración del sistema.
