<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Catálogo de Filmes</title>
		<link href="/css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
		<link href="http://fonts.googleapis.com/css?family=Ruthie" rel="stylesheet" type="text/css" />
	</head>
	<body>
	<div id="wrapper">
		<div id="wrapper-bgtop">
			<div id="wrapper-bgbtm">

				<!-- #header -->
				<div id="header" class="container">
					<div id="logo">
						<h1><a href="#"><?php echo $titulo ?></a></h1>
						<p><?php echo $mensagem ?></p>
						<!--<h1><a href="#">Sugestões</a></h1>
						<p>Não encontrou o filme que procurava? Então deixe a sugestão para inclusão no catálogo aqui!</p>-->
					</div>
					<div id="menu">
						<ul>
							<li class="current_page_item"><a href="#">Filmes</a></li>
							<li><a href="#">Sugestões</a></li>
							<li><a href="#">Configurações</a></li>
						</ul>
					</div>
				</div>
				<!-- end #header -->

				<div id="page" class="container">
					<!-- #content -->
                                        <?php include "../view/$template.php"; ?>
					<!-- end #content -->
				</div>
				<!-- end #page -->
			</div>
		</div>
	</div>
	<div id="footer">
		<p>Design by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.</p>
	</div>
	<!-- end #footer -->
	</body>
</html>
