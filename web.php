<?php

use Areuka\App\Router;

Router::get("/", "MainController@index");
Router::get("/list/{id}", "MainController@index");

Router::connect();
