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
$sp->register(\Application\Queries\UserByIdQuery::class);
$sp->register(\Application\Queries\ProductsQuery::class);
$sp->register(\Application\Queries\ProductDetailsQuery::class);
$sp->register(\Application\Queries\LoggedInUserQuery::class);
$sp->register(\Application\Commands\RegisterCommand::class);
$sp->register(\Application\Commands\LoginCommand::class);
$sp->register(\Application\Commands\LogoutCommand::class);

// --- Services
$sp->register(\Application\Services\AuthenticationService::class);

// --- Infrastructure
$sp->register(\Infrastructure\Session::class, isSingleton: true);
$sp->register(\Application\Interfaces\Session::class, \Infrastructure\Session::class);

$sp->register(\Infrastructure\Repository::class,
    function () {
        return new \Infrastructure\Repository("127.0.0.1", "root", "toor", "product_rating");
    });
$sp->register(\Application\Interfaces\ProductRepository::class, \Infrastructure\Repository::class);
$sp->register(\Application\Interfaces\UserRepository::class, \Infrastructure\Repository::class);

// --- Presentation
// MVC - Framework
$sp->register(Presentation\MVC\MVC::class, function () {
    return new Presentation\MVC\MVC();
}, true);

//controllers
$sp->register(Presentation\Controllers\Home::class);
$sp->register(Presentation\Controllers\User::class);
$sp->register(Presentation\Controllers\Products::class);

// === handle requests
$sp->resolve(Presentation\MVC\MVC::class)->handleRequest($sp);
