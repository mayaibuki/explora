<?php
include_once 'admin-class.php';
$admin = new itg_admin();
$admin->_authenticate();
include_once '../functions.php';

$slug = $_GET['slug'];
$result = $mysqli->query("SELECT * FROM category WHERE category_id='$slug'");

while($row = $result->fetch_assoc()) {
  if($_SERVER['REQUEST_METHOD']=='POST'){
    $id = $row['category_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $slug = slugify($name);

    if(isset($_FILES["img"])){    
      if($_FILES["img"]['name']!=''){
        $img_name = $_FILES["img"]['name'];
        upload_file('../media/category/', 'img');
        $img = '/media/category/'.basename($_FILES['img']["name"]);
        $query = "UPDATE category SET name='$name', slug='$slug', description='$description', img='$img' WHERE category_id='$id'";
      } else{
        $query = "UPDATE category SET name='$name', slug='$slug', description='$description' WHERE category_id='$id'";
      }
    } else{
      $query = "UPDATE category SET name='$name', slug='$slug', description='$description' WHERE category_id='$id'";
    }

    $edit_result = $mysqli->query($query) or die("Error in the consult.." . mysqli_error($mysqli));

    if($edit_result){
      $flash = 'La categoría ha sido actualizada';
    } else{
      $flash = 'Error';
    }

  }

  ?>
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
  </style>
</header>

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
        <a class="navbar-brand" href="/admin">
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
        <label>Nombre del Atributo</label>
        <input type="text" name="name" placeholder="Nombre" class="form-control" value="<?php echo $row['name']; ?>">
      </div>
      <input type="hidden" name="slug" value="<?php echo $row['img']; ?>">
      <div class="form-group">
        <label>Descripción</label>
        <textarea name="description" class="form-control" placeholder="Descripción"><?php echo $row['description']; ?></textarea>
      </div>
      <div class="form-group">
        <p>Imagen actual:</p>
        <p><img src="<?php echo $row['img']; ?>"></p>
        <label>Imagen</label>
        <input type="file" name="img" placeholder="Imagen">
      </div>
      <button type="submit" class="btn btn-success">Guardar</button>
    </form>
  </div>
</body>
<?php
}
?>
</html>