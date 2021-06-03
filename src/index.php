<?php


use Infrastructure\Connection;

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});


// === register services
$sp = new \ServiceProvider();

// --- Application
$sp->register(\Application\Queries\ProductsQuery::class);

// --- Infrastructure
$sp->register(\Infrastructure\Session::class, isSingleton: true);
$sp->register(\Application\Interfaces\Session::class, \Infrastructure\Session::class);

$sp->register(Connection::class,
    function () {
        return new Connection("localhost", "root", "toor", "product_rating");
    },
    isSingleton: true);

$sp->register(\Infrastructure\Repository::class);
$sp->register(\Application\Interfaces\ProductRepository::class, \Infrastructure\Repository::class);

// --- Presentation
// MVC - Framework
$sp->register(Presentation\MVC\MVC::class, function () {
    return new Presentation\MVC\MVC();
}, true);

//controllers
$sp->register(Presentation\Controllers\Home::class);
$sp->register(Presentation\Controllers\Login::class);
$sp->register(Presentation\Controllers\Products::class);

// === handle requests
$sp->resolve(Presentation\MVC\MVC::class)->handleRequest($sp);
