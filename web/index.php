<?php
session_start();

//função outoload do projeto
function filmes_autoload($nome_da_classe)
{
    $arquivo = $nome_da_classe.'.php';
    if (file_exists('../controller/'.$arquivo))
        include '../controller/'.$arquivo;
    elseif (file_exists('../model/'.$arquivo))
        include '../model/'.$arquivo;
    elseif (file_exists('../lib/'.$arquivo))
        include '../lib/'.$arquivo;
    elseif (file_exists('../dao/'.$arquivo))
        include '../dao/'.$arquivo;
    else
        die('ERRO: Classe nao encontrada!');
}

//Includes necessários para utilizar o YAML
include '../lib/Yaml/Yaml.php';
include '../lib/Yaml/Parser.php';
include '../lib/Yaml/Inline.php';

//Biblioteca do SimpleHtmlDom
include '../lib/simple_html_dom.php';

Use Symfony\Component\Yaml\Yaml;

//registra a função autoload do projeto
spl_autoload_register('filmes_autoload'); 

//pega informações do arquivo de configurações
try 
{
    $config = Yaml::parse('../config/config.yml');
    define('FILM_DIRECTORY', $config['project_configuration']['directory']);
    /*if (!is_dir(FILM_DIRECTORY))
    {
        die('Diret&oacute;rio de filmes inv&aacute;lido!');
    }*/
    define('DBNAME', $config['database']['dbname']);
    define('HOST', $config['database']['host']);
    define('DRIVER', $config['database']['driver']);
    define('USER', $config['database']['user']);
    define('PWD', $config['database']['password']);
}
catch (ParseException $e) 
{
    printf("Não foi possível ler o arquivo de configuração! Erro: %s", $e->getMessage());
}
define('PROJECT_PATH', __DIR__);

$modulo = Util::getParam('m', 'filme');
$acao = Util::getParam('a', 'listar');

$classe = ucfirst(strtolower($modulo)) . 'Controlador';
$controlador = new $classe();
$controlador->$acao();