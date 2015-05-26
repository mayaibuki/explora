<!--Website coded by www.mayaibuki.me – Some rights reserved, most photos are under some creative commons license-->
<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include $root.'/_contenido/_header.php';
?>
<title>explora.life – Felicidad y libertad sexual</title>

<meta name="description" content="Explora.life promueve el entendimiento y la exploración de sexo sano por medio de sex toys y educación sexual">
<!--Opengrph-->
<meta property="og:title" content="Felicidad y libertad sexual" />
<meta property="og:site_name" content="Explora.life"/>
<meta property="og:url" content="http://explora.life" />
<meta property="og:description" content="Promovemos la felicidad, la igualdad y la libertad sexual en Latino America, impulsando el entendimiento y la exploracion de relaciones sanas y consensuales" />
<meta property="og:image" content="http://explora.life/_img_website/hero_facebookthumb.jpg" />

<!-- twitter-->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@explora_life">
<meta name="twitter:creator" content="@explora_life">
<meta name="twitter:title" content="Felicidad y libertad sexual">
<meta name="twitter:description" content="Promovemos la felicidad, la igualdad y la libertad sexual en Latino America, impulsando el entendimiento y la exploracion de relaciones sanas y consensuales">
<meta name="twitter:image:src" content="http://explora.life/_img_website/hero_facebookthumb.jpg">
</header>

<body id="page-top" class="index">

	<?php include("_contenido/navigation_home.php"); ?>
	<br><br>
	<?php include("_contenido/mision.php"); ?>
	<?php include("_contenido/featured_home.php"); ?>
	<?php include("_contenido/promoted_products_home.php"); ?>
	<?php include("_contenido/newsletter.php"); ?>
	<?php include("_contenido/footer.php"); ?>
	<?php include("_contenido/javas_welcome.php"); ?>
</body>

</html>
