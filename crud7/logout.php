<?php include("includes/header.php") ?>
<?php include("includes/function.php") ?>
<?php
$message = 'samp';
  $name = '';
if(isset($_COOKIE['id']) && isset($_COOKIE['security'])){
  $id = find_user($_COOKIE['id']);
    $message = "You are logged out <small class='name-header'>".$id.".</small>";
      $name = " <small class='name-message'>". $id."</small>";
      setcookie("id","",0,"/");
        setcookie("security","",0,"/");
            setcookie("post_id","",0,"/");
} else {
    $message = "Você precisa fazer o login primeiro!";
}
?>
<div class="container">
  <div class="rows">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <div class="panel panel-success logout">
        <div class="panel-heading text-head"><?php echo $message; ?></div>
        <div class="panel-body page-display">
            <div class="row">
              <div class="col-md-4">
               
                  <div class="container menu">
                    <a href="login.php" class="btn btn-primary">Login</a>
                  </div>
                  <div class="container menu">
                    <a href="signin.php" class="btn btn-primary">registro</a>
                  </div>
                  <div class="container menu">
                    <a href="contacts.php" class="btn btn-primary">Contatos</a>
                  </div>
                  <div class="container menu">
                    <a href="contacts.php" class="btn btn-primary">Comentários
</a>
                  </div>
              </div>
              
              <div class="col-md-8"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-2"></div>
    </div>
  </div>
<?php include("includes/footer.php") ?>
