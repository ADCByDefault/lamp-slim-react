<?php

use Slim\Factory\AppFactory;

include("./controllers/SiteController.php");
include("./controllers/AlunniController.php");

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

//GET

$app->get('/',"SiteController:index");
$app->get('/alunni',"AlunniController:index");
$app->get('/alunni/',"AlunniController:index");
$app->get('/alunni/{cf}',"AlunniController:show");
$app->get('/alunni/{cf}/',"AlunniController:show");

//POST

$app->post('/alunni',"AlunniController:create");
$app->post('/alunni/',"AlunniController:create");

//PUT

$app->put('/alunni/{cf}',"AlunniController:update");
$app->put('/alunni/{cf}/',"AlunniController:update");

//DELETE

$app->delete('/alunni/{cf}',"AlunniController:delete");
$app->delete('/alunni/{cf}/',"AlunniController:delete");

$app->run();
