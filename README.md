# laravel-response

基于laravel封装的response类

## 这个包的目的是？
在项目开发时，由于获取数据方式不同(ORM、DB、自定义...)，会出现返回格式不统一的情况。  
如果使用laravel自带的API资源(Resource)可以完美解决这个问题。  
但，并不是每一个资源都需要去创建Resource的。  
所以这个package的目的就是为了确保常见场景下，返回格式统一，保证唯一性。  

## 如何使用
```php
//通过composr安装package
composer require sunnanbei/laravel-response
```
```php
use NanBei\Response\Facades\Response;
```
```php
//请求成功，输出数据，返回200
return Response::success($data);
```
```php
//请求失败，系统异常，返回500
return Response::error();
```
```php
//请求失败，返回200
return Response::fail();
```
```php
//请求成功，返回201
return Response::created();
```
```php
//请求成功，返回204
return Response::noContent();
```
```php
//请求成功，返回403
return Response::forbidden();
```
```php
//请求成功，返回404
return Response::notFound();
```
