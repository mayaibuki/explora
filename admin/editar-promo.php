<?php
include_once 'admin-class.php';
$admin = new itg_admin();
$admin->_authenticate();
include_once '../functions.php';

$id = $_GET['id'];
$result = $mysqli->query("SELECT * FROM attributes WHERE attribute_id='$id'");

while($row = $result->fetch_assoc()) {
  if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = $mysqli->real_escape_string($_POST['name']);
    $description = $mysqli->real_escape_string($_POST['description']);

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

    <form method="post" action="promocode.php">
                <div class="form-group">
                  <input type="text" name="code" placeholder="Código" class="form-control">
                </div>
                <div class="form-group">
                  <label>Valid Since</label>
                  <p class="muted">mm/dd/aa</p>
                  <div class="input-group datepicker" id="valid_cal">
                    <input type="text" name="valid_since" id="valid_since" class="form-control" value="<?php echo $row['valid_since']; ?>" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>
                <div class="form-group">
                  <label>Valid Thru</label>
                  <p class="muted">mm/dd/aa</p>
                  <div class="input-group datepicker" id="valid_cal2">
                    <input type="text" name="valid_thru" id="valid_thru" class="form-control" value="<?php echo $row['valid_thru']; ?>" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>
                <div class="form-group">
                  <label>Discount percent</label>
                  <p class="muted">Decimal (.5)</p>
                  <input type="text" name="discount_percentage" id="discount_percentage" value="<?php echo $row['discount_percentage']; ?>" class="form-control datepicker" />
                </div>
                <div class="form-group">
                  <label>Discount price</label>
                  <p class="muted">Número 10000</p>
                  <input type="text" name="discount_price" id="discount_price" class="form-control datepicker" />
                </div>
                <button type="submit" class="btn btn-success">Guardar</button>
              </form>
  </div>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="/js/moment.js"></script>
  <script type="text/javascript" src="/admin/jquery-ui.min.js"></script>
  <script type="text/javascript" src="/js/bootstrap-datetimepicker.min.js"></script>
  <script type="text/javascript">
    $(function () {
      $('#valid_cal').datetimepicker();
      $('#valid_cal2').datetimepicker();
    });
  </script>
</body>
<?php
}
?>
</html>