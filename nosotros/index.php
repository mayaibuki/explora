<!--Website coded by www.mayaibuki.me -->
<?php 
session_start();
@include_once('../functions.php');
?>
<!DOCTYPE html>
<html lang="es">
<header>
	<meta charset="utf-8">

	<?php include("modulos/header.php"); ?>


<title>Explora.life – Nosotros</title>

<!--{% block meta %}-->
    <meta name="description" content="{{ config.default_site_meta_description }}">
    <!--FB Opengraph-->
    <meta property="og:title" content="{{ config.site_title }}"/>
    <meta property="og:site_name" content="{{ config.site_title }}"/>
    <meta property="og:description" content="{{ config.default_site_meta_description }}"/>
    <!-- Twitter-->
    <meta name="twitter:card" content="summary_text-price_image">
    <meta name="twitter:site" content="{{ config.twitter_handle }}">
    <meta name="twitter:creator" content="{{ config.twitter_handle }}">
    <meta name="twitter:title" content="{{ config.site_title }}">
    <meta name="twitter:description" content="{{ config.default_site_meta_description }}">
<!--{% endblock %}-->


    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/explora.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,700,300italic,700italic' rel='stylesheet' type='text/css'>
    
    <!-- animate.css -->
	<link rel="stylesheet" href="../css/animate.css">
	
    <!-- Mailchimp CSS -->
	<link href="../css/mailchimp.css" rel="stylesheet" type="text/css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</header>

<body id="page-top" class="index">
    	<?php include("../modulos/navigation.php"); ?>
    	<?php include("../modulos/mision.php"); ?>
    	
    	
	    <section>     
		    <div class="container">   
				<div class="row">
					<div class=" col-sm-7 ">
						<h1>¿Qué es explora.life?</h1>
						<p class="large"> Explora es una organización que enseña educación sexual actualizada y positiva por medio de nuestra <a href="/leer/">revista online</a>, la <a href="/comprar/">tienda online</a> y los <a href="/tuppersex/">talleres TupperSex</a>.</p>
						<p class="large text-muted"> El sexo es una experiencia maravillosa que nos hace crecer si se practica de forma consensual.</p>
				    </div>
					<div class=" col-sm-5 ">
						<img class="img-centered" src="../media/nosotros.png" alt="nosotros" width="100%"/>
				    </div>
				</div>
		    </div>
		</section>
	
    	
    	
    	<?php include("../modulos/team.php"); ?>
    	<?php include("../modulos/contact.php"); ?>
    	<?php include("../modulos/footer.php"); ?>
    	<?php include("../modulos/javas.php"); ?>
</body>

</html>
