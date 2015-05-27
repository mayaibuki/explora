<!--Website coded by www.mayaibuki.me – Some rights reserved, most photos are under some creative commons license-->
<?php
session_start();
$serv_root = realpath($_SERVER["DOCUMENT_ROOT"]);
$root = '/';
@include_once('functions.php');
include $serv_root.'/_contenido/_header.php';
$slug = $_GET['slug'];
$result = $mysqli->query("SELECT * FROM product WHERE slug='$slug'");

if (!$result) {
  die('Could not query:' . mysqli_error());
}

while($row = $result->fetch_assoc()) {
  $product_id = $row['product_id'];
  $product_color_code = $row['color_code'];
  $imgFeatured_result = $mysqli->query("SELECT * FROM product_img WHERE product_id='$product_id' LIMIT 1");
  $imgFeatured = $imgFeatured_result->fetch_object();

  ?>
  <link rel="stylesheet" type="text/css" href="/css/zoomingbox.min.css">
  <title>explora.life – <?php echo $row['name']; ?></title>

  <meta name="description" content="<?php echo $row['description']; ?>">
  <!--Opengrph-->
  <meta property="og:title" content="<?php echo $row['name']; ?>" />
  <meta property="og:site_name" content="Explora.life"/>
  <meta property="og:url" content="http://explora.life/comprar/<?php echo $row['slug']; ?>/" />
  <meta property="og:description" content="<?php echo $row['description']; ?>" />
  <meta property="og:image" content="http://explora.life<?php echo $imgFeatured->full_img ?>" />

  <!-- twitter-->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="@explora_life">
  <meta name="twitter:creator" content="@explora_life">
  <meta name="twitter:title" content="<?php echo $row['name']; ?>">
  <meta name="twitter:description" content="<?php echo $row['description']; ?>">
  <meta name="twitter:image:src" content="http://explora.life<?php echo $imgFeatured->full_img ?>">
  <style type="text/css">
  .attributes img{
    width: 24px;
    height: 24px;
  }
  .zoomingBox-xl{
    max-width: 100%;
  }
  </style>
</head>

<body id="page-top" class="index">


  <br><br>

  <?php include("_contenido/navigation_producto.php"); ?>
  <!-- DESCRIPCIÓN -->
  <section id="">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <!--                        <p class="section-parrafo text-muted"><a href="/">Explora</a> > <a href="/comprar/">Comprar</a> > <a href="../../comprar/vibradores/" class="page-scroll">Vibradores</a> > Vibrador para el dedo</p>-->
          <h2 class="text-center"><?php echo $row['name']; ?></h2>

        </div>
      </div>
    </div>
  </section>

  <!--vibradores -->
  <section id="vibradores" class="bg-light-gray" >
    <div class="container">     
      <div class="row ">
        <div class="imagen col-sm-4">
          <?php 
          $imgs = $mysqli->query("SELECT * FROM product_img WHERE product_id='$product_id'");
          $how_imgs = $mysqli->query("SELECT * FROM how_product_img WHERE product_id='$product_id'");

          if (!$imgs) {
            die('Could not query:' . mysqli_error());
          }


          ?>
          <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
<!--
                      <ol class="carousel-indicators">

                          <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                          <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                          <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                          <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                          <li data-target="#carousel-example-generic" data-slide-to="4"></li>
                      </ol>
                    -->
                    <div class="carousel-inner" role="listbox">

                      <?php
                      $count = 1;
                      while($img= $imgs->fetch_assoc()){
                        ?>
                        <div class="item <?php echo (($count==1) ? 'active':''); ?>">
                          <a class="carousel_zoom" href="<?php echo $img['full_img']; ?>" rel="gallery"><img class="carousel_img" style="background-image: url('<?php echo $img['full_img']; ?>');"/></a>
                        </div>
                        <?php
                        $count++;
                      }
                      ?>
                    </div>
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
                </div>
                <div class="col-sm-4">
                  <p class="descripcion">
                    <?php echo $row['description'] ?>
                  </p>

                  <div class="row">
                    <div class="text-center col-sm-offset-0 col-sm-12">
                      <?php

                      $colors = $mysqli->query("SELECT * FROM product WHERE color_code='$product_color_code'");
                      if($row['color']!=''){
                        echo '<select id="color" class="form-control">';
                        while($color=$colors->fetch_assoc()){
                          if($color['product_id']==$product_id){
                            $selected='selected';
                          } else{
                            $selected = '';
                          }
                          echo '<option value="'.$color['slug'].'" '. $selected .'>'.$color['color'].'</option>';
                        }
                        echo '</select>';
                      }
                      ?>
                      <h3 class="text-primary">$<?php echo number_format($row['price']); ?></h3>
                      <div class="products">
                        <?php
//current URL of the Page. cart_update.php redirects back to this URL
                        $current_url = base64_encode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);



                        echo '<form method="post" action="/cart_update.php">';
                        echo '<label>Cantidad</label>';
                        echo '<select name="product_qty" class="form-control">';
                        for ($i=1; $i <= $row['stock']; $i++) { 
                          echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                        echo '</select><br>';
                        echo '<input type="hidden" name="product_id" value="'.$row['product_id'].'" />';
                        echo '<input type="hidden" name="type" value="add" />';
                        echo '<input type="hidden" name="return_url" value="'.$current_url.'" />';
                        echo '<button type="submit" class="btn btn-xl animate buzz">Comprar</button>';
                        echo '</form>';
                        ?>
                      </div>
                      <a class="page-scroll" href="#como-pagar"><p class="text-primary">¿Cómo pagar?</p></a>
                    </div>
                  </div>


                </div>
                <div class="col-sm-4 attributes">
                  <?php 
                  $attrs = $mysqli->query("SELECT a.*  
                    from product p
                    join product_attributes pa on p.product_id = pa.product_id
                    join attributes a on a.attribute_id = pa.attribute_id
-- optional where clause
where p.product_id = '$product_id'");

                  while($attr = $attrs->fetch_assoc()){
                    echo '<p class="description"><img src="'.$attr['icon'].'"> '.$attr['description'].'</p>';
                  }

                  ?>
                </div>
              </div>  

            </div>
          </section>
          <!-- información extra--> 

          <!-- información extra-->     
          <section>
            <div class="container"> 
              <?php
              if ($row['how_to_use']) {
                $how =  preg_match('/\/\/(?:www\.)?youtu(?:\.be|be\.com)\/(?:watch\?v=|embed\/)?([a-z0-9_\-]+)/i', $row['how_to_use'], $results);
                ?>

                <div class="row"> 
                  <div class="col-lg-12">
                    <h3>¿Cómo se usa?</h3>
                    <?php
                    $count = 1;
                    while($img= $how_imgs->fetch_assoc()){
                      ?>
                      <div class="col-sm-4">
                        <img src="<?php echo $img['full_img']; ?>" alt="<?php echo $row['name']; ?>" width="100%" style="background:#f7f7f7;"/>
                      </div>
                      <?php
                      $count++;
                    }
                    ?>
                  <!--
                  <div class="col-sm-4">
                    <img src="#.png" alt="lubricar" width="100%" style="background:#f7f7f7;"/>
                  </div>
                  <div class="col-sm-4">
                    <img src="#.png" alt="Insertar" width="100%" style="background:#f7f7f7;"/>
                  </div>
                  <div class="col-sm-4">
                    <img src="#.png" alt="Prender" width="100%" style="background:#f7f7f7;"/>
                  </div>
                -->
              </div>
            </div>
            <br>


            <div class="row"> 
              <div class="col-lg-8 col-lg-offset-2">
                <div class='embed-container'>
                  <iframe src='https://www.youtube.com/embed/<?php echo $results[1] ?>?rel=0&amp;controls=0&amp;showinfo=0' frameborder='0' allowfullscreen></iframe>
                </div>        
              </div>
            </div>

          </div>
        </section>    
        <?php
      }
      ?>  




      <section id="otros" class="bg-light-gray">
        <div class="container">
          <div class="row">
            <h3 class="section-heading">Productos Relacionados</h3>

            <?php
            $related_res= $mysqli->query("SELECT p.* FROM related_product a JOIN product p ON p.product_id = a.product_id WHERE a.product_id_r = '$product_id' UNION SELECT p.* FROM related_product b JOIN product p ON p.product_id = b.product_id_r WHERE b.product_id = '$product_id'");
            while ($related = $related_res->fetch_assoc()) {
              $p_id = $related['product_id'];
              $rel_img = $mysqli->query("SELECT * FROM product_img WHERE product_id='$p_id' LIMIT 1");
              $rel_img_res = $rel_img->fetch_object();
              ?>
              <div class="col-xs-6 col-sm-4 col-md-2 animated pulse">
                <a class="page-scroll" href="/comprar/<?php echo $related['slug']; ?>/" ><div class="otros_imgbg" style="background-image: url('<?php echo $rel_img_res->full_img; ?>');"><h5><?php echo $related['name']; ?></h5>
                </div>
                <p class="text-center">$<?php echo number_format($related['price']); ?></p></a>
              </div>
              <?php 
            }
            ?>

          </div> 
        </div>
      </section>





      <section id="como-pagar">
        <div class="container" >            
          <div class="row">
            <div class="col-md-6" >
              <h3>¿Cómo puedo pagar?</h3>
              <br>
              <i class="fa fa-cc-mastercard fa-3x"></i> <i class="fa fa-cc-visa fa-3x"></i> <i class="fa fa-cc-amex fa-3x"></i> <i class="fa fa-credit-card fa-3x"></i>
              <p class="descripcion">Con tarjeta de crédito o débito</p>
              <img src="<?php echo $root; ?>_img_website/baloto.jpg" alt="baloto" height="42px" /> <img src="<?php echo $root; ?>_img_website/efecty.png" alt="baloto" height="42px" />
              <p class="descripcion">Con dinero en efectivo desde un Baloto o un Efecty</p>
              <br>
              <img src="<?php echo $root; ?>_img_website/pse.png" height="42px" alt="Pagos seguro en línea"/> <img src="<?php echo $root; ?>_img_website/payulatam.png" height="42px" alt="PayU latam"/>              
              <p class="descripcion">o transferencia bancaria.</p>
              <p class="descripcion">Todos los métodos de pago son <b>seguros</b>. Te enviaremos un e-mail con la confirmación cuando recibamos tu pago, otro cuando te enviemos la mercancía (paquete discreto) y uno final para asegurarnos de que hayas recibido el producto con satisfacción</p>
              <p class="descripcion">Si tienes alguna pregunta, envía un e-mail a <a href="mailto:pedidos@explora.life">pedidos@explora.life</a> o por WhatsApp al <a href="tel:+57-316-874-9597">+57 (316) 874 9597</a></p> 

            </div>
            <div class="col-md-6">

              <h3>Preguntas y comentarios</h3>
              <br>
              <div class="fb-comments" data-href="http://explora.life/comprar/<?php echo $row['slug'] ?>/" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
            </div>
          </div>
        </div>
      </section>
</div>





      <?php include("_contenido/newsletter.php"); ?>
      <?php include("_contenido/footer.php"); ?>
      <?php include("_contenido/javas_2.php"); ?>
      <script type="text/javascript" src="/js/jquery.zoomingbox.min.js"></script>
      <script>
      $(document).ready(function(){
        $('.carousel_zoom').zoomingBox({zoom:'vertical',imageResize:'both',});
      });
        $('#color').on('change', function(e){
          e.preventDefault();
          var color = $('#color').val();
          console.log(color);
          window.location.href='http://explora.life/comprar/'+ color +'/';
        });
        <?php
        if(isset($_SESSION["products"])){
          ?>
        console.log('sesion', <?php echo $_SESSION['products']; ?>);
        console.log('count', <?php echo count($_SESSION['products']); ?>);
        console.log('size', <?php echo sizeof($_SESSION['products']); ?>);
        <?php
      }
      ?>
      </script>
    </body>
    <?php
  }
  ?>
  </html>

