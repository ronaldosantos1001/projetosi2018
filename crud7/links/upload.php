
<?php include("header.php") ?>
<?php include("navbar.php") ?>
<?php include("../includes/function.php") ?>
<?php
  if(isset($_COOKIE['id']) && isset($_COOKIE['security'])){

$message = 'Upload File Here';
$default = 'default';
if(isset($_POST['submit'])){
  if( $_FILES['post_image']['size'] == 0 || $_FILES['post_image']['error'] == 1 || empty($_POST['post_title']) || empty($_POST['post_comment']) ){
      $message = 'please fill all the forms';
    } else {
      $temp_name = $_FILES['post_image']['tmp_name'];
        $file_name = $_FILES['post_image']['name'];
          $file_location = "../img_upload/$file_name";
            $upload = upload_file($temp_name, $file_name);
      $user_id = $_COOKIE['id'];
        $post_title = $_POST['post_title'];
          $post_comment = $_POST['post_comment'];
      if($upload){
        $default = 'success';
        insert_post($user_id, $post_title, $post_comment, $file_name, $file_location);
      $post_id = get_id_post();
        $message = "Post Uploaded! <a href='edit.php?post_id={$post_id}'>View or Edit Post</a>";
      }
    }
  }
?>
<div class="container">
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <div class="message-setter">
        <div class="panel panel-<?php echo $default; ?>">
          <div class="panel-heading"><?php echo $message; ?></div>
        </div>
      </div>
          <form action="upload.php" method="post" enctype="multipart/form-data">

            <div class="form-group">
              <label for="file">Digite o novo arquivo</label>
              <input type="file" class="form-control-file" name="post_image">
              <small class="form-text text-muted">Por favor, insira apenas o arquivo (jpg, png, wmnp).</small>
            </div>
            <div class="form-group">
              <label for="title">Título</label>
              <input type="text" class="form-control" placeholder="Enter Title" name="post_title">
              <small class="form-text text-muted">O título deve ter menos de 20 caracteres.</small>
            </div>
            <div class="form-group">
              <label for="comments">Comentários</label>
              <textarea class="form-control" rows="3" name="post_comment"></textarea>
              <small class="form-text text-muted">Comentários com conteúdo violento serão removidos.</small>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Enviar</button>
        </form>
    </div>
    <div class="col-md-3"></div>
  </div>
</div>
<?php } else {
  redirect("../logout.php");
}
?>
<?php include("footer.php") ?>
