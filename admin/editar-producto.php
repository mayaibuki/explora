<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once 'admin-class.php';
$admin = new itg_admin();
$admin->_authenticate();
include_once '../functions.php';
$current_url = base64_encode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

$slug = $_GET['slug'];
$result = $mysqli->query("SELECT * FROM product WHERE slug='$slug'");

while($row = $result->fetch_assoc()) {
  $product_id = intval($row['product_id']);

  if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = $mysqli->real_escape_string($_POST['name']);
    $sku = $mysqli->real_escape_string($_POST['sku']);
    $price = $mysqli->real_escape_string($_POST['price']);
    $color = $mysqli->real_escape_string($_POST['color']);
    $color_code = $mysqli->real_escape_string($_POST['color_code']);
    $how = $mysqli->real_escape_string($_POST['how_to_use']);
    $description = $mysqli->real_escape_string($_POST['description']);
    $stock = $mysqli->real_escape_string($_POST['stock']);
    $category_id = $mysqli->real_escape_string($_POST['category_id']);
    //$attributes_id = $_POST['attribute_id'];
    if($color){
      $slug = slugify($name).'-'.slugify($color);
    } else{
      $slug = slugify($name);
    }

    $query = "UPDATE product SET SKU='$sku', color='$color', color_code='$color_code', name='$name', price='$price', how_to_use='$how', description='$description', category_id='$category_id', stock='$stock', slug='$slug' WHERE product_id='$product_id'";
    $edit_result = $mysqli->query($query) or die("Error in the consult.." . mysqli_error($mysqli));

    if (!file_exists('../media/product/'.$slug)) {
      mkdir('../media/product/'.$slug, 0777, true);
    }
    
    if(isset($_POST['attribute_id'])){
      foreach($_POST['attribute_id'] as $attr) {
        $mysqli->query("INSERT INTO product_attributes SET product_id='$product_id', attribute_id='$attr'");
      }
    }

    if(isset($_POST['related'])){
      foreach($_POST['related'] as $rel) {
        $mysqli->query("INSERT INTO related_product SET product_id='$product_id', product_id_r='$rel'");
      }
    }

    if(isset($_FILES["full_img"])){    
      foreach($_FILES["full_img"]['tmp_name'] as $key => $tmp){
        if($_FILES["full_img"]['name'][$key]!=''){
          $name = $_FILES["full_img"]['name'][$key];
          upload_multiple('../media/product/'.$slug.'/', $name, $tmp);
          $img = '/media/product/'.basename($name);
          $img_result = $mysqli->query("INSERT INTO product_img SET product_id='$product_id', full_img='$img'") or die("Error in the consult.." . mysqli_error($mysqli));
        }
      }
    }

    if(isset($_FILES["how_img"])){    
      foreach($_FILES["how_img"]['tmp_name'] as $key => $tmp){
        if($_FILES["how_img"]['name'][$key]!=''){
          $name = $_FILES["how_img"]['name'][$key];
          upload_multiple('../media/product/'.$slug.'/', $name, $tmp);
          $img = '/media/product/'.$slug.'/'.basename($name);
          $img_result = $mysqli->query("INSERT INTO how_product_img SET product_id='$product_id', full_img='$img'") or die("Error in the consult.." . mysqli_error($mysqli));
        }
      }
    }

    if($edit_result){
      $flash = 'El producto ha sido actualizado';
    } else{
      $flash = 'Error';
    }

  }
  $imgs = $mysqli->query("SELECT * FROM product_img WHERE product_id='$product_id' ORDER BY img_order");
  $how_imgs = $mysqli->query("SELECT * FROM how_product_img WHERE product_id='$product_id'");

  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <title>explora.life – <?php echo $row['name']; ?></title>

    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/bootstrap.css" />
    <link rel=icon href=/_img_icons/favicon16x16.png sizes="16x16" type="image/png">
    <link rel=icon href=/_img_icons/windows48x48.ico sizes="32x32 48x48" type="image/vnd.microsoft.icon">
    <link rel=icon href=/_img_icons/mac.icns sizes="128x128 512x512 8192x8192 32768x32768">
    <link rel=icon href=/_img_icons/iphone.png sizes="57x57" type="image/png">
    <link rel=icon href=/_img_icons/gnome.svg sizes="any" type="image/svg+xml">
    
    <style type="text/css">
      .bg-info{
        padding: 1em;
      }
      .img-form-group ul li, .img-form-group-how ul li{
        list-style: none;
        display: inline-block;
      }
    </style>
  </head>

  <body id="page-top" class="index">
    <nav class="navbar navbar-default" role="navigation">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/admin/">
            Welcome <?php echo $admin->get_nicename(); ?>
          </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">

          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="logout.php">Logout</a>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    <div class="container">
      <?php
      if(isset($flash)){
        echo '<p class="bg-success" style="padding:1em;">'.$flash.'</p>';
      }
      ?>
      <h3>Editar <?php echo ucwords(strtolower($row['name'])); ?></h3>
      <hr>
      <form method="post" enctype="multipart/form-data" action="">
        <div class="form-group">
          <label>Nombre</label>
          <input name="name" type="text" class="form-control" placeholder="Nombre del producto" value="<?php echo ucwords(strtolower($row['name'])) ?>">
        </div>   
        <div class="form-group">
          <label>Sku</label>
          <input name="sku" type="text" class="form-control" placeholder="SKU del producto" value="<?php echo ucwords(strtolower($row['SKU'])) ?>">
        </div>
        <div class="form-group">
          <label>Color</label>
          <input name="color" type="text" class="form-control" placeholder="Color del producto" value="<?php echo ucwords(strtolower($row['color'])) ?>">
        </div>
        <div class="form-group">
          <label>Código del grupo</label>
          <input name="color_code" type="text" class="form-control" placeholder="Código del grupo" value="<?php echo ucwords(strtolower($row['color_code'])) ?>">
        </div>   
        <div class="form-group">
          <label>Precio</label>
          <input name="price" type="number" class="form-control" placeholder="Precio" value="<?php echo $row['price'] ?>">
        </div>
        <div class="form-group">
          <label>¿Como usar? (video)</label>
          <input name="how_to_use" type="text" class="form-control" placeholder="Como se Usa? (iframe del video)" value="<?php echo $row['how_to_use'] ?>">
        </div>
        <div class="img-form-group-how">
          <div class="form-group">
            <label>Imagen de como usar</label>
            <input type="file" name="how_img[]">
          </div>
          <a class="remove_field" href="#">Quitar Campo</a>
                    <!--
                    <div class="form-group">
                      <label>Thumbnail</label>
                      <input type="file" name="thumb_img">
                    </div>
                  -->
                </div>
                <br>
                <a href="#" class="add-form-group-how"><i class="glyphicon glyphicon-plus"></i> Agregar más imagenes</a>
                <br><br>
                <?php

                while($img= $how_imgs->fetch_object()){

                  echo '<div style="inline-block"><img src="/media/timthumb.php?src='.$img->full_img.'"><a href="/admin/remove_pic.php?id='.$img->img_id.'&amp;type=how_product_img&amp;return_url='.$current_url.'" class="btn btn-error btn-block">Quitar</a></div>';


                }
                ?>
                <br><br>
                <div class="form-group">
                  <label>Descripción</label>
                  <textarea name="description" class="form-control" placeholder="Descripción"><?php echo $row['description'] ?>"</textarea>
                </div>
                <div class="form-group">
                  <label>Stock</label>
                  <input name="stock" type="number" value="<?php echo $row['stock'] ?>" class="form-control" placeholder="Stock">
                </div>
                <div class="form-group">
                  <label>Categoria</label>
                  <select name="category_id" class="form-control" placeholder="Categoria">
                    <?php
                    $cat_result = $mysqli->query('SELECT * FROM category');
                    if (!$cat_result) {
                      die('Could not query:' . mysqli_error());
                    }
                    while($cat_row = $cat_result->fetch_assoc()) {
                      ?>
                      <option value="<?php echo $cat_row['category_id'] ?>" <?php if($cat_row['category_id'] == $row['category_id']) { echo 'selected'; } ?>><?php echo $cat_row['name'] ?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Atributos</label>
                  <?php 
                  $attrs = $mysqli->query("SELECT a.*  
                    from product p
                    join product_attributes pa on p.product_id = pa.product_id
                    join attributes a on a.attribute_id = pa.attribute_id
-- optional where clause
where p.product_id = '$product_id'");

                  echo '<table class="table">';
                  while($attr = $attrs->fetch_assoc()){
                    echo '<tr><td><p class="description"><img src="'.$attr['icon'].'"> '.$attr['description'].'</p></td><td><a class="btn-sm btn-error" href="/admin/remove_attribute.php?id='.$attr['attribute_id'].'&amp;pid='.$row['product_id'].'&amp;return_url='.$current_url.'">Quitar atributo</a></td></tr>';
                  }
                  echo '</table>';

                  ?>
                  <p class="bg-info">Agregar Atributos</p>
                  <select name="attribute_id[]" multiple="multiple" class="form-control" placeholder="Atributos">
                    <?php
                    $att_result = $mysqli->query('SELECT * FROM attributes');
                    if (!$att_result) {
                      die('Could not query:' . mysqli_error());
                    }
                    while($att_row = $att_result->fetch_assoc()) {
                      ?>
                      <option value="<?php echo $att_row['attribute_id'] ?>"><?php echo $att_row['name'] ?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Productos Relacionados</label>
                  <?php
                  $related_res= $mysqli->query("SELECT p.* FROM related_product a JOIN product p ON p.product_id = a.product_id WHERE a.product_id_r = '$product_id' UNION SELECT p.* FROM related_product b JOIN product p ON p.product_id = b.product_id_r WHERE b.product_id = '$product_id'");
                  echo '<table class="table">';
                  while ($related = $related_res->fetch_assoc()) {
                    ?>
                    <tr>
                      <td><?php echo ucwords(strtolower($related['name'])); ?></td>
                      <td><?php echo '<a class="btn-sm btn-error" href="/admin/remove_relation.php?id='.$related['product_id'].'&amp;rid='.$row['product_id'].'&amp;return_url='.$current_url.'">Quitar relación</a>' ?></td>
                    </tr>
                    <?php 
                  }
                  echo '</table>';
                  ?>
                  <p class="bg-info">Agregar Productos Relacionados</p>
                  <select name="related[]" multiple="multiple" class="form-control" placeholder="Atributos">
                    <?php
                    $related_res = $mysqli->query('SELECT * FROM product');
                    if (!$related_res) {
                      die('Could not query:' . mysqli_error());
                    }
                    while($related = $related_res->fetch_assoc()) {
                      ?>
                      <option value="<?php echo $related['product_id'] ?>"><?php echo ucwords(strtolower($related['name'])); ?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
                <div class="img-form-group">
                  <div class="form-group">
                    <label>Imagenes</label>
                    <ul>
                      <?php
                      while($img= $imgs->fetch_assoc()){

                        ?>
                        <li id="recordsArray_<?php echo $img['img_id']; ?>"><?php  echo '<img src="/media/timthumb.php?src='.$img['full_img'].'">'; ?><a href="/admin/remove_pic.php?id=<?php echo $img['img_id']; ?>&amp;type=product_img&amp;return_url=<?php echo $current_url; ?>" class="btn btn-error btn-block">Quitar</a></li>
                        <?php } ?>
                      </ul>
                      <br>
                      <br>
                      <input type="file" name="full_img[]">
                    </div>
                    <!--
                    <div class="form-group">
                      <label>Thumbnail</label>
                      <input type="file" name="thumb_img">
                    </div>
                  -->
                  <a class="remove_field" href="#">Quitar Campo</a>
                </div>
                <br>
                <a href="#" class="add-form-group"><i class="glyphicon glyphicon-plus"></i> Agregar más imagenes</a>  
                <br>
                <button type="submit" class="btn btn-success">Guardar</button>
              </form>
              <div id="contentRight">
                
              </div>
            </div>
            <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/admin/jquery-ui.min.js"></script>
            <script type="text/javascript">
              $(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".img-form-group"); //Fields wrapper
    var add_button      = $(".add-form-group"); //Add button ID
    var wrapper2         = $(".img-form-group-how"); //Fields wrapper
    var add_button2      = $(".add-form-group-how"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
      e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="form-group"><label>Imagen</label><input type="file" name="full_img[]"></div>'); //add input box
          }
        });
    

    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
      e.preventDefault(); $(this).next('div').remove(); x--;
    });

    $(add_button2).click(function(e){ //on add input button click
      e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper2).append('<div class="form-group"><label>Imagen de como usar</label><input type="file" name="how_img[]"></div>'); //add input box
          }
        });
    

    $(wrapper2).on("click",".remove_field", function(e){ //user click on remove text
      e.preventDefault(); $(this).next('div').remove(); x--;
    });

    $(function() {
    $(".img-form-group ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
          var order = $(this).sortable("serialize") + '&action=updateRecordsListings'; 
          $.post("/admin/updateDB.php", order, function(theResponse){
            $("#contentRight").html(theResponse);
          });                                
        }                 
      });
  });
  });

    </script>
</body>
<?php
}
?>
</html>