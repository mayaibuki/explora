<!--Website coded by www.mayaibuki.me – Some rights reserved, most photos are under some creative commons license-->
<?php 
session_start();
@include_once('../functions.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<?php include("../modulos/header.php"); ?>
	
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Revista de sexualidad, educación sexual y tienda de productos para la salud y el bienestar sexual. Compra sex toys, vibradores, consoladores, dildos, masajeadores, ropa interior, boudoir, BDSM, lelo, tenga, tickler en Colombia">
    <meta name="author" content="explora">
    <link rel="alternate" hreflang="es" href="http://explora.life/" />
    
    <!--Opengrph-->
    <meta property="og:title" content="Conoce tu cuerpo y explora" />
    <meta property="og:site_name" content="Explora.life"/>
    <meta property="og:url" content="http://explora.life/leer/" />
    <meta property="og:description" content="Revista de sexualidad, educación sexual y tienda de productos para la salud y el bienestar sexual" />
    <meta property="og:image" content="http://explora.life/_img_website/hero_facebookthumb.jpg" />

    <!-- twitter-->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@explora_life">
    <meta name="twitter:creator" content="@explora_life">
    <meta name="twitter:title" content="Conoce tu cuerpo y explora">
    <meta name="twitter:description" content="Revista de sexualidad, educación sexual y tienda de productos para la salud y el bienestar sexual">
    <meta name="twitter:image:src" content="http://explora.life/_img_website/hero_facebookthumb.jpg">


    <!--favicon-->
    <link rel=icon href=/_img_icons/favicon16x16.png sizes="16x16" type="image/png">
    <link rel=icon href=/_img_icons/windows48x48.ico sizes="32x32 48x48" type="image/vnd.microsoft.icon">
    <link rel=icon href=/_img_icons/mac.icns sizes="128x128 512x512 8192x8192 32768x32768">
    <link rel=icon href=/_img_icons/iphone.png sizes="57x57" type="image/png">
    <link rel=icon href=/_img_icons/gnome.svg sizes="any" type="image/svg+xml">

    <title>explora.life – Comprar</title>





    <!-- Bootstrap Core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/explora.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,700,300italic,700italic' rel='stylesheet' type='text/css'>
    
    <!-- animate.css -->
    <link rel="stylesheet" href="/css/animate.css">

    <!-- Mailchimp CSS -->
    <link href="/css/mailchimp.css" rel="stylesheet" type="text/css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body id="page-top" class="index">



        <?php include("../modulos/navigation.php"); ?>
        <section id="indice" style="background:url('/media/articles/hands-couple-bathing-suit.jpg'); background-size: cover; ">
            <div class="container">
			    <div class="row">
			        <br><br>

		            <div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-5 text-center">
		            	<h3 class="section-parrafo text-white">Conoce los distintos productos para mejorar tu bienestar sexual y la intimidad con tu pareja de una manera saludable y sobre todo, divertida</h3>
			        </div>
		            <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-5 text-center">	
						<h3 class="text-white text-center">Categorías:</h3>
						<p class="text-center large">
							<?php
							$cat_count = 0;
							$result = $mysqli->query('SELECT * FROM category');
							if (!$result) {
							  die('Could not query:' . mysqli_error());
							}
							
							while($row = $result->fetch_assoc()) {
							if($cat_count > 0 && $cat_count < $result->num_rows ){
							    echo '';
							}
							echo '<a class="page-scroll" href="#'.$row['slug'].'">'.$row['name'].'</a></br>';
							$cat_count++;
							}
							?>
                        </p>
			        </div>
			    </div>
		            
            </div>
        </div>
    </section>


    <?php
    $result = $mysqli->query('SELECT * FROM category');
    if (!$result) {
      die('Could not query:' . mysqli_error());
  }
  while($row = $result->fetch_assoc()) {
    ?>
    <!--CATEGORIAS -->
    <section id="<?php echo $row['slug'] ?>" class="bg-gradient-gray" >
        <div class="container">     
            <div class="row">
                <div class="titulo col-xs-12">
                    <h2 class="section-heading"><?php echo $row['name'] ?></h2>
                </div>
                <!--Imagen de la categoría-->
                <div class="imagen col-xs-12 col-sm-6 col-md-4">
                    <img src="<?php echo $row['img'] ?>" alt="<?php echo $row['name'] ?>" width="100%" height="" />
                </div>
                <div class="col-xs-12 col-sm-6 col-md-8">
                	<div class="description-cat">
	                    <?php echo $row['description'] ?>
                	</div>
                </div>  
            </div>
            
            
            <div class="row productos-cat">
            	<div class="col-lg-12">
		            <?php
		                $cat_id=$row['category_id'];
		                $p_result = $mysqli->query("SELECT * FROM product WHERE category_id='$cat_id' AND stock>0 GROUP BY color_code");
		                if (!$p_result) {
		                  die('Could not query:' . mysqli_error());
		              }
		              while($p_row = $p_result->fetch_assoc()) {
		                $product_id = $p_row['product_id'];
		                ?>
		                
		                    <!-- THUMBNAILS-->
			                <a href="/comprar/<?php echo $p_row['slug']; ?>/">
			                    <div class=" col-xs-6 col-sm-4 col-md-3 col-lg-3 animated pulse">
            				        <div class="card producto">

				                        <?php
				                        $imgs = $mysqli->query("SELECT * FROM product_img WHERE product_id='$product_id' ORDER BY img_order");
				                        $count = 0;
				                        while ($img =  $imgs->fetch_assoc()) {
				                            if($count==0){
				                                echo '<div class="card-img" style="background-image: url(/media/timthumb.php?src='. $img['full_img'] .'&w=200)"> </div>
                        						<div class="card-description text-center">
					                                <h5 class="text-primary ">'.$p_row['name'].'</h5>
													<p class="text-price text-secondary">$'.number_format($p_row['price']).'</p>	            			
													<div class="gr-ending"></div>

				                                </div>'; 
				                            }
				                            $count++;
				                        }
				                        ?>
            				        </div>
			                    </div>
			                </a>
					
					<?php
		            }
		            ?>
	        		<a href="#/">		
				        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 animated pulse">
					        <div class="card division">
								<div class="card-division">
			            			<h5>Ver más</h5>
			            			<h2 class="text-cta"><?php echo $row['name']; ?></h2>
			            		</div>
					       	</div>
				        </div>
					</a>
							        
	            </div>
	        </div>
	    </div>
	</section>
	
	
	<a href="#page-top" class="page-scroll top-page-btn">
		<h1>
			  <i class="fa fa-lg fa-arrow-circle-up "></i>
		</h1>
	</a>
	
	<?php
	}
	?>
	<?php include("../modulos/newsletter.php"); ?>
	<?php include("../modulos/footer.php"); ?>
	<?php include("../modulos/javas.php"); ?>
</body>

</html>
