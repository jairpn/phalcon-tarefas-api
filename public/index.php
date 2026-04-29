<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Router;
use Phalcon\Db\Adapter\Pdo\Postgresql;

// Autoload dos models e controllers
spl_autoload_register(function ($className) {
    $paths = [
        __DIR__ . '/../app/controllers/' . $className . '.php',
        __DIR__ . '/../app/models/'      . $className . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Carrega configuração
$config = require __DIR__ . '/../app/config/config.php';

// Container de dependências
$di = new FactoryDefault();

// Registra o banco de dados
$di->setShared('db', function () use ($config) {
    return new Postgresql([
        'host'     => $config->database->host,
        'port'     => $config->database->port,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
    ]);
});

// Registra a view (necessário mesmo sem templates)
$di->setShared('view', function () {
    $view = new \Phalcon\Mvc\View();
    $view->setViewsDir(__DIR__ . '/../app/views/');
    $view->disable();
    return $view;
});

// Registra as rotas
$di->setShared('router', function () {
    $router = new Router(false);

    $router->addGet(    '/tarefas',      ['controller' => 'tarefa', 'action' => 'index']);
    $router->addGet(    '/tarefas/{id}', ['controller' => 'tarefa', 'action' => 'show']);
    $router->addPost(   '/tarefas',      ['controller' => 'tarefa', 'action' => 'create']);
    $router->addPut(    '/tarefas/{id}', ['controller' => 'tarefa', 'action' => 'update']);
    $router->addDelete( '/tarefas/{id}', ['controller' => 'tarefa', 'action' => 'delete']);

    $router->notFound(['controller' => 'tarefa', 'action' => 'index']);

    return $router;
});

// Sobe a aplicação
$app = new Application($di);

echo $app->handle($_SERVER['REQUEST_URI'])->getContent();