<?php

class FilmeDAO extends DAO
{
    
    public static function getFilme($id)
    {
        $pdo = self::getConn();

        $st = $pdo->prepare('SELECT id,
                                    titulo,
                                    titulo_original,
                                    titulo_pesquisa,
                                    url,
                                    ano,
                                    genero,
                                    sinopse,
                                    imagem FROM filmes WHERE id = ?');
        $st->bindParam(1, $id);
        if ($st->execute())
            return $st->fetch(PDO::FETCH_ASSOC);

        return null;
    }
    
    public static function getFilmes($col = null, $ordem = 'ASC', $filtro = null)
    {
        $pdo = self::getConn();

        $order_by = ' ORDER BY '.$col.' '.$ordem;
        $sql = 'SELECT id,
                        titulo,
                        titulo_original,
                        titulo_pesquisa,
                        url,
                        ano,
                        genero,
                        sinopse,
                        imagem FROM filmes ';
        if (!is_null($filtro) && !empty($filtro))
        {
            $sql .= " where (titulo like '%$filtro%' 
                      or titulo_original like '%$filtro%'
                      or titulo_pesquisa like '%$filtro%'
                      or genero like '%$filtro%')";
        }
        $sql .= (empty($col)) ? '' : $order_by;
        $st = $pdo->query($sql);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function incluir($filme)
    {
        $pdo = self::getConn();

        $sql = 'insert into filmes (titulo, titulo_original, titulo_pesquisa, url, ano, genero, sinopse, imagem) values (:titulo, :titulo_original, :titulo_pesquisa, :url, :ano, :genero, :sinopse, :imagem)';
        $st = $pdo->prepare($sql);
        $st->bindParam(':titulo', $filme['titulo']);
        $st->bindParam(':titulo_original', $filme['titulo_original']);
        $st->bindParam(':titulo_pesquisa', $filme['titulo_pesquisa']);
        $st->bindParam(':url', $filme['url']);
        $st->bindParam(':ano', $filme['ano']);
        $st->bindParam(':genero', $filme['genero']);
        $st->bindParam(':sinopse', $filme['sinopse']);
        $st->bindParam(':imagem', $filme['imagem']);
        return $st->execute();
    }
    
    public static function getFilmeByTituloPesquisa($tituloPesquisa)
    {
        $pdo = self::getConn();

        $st = $pdo->prepare('SELECT id,
                                    titulo,
                                    titulo_original,
                                    titulo_pesquisa,
                                    url,
                                    ano,
                                    genero,
                                    sinopse,
                                    imagem FROM filmes WHERE titulo_pesquisa = ?');
        $st->bindParam(1, $tituloPesquisa);
        if ($st->execute())
            return $st->fetch(PDO::FETCH_ASSOC);

        return null;
    }
}