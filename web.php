<?php

use Areuka\App\Router;

/**
 * Public
 */

// Main
Router::get("/", "MainController@indexPage");


// Login
Router::get("/login", "MainController@loginPage");
Router::post("/login", "MainController@login");

Router::get("/logout", "MainController@logout");

/**
 * Admin
 */

Router::get("/admin/sponsor", "AdminController@sponsorPage");
Router::post("/admin/sponsor", "AdminController@addSponsor");
RouteR::post("/admin/sponsor-remove/{id}", "AdminController@removeSponsor");


Router::connect();


