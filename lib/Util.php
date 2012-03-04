<?php

class Util
{

    public static function getParam($nome, $padrao = null)
    {
        return isset($_GET[$nome]) ? $_GET[$nome] : $padrao;
    }
    
    public static function postParam($nome, $padrao = null)
    {
        return isset($_POST[$nome]) ? $_POST[$nome] : $padrao;
    }

    public static function preparaNomeArquivo($nome) {
        return str_replace(array("\\", "/", "?", ":", "*", "\"", ">", "<", "|"), array("","","","","","","","",""), $nome); 
    }
}
