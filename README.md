<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Survey Creator

## Introduction

This is a simple project of an SPA application showcasing basic CRUD functionality. Most attention was given in implementing the backend API in Laravel while the frontend is a basic template in Vue serving as an interface for cheking the API

The following versions of software/packages where used, make sure you have them on your set up:
```
PHP 8.0.3 (cli)
```
```
Composer version 2.0.11
```
```
Laravel Framework 8.31.0
```
```
npm 7.6.1
```
```
Vue 2.6.12
```
```
mysql  Ver 8.0.23
```


## Set up
With the ```setUp.sql``` file, located at root directory,
Run ``` sudo mysql < setUp.sql ```. This sets up a database and a test user for our application.

To render and serve our frontend, run:  
``` npm install vue ``` then ``` npm run dev ```.  
If prompted to run the mix again, just run ``` npm run dev ``` for a second time.

Run ``` composer update ``` this patches our packages so we can run laravel framework  
Now for our backend set up, run:  
``` php artisan migrate ``` to create our tables.  
After that, ``` php artisan db:seed --class=SurveySeeder ``` to provide us dummy data  
Finally start our server with ``` php artisan serve ```

Our application is now running on localhost, navigate there and you can use it.
