<?php
class Controlador 
{
    private $titulo;
    private $mensagem;
 
    public function setTemplate($template, $vars = array())
    {
        foreach ($vars as $var => $valor)
            $$var = $valor;
        
        $titulo = $this->titulo;
        $mensagem = $this->mensagem;
        include '../view/template.php';
    }
    
    public function redirect($acao)
    {
        $classe = strtolower(get_class($this));
        $m = substr($classe, 0, strpos($classe, 'controlador'));
    
        header('Location: /?m='.$m.'&a='.$acao);
    }
    
    public function __call($metodo, $args)
    {
        if (method_exists($this, $metodo))
            $this->$metodo();
        else
            die("ERRO: Pagina nao encontrada! Este metodo nao existe ($metodo)");
    }
    
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;
    }
}