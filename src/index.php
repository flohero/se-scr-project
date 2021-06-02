<?php


spl_autoload_register(function ($class) {
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});


// === register services
$sp = new \ServiceProvider();

// --- Infrastructure
$sp->register(\Infrastructure\Session::class, isSingleton: true);
$sp->register(\Application\Interfaces\Session::class, \Infrastructure\Session::class);

// --- Presentation
// MVC - Framework
$sp->register(Presentation\MVC\MVC::class, function () {
    return new Presentation\MVC\MVC();
}, true);

//controllers
$sp->register(Presentation\Controllers\Home::class);
$sp->register(Presentation\Controllers\Login::class);

// === handle requests
$sp->resolve(Presentation\MVC\MVC::class)->handleRequest($sp);
