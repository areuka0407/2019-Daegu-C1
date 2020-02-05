<?php

use Areuka\App\Router;

/**
 * Public
 */

// Main
Router::get("/", "MainController@indexPage");
Router::get("/about", "MainController@aboutPage");


// Request
Router::get("/request", "MainController@requestPage");
Router::post("/request", "MainController@addRequest");

// Reserve
Router::get("/reserve", "MainController@reservePage");
Router::post("/reserve", "MainController@addReserve");
Router::post("/reserve/list", "MainController@getReserveList");


// Login
Router::get("/login", "MainController@loginPage");
Router::post("/login", "MainController@login");

Router::get("/logout", "MainController@logout");


// AJAX
Router::post("/movie-list/by-cinema/{cinema_id}", "MainController@getMovieListByCinema");

/**
 * Admin
 */

// Sponsor
Router::get("/admin/sponsor", "AdminController@sponsorPage");
Router::post("/admin/sponsor", "AdminController@addSponsor");
RouteR::post("/admin/sponsor-remove/{id}", "AdminController@removeSponsor");

// Official
Router::get("/admin/official", "AdminController@officialPage");
Router::post("/admin/official", "AdminController@addOfficial");
Router::post("/admin/official-remove/{id}", "AdminController@removeOfficial");

// Request
Router::get("/admin/request", "AdminController@requestPage");
Router::post("/admin/request/{id}", "AdminController@getRequest");
Router::get("/admin/request-apply/{id}", "AdminController@applyRequest");
Router::get("/admin/request-return/{id}", "AdminController@returnRequest");

// Timetable
Router::get("/admin/timetable", "AdminController@timetablePage");
Router::post("/admin/timetable/{type}/{id}", "AdminController@addSchedule");
Router::post("/admin/timetable-list", "AdminController@getTimetable");

// Cinema
Router::get("/admin/cinema", "AdminController@cinemaPage");
Router::post("/admin/cinema", "AdminController@addCinema");
Router::get("/admin/cinema-remove/{id}", "AdminController@removeCinema");
Router::post("/admin/cinema-list", "AdminController@getCinemaList");


Router::connect();



