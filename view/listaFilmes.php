<div id="content">
        <?php if (isset($_SESSION['msg'])):?>
            <div id="msg"><?php echo $_SESSION['msg']; unset($_SESSION['msg'])?></div>
        <?php endif;?>
        <div class="list_title"><h2>Filmes cadastrados</h2></div>
        <div id="search" >
                <form method="post" action="/index.php?m=filme&a=listar">
                        <div>
                            <label for="filtro">Pesquisar:</label>
                                <input type="text" name="filtro" id="filtro" value="<?php echo $filtro?>" />
                                <input type="submit" id="search-submit" value="OK" />
                        </div>
                </form>
        </div>
        <div style="clear: both;">&nbsp;</div>
        <?php foreach ($filmesBanco as $filme):?>
            <div class="post">
                <div class="entry div_left">
                    <img class="top" src="<?php echo $filme['imagem']?>">
                </div>
                <div class="div_right">
                    <h2 class="title"><a href="#"><?php echo $filme['titulo']?></a></h2>
                    <p class="meta">
                        <span class="date"><strong>Genero:</strong><?php echo $filme['genero']?></span>
                        <span class="posted"><strong>Título Original:</strong><?php echo $filme['titulo_original']?></span>
                    </p>
                    <div style="clear: both;">&nbsp;</div>
                    <p><?php echo htmlentities($filme['sinopse'])?></p>
                    <span class="date"><a href="<?php echo $filme['url']?>" target="blank">Ver informa&ccedil;&otilde;es no site IMDb</a></span>
                </div>
            </div>
        <?php endforeach;?>

        <?php if (count($filmesDiretorio) > 0):?>
            <div class="list_title">
                <h2>Filmes do diret&oacute;rio que n&atilde;o est&atilde;o na base <a href="/index.php?m=filme&a=atualizarTodos">&nbsp;&nbsp;(atualizar todos)</a></h2>
            </div>
            <div style="clear: both;">
                <?php foreach ($filmesDiretorio as $chave => $valor):?>
                    <span class="lista_diretorio">
                        <strong><?php echo $valor?></strong>
                        <a href="/index.php?m=filme&a=atualizar&filme=<?php echo urlencode($valor)?>">&nbsp;&nbsp;(atualizar)</a>
                    </span>
                    <?php if (isset($_SESSION['listaOpcoes'][$valor])):?>
                        <ul>
                            <?php foreach ($_SESSION['listaOpcoes'][$valor] as $opcao):?>
                                <li>
                                    <?php echo $opcao['nome']?>&nbsp;&nbsp;
                                    <a href="/index.php?m=filme&a=atualizarPorURL&filme=<?php echo urlencode($opcao['titulo_pesquisa'])?>&url=<?php echo urlencode($opcao['url'])?>">atualizar</a>&nbsp;&nbsp;
                                    <a href="http://www.imdb.com<?php echo $opcao['url']?>" target="_blank">ver (IMDb)</a>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
        <?php endif;?>
</div>