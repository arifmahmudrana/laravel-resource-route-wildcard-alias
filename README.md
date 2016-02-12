# :Laravel 5 Resource Route Wildcard Alias

## Usage

### Step 1: Install Through Composer

```
composer require arifmahmudrana/laravel-resource-route-wildcard-alias
```

### Step 2: Add the Service Provider

Add service providers to  `providers` array in `config/app.php`. Like so:

```php
AriMahmudRana\laravelResourceRouteWildcardAlias\LaravelResourceRouteWildcardAliasServiceProvider::class
```
and that's it.

## Examples

Create resource routes with aliases.

```php
Route::group(['middleware' => ['web']], function () {
    Route::resource('album.photo.hello', 'PhotoController', ['alias' => ['album' => 'a', 'photo' => 'p', 'hello' => 'h']]);
});
```
and the output in `php artisan route:list` is.
```
+--------+-----------+------------------------------------+---------------------------+----------------------------------------------+------------+
| Domain | Method    | URI                                | Name                      | Action                                       | Middleware |
+--------+-----------+------------------------------------+---------------------------+----------------------------------------------+------------+
|        | GET|HEAD  | /                                  |                           | Closure                                      |            |
|        | POST      | album/{a}/photo/{p}/hello          | album.photo.hello.store   | App\Http\Controllers\PhotoController@store   | web        |
|        | GET|HEAD  | album/{a}/photo/{p}/hello          | album.photo.hello.index   | App\Http\Controllers\PhotoController@index   | web        |
|        | GET|HEAD  | album/{a}/photo/{p}/hello/create   | album.photo.hello.create  | App\Http\Controllers\PhotoController@create  | web        |
|        | DELETE    | album/{a}/photo/{p}/hello/{h}      | album.photo.hello.destroy | App\Http\Controllers\PhotoController@destroy | web        |
|        | PUT|PATCH | album/{a}/photo/{p}/hello/{h}      | album.photo.hello.update  | App\Http\Controllers\PhotoController@update  | web        |
|        | GET|HEAD  | album/{a}/photo/{p}/hello/{h}      | album.photo.hello.show    | App\Http\Controllers\PhotoController@show    | web        |
|        | GET|HEAD  | album/{a}/photo/{p}/hello/{h}/edit | album.photo.hello.edit    | App\Http\Controllers\PhotoController@edit    | web        |
+--------+-----------+------------------------------------+---------------------------+----------------------------------------------+------------+

```
    
## License

Released under the MIT License, see LICENSE.