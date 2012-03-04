<?php
class FilmeControlador extends Controlador 
{
    public function listar() 
    {
        $filtro = Util::postParam('filtro');
        $filmesBanco = FilmeModel::listar($filtro);
        $filmesDiretorio = array();
        if (is_dir(FILM_DIRECTORY)) {
            $filmesDiretorio = FilmeModel::listarDiretorio();
            sort($filmesDiretorio, SORT_STRING);
        }
        $this->setTitulo("Filmes");
        $this->setMensagem("Já assistiu? Não? Então encontre um filme que te agrade e assista!!");
        $this->setTemplate('listaFilmes', array('filmesBanco'=>$filmesBanco, 'filmesDiretorio'=>$filmesDiretorio, 'filtro'=>$filtro));
    }
    
    public function atualizarTodos() 
    {
        set_time_limit('3600');
        $filmesDiretorio = FilmeModel::listarDiretorio();
        FilmeModel::recuperarFilmes($filmesDiretorio);
        set_time_limit('30');
        header('Location: index.php');
    }

    public function atualizar() 
    {
        $filmePesquisa = Util::getParam('filme');
        /*$_SESSION['msg'] = 'Filme atualizado com sucesso!';
        if (!FilmeModel::recuperarFilme($filmePesquisa)) 
        {
            $_SESSION['msg'] = 'Filme n&atilde;o econtrado!';
        }*/
        FilmeModel::recuperarFilme($filmePesquisa);
        header('Location: index.php');
    }
    
    public function atualizarPorURL() 
    {
        $url = 'http://www.imdb.com'.urldecode(Util::getParam('url'));
        $filmePesquisa = Util::getParam('filme');
        /*$_SESSION['msg'] = 'Filme atualizado com sucesso!';
        if (!FilmeModel::recuperarPorUrlIMDB($url,$filmePesquisa)) 
        {
            $_SESSION['msg'] = 'Filme n&atilde;o econtrado!';
        }*/
        FilmeModel::recuperarPorUrlIMDB($url,$filmePesquisa);
        header('Location: index.php');
    }
}
