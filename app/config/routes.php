<?php
use \Phalcon\Mvc\Micro\Collection as MicroCollection;

$routes = [];

$filmes = new MicroCollection();
$filmes->setHandler(new FilmesController()); // Set the main handler. ie. a controller instance
$filmes->get('/filmes', 'index');
$filmes->get('/filmes/consultar/{filme}', 'show');
$filmes->post('/filmes/adicionar', 'add');
$filmes->put('/filmes/atualizar/{filme}', 'update');
$filmes->delete('/filmes/deletar/{filme}', 'delete');

$routes[] = $filmes;
return $routes;