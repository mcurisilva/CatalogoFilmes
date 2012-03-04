<?php

class FilmeModel {

    public static function listar($filtro) {
        return FilmeDAO::getFilmes('titulo', 'ASC', $filtro);
    }

    public static function listarDiretorio() {
        $filmes = array();
        $iterator = new DirectoryIterator(FILM_DIRECTORY);
        foreach ($iterator as $fileinfo) {
            $filme = FilmeDAO::getFilmeByTituloPesquisa($fileinfo->getFilename());
            if ($fileinfo->isDir() && !$fileinfo->isDot() && empty($filme)) {
                $filmes[] = $fileinfo->getFilename();
            }
        }
        return $filmes;
    }

    public static function recuperarFilme($nomeFilme) {
        $url = 'http://www.imdb.com/find?s=all&q=' . urlencode($nomeFilme);
        $tuCurl = curl_init();
        curl_setopt($tuCurl, CURLOPT_URL, $url);
        curl_setopt($tuCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($tuCurl, CURLOPT_HEADER, true);
        //CURLOPT_AUTOREFERER    => true
        //CURLOPT_FOLLOWLOCATION => true,
        $retorno = curl_exec($tuCurl);
        $info = curl_getinfo($tuCurl);

        if ($info['http_code'] == 302) {
            $redirectUrl = !isset($info['redirect_url']) ? FilmeModel::get_redirect_url($retorno) : $info['redirect_url'];
            return FilmeModel::recuperarPorUrlIMDB($redirectUrl, $nomeFilme);
        } elseif ($info['http_code'] == 200) {
            $opcoes = FilmeModel::recuperarOpcoes($retorno, $nomeFilme);
            $_SESSION['listaOpcoes'][$nomeFilme] = $opcoes;
        } else {
            $_SESSION['msg'] = 'Não foi possível acessar a página do IMDB';
        }
        curl_close($tuCurl);
    }

    public static function recuperarPorUrlIMDB($url, $nomeFilme) {
        $tuCurl = curl_init();
        curl_setopt($tuCurl, CURLOPT_URL, $url);
        curl_setopt($tuCurl, CURLOPT_RETURNTRANSFER, true);
        $retorno = curl_exec($tuCurl);
        $info = curl_getinfo($tuCurl);
        curl_close($tuCurl);
        if ($info['http_code'] == 200) {
            $filme = FilmeModel::processarFilmeDaPagina($retorno, $nomeFilme);
            $filme['url'] = $url;
            $filme['titulo_pesquisa'] = $nomeFilme;
            if (FilmeDAO::incluir($filme)) {
                $_SESSION['msg'] = 'Filme atualizado com sucesso!';
            } else {
                $_SESSION['msg'] = 'Ocorreu um erro ao atualizar o filme!';
            }
        } else {
            $_SESSION['msg'] = 'Não foi possível acessar a página do IMDB';
        }
    }

    public static function processarFilmeDaPagina($pagina, $nomeFilme) {
        //ano -> <a href="/year/*
        //titulo original -> span class="title-extra"
        //sinopse -> <p itemprop="description">
        //genero -> href="/genre/*
        //title -> <title>

        $filme = array();

        $html = str_get_html($pagina);

        //recupera o titulo original
        $titulo_original = $html->find('.title-extra');
        $filme['titulo_original'] = $titulo_original[0]->innertext;
        $filme['titulo_original'] = trim(str_replace('<i>(original title)</i>', '', $filme['titulo_original']));

        //recupera a sinopse
        $sinopse = $html->find('p[itemprop=description]');
        $filme['sinopse'] = $sinopse[0]->innertext;

        //recupera o genero
        $genero = $html->find('a[href^=/genre/]');
        $filme['genero'] = $genero[0]->innertext;

        //recupera o titulo
        $titulo = $html->find('title');
        //$filme['titulo'] = html_entity_decode($titulo[0]->innertext);
        $filme['titulo'] = $titulo[0]->innertext;
        $filme['titulo'] = str_replace(' - IMDb', '', $filme['titulo']);
        $filme['titulo'] = str_replace('IMDb - ', '', $filme['titulo']);

        //recupera o titulo
        $ano = $html->find('a[href^=/year/]');
        $filme['ano'] = $ano[0]->innertext;

        //recupera a imagem
        $imagem = $html->find('img[alt*=Poster]');
        $filme['imagem'] = '';
        if (!empty($imagem)) {
            $nome_imagem = Util::preparaNomeArquivo($nomeFilme);
            $filme['imagem'] = "/images/filmes/$nome_imagem.jpg";
            FilmeModel::copiarImagem($imagem[0]->getAttribute('src'), $filme['imagem']);
        }

        return $filme;
    }

    public static function recuperarOpcoes($pagina, $nomeFilme) {
        $html = str_get_html($pagina);
        $opcoes = $html->find('table tr td a[href^=/title/]');
        $listaOpcoes = array();
        foreach ($opcoes as $opcao) {
            if (strpos($opcao->innertext, '<img') === false) {
                $listaOpcoes[] = array('nome' => $opcao->innertext, 'url' => $opcao->getAttribute('href'), 'titulo_pesquisa' => $nomeFilme);
            }
        }
        return $listaOpcoes;
    }

    public static function copiarImagem($urlImagem, $imagemDestino) {
        //$imagemDestino = str_replace("/", "\\", $imagemDestino);
        $fp = fopen(PROJECT_PATH . $imagemDestino, 'c');
        $ch = curl_init($urlImagem);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        $data = curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }

    public static function recuperarFilmes($filmes) {
        foreach ($filmes as $filme) {
            FilmeModel::recuperarFilme($filme);
        }
    }

    public static function get_redirect_url($header) {
        if (preg_match('/^Location:\s+(.*)$/mi', $header, $m)) {
            return trim($m[1]);
        }

        return "";
    }

}

?>