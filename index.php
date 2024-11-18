<?php
require_once 'config/Database.php';
require_once 'app/Router/Router.php';

// Instancia o roteador
$router = new Router();

// Define as rotas
$router->add('home', 'HomeController@index');
$router->add('obterFormularios', 'HomeController@obterFormularios');
$router->add('obterCamposFormularios', 'HomeController@obterCamposFormularios');
$router->add('formulario', 'HomeController@formulario');
$router->add('enviarRespostas', 'HomeController@enviarRespostas');
$router->add('carregarRelatoriosPorId', 'AdminController@carregarRelatoriosPorId');
$router->add('login', 'AdminController@index');
$router->add('logout', 'AdminController@logout');
$router->add('logoutInatividade', 'AdminController@logoutInatividade');
$router->add('usuarios', 'AdminController@getUsuarios');
$router->add('SalvarUsuario', 'AdminController@salvarUsuario');
$router->add('carregarRespostasFormularioId', 'AdminController@carregarRespostasFormularioId');

// Captura a URL e os parâmetros de query string
$url = $_GET['url'] ?? 'home';
$params = $_GET;

// Processa a rota
$router->dispatch($url);
