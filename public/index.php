<?php

session_start();

/**
 * Define
 */
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__DIR__));
define("SRC", ROOT.DS."src");
define("IMAGE", ROOT.DS."public".DS."images");


/**
 * REQUIRE
 */
require ROOT.DS."autoload.php";
require ROOT.DS."helper.php";
require ROOT.DS."web.php";