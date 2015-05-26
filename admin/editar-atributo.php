<?php
include_once 'admin-class.php';
$admin = new itg_admin();
$admin->_authenticate();
include_once '../functions.php';

$id = $_GET['id'];
$result = $mysqli->query("SELECT * FROM attributes WHERE attribute_id='$id'");

while($row = $result->fetch_assoc()) {
  if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = $_POST['name'];
    $description = $_POST['description'];

    if(isset($_FILES["icon"])){    
      if($_FILES["icon"]['name']!=''){
        $img_name = $_FILES["icon"]['name'];
        upload_file('../media/attributes/', 'icon');
        $img = '/media/attributes/'.basename($_FILES['icon']["name"]);
        $query = "UPDATE attributes SET name='$name', description='$description', icon='$img' WHERE attribute_id='$id'";
      } else{
        $query = "UPDATE attributes SET name='$name', description='$description' WHERE attribute_id='$id'";
      }
    } else{
      $query = "UPDATE attributes SET name='$name', description='$description' WHERE attribute_id='$id'";
    }

    $edit_result = $mysqli->query($query) or die("Error in the consult.." . mysqli_error($mysqli));

    if($edit_result){
      $flash = 'El atributo ha sido actualizado';
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
      <div class="form-group">
        <label>Descripción</label>
        <textarea name="description" class="form-control" placeholder="Descripción"><?php echo $row['description']; ?></textarea>
      </div>
      <div class="form-group">
        <p>Imagen actual:</p>
        <p><img src="<?php echo $row['icon']; ?>"></p>
        <label>Icono</label>
        <input type="file" name="icon" placeholder="Imagen">
      </div>
      <button type="submit" class="btn btn-success">Guardar</button>
    </form>
  </div>
</body>
<?php
}
?>
</html>