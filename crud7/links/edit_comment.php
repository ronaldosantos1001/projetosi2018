
<?php include("header.php") ?>
<?php include("navbar.php") ?>
<?php include("../includes/function.php") ?>
<?php

if(isset($_COOKIE['id']) && isset($_COOKIE['security'])){

    if(!isset($_GET['post_id']) || !isset($_GET['comment_id'])){
      redirect("../index.php");
    } else {

      if(isset($_GET['comment_id'])){
        $get_comment = get_comments($_GET['comment_id']);
          $com_id = $get_comment[0];
            $com_title = $get_comment[2];
              $com_comment = $get_comment[4];
      }

        if(isset($_POST['submit'])){
          $post_id = $_POST['post_id'];

            $new_title = addslashes($_POST['post_title']);
              $new_comment = addslashes($_POST['post_comment']);
                $new_date = date("Y-m-d") ;
                  $user_id = $_COOKIE['id'];

        $insert = insert_items($user_id, $post_id, $new_title, $new_date, $new_comment);
            $data = edit_data($post_id);
              $post_title = $data['post_title'];
                $image = $data['post_image'];
                  $post_comment = $data['post_comment'];
                    $user_id = comment_data($post_id);
        }
        if(isset($_POST['update'])){
          $com_id = 'a';
          $id = addslashes($_POST['id']);
          $title = addslashes($_POST['title']);
          $comment = addslashes($_POST['comment']);
          $update_comment = update_comments($id, $title, $comment);
        }
        if(isset($_GET['post_id'])){

          $post_id = $_GET['post_id'];
            $data = edit_data($post_id);
              $post_title = $data['post_title'];
                $image = $data['post_image'];
                  $post_comment = $data['post_comment'];
          $user_id = comment_data($post_id);
        }
?>
    <div class="container">
      <div class="row">
        <div class="col-md-4 comments">
            <div class="w3-card-4 cards-bkg" style="width:10">
              <h3><?php echo $post_title; ?></h3>
              <img class="thumbnail" src="../img_upload/<?php echo $image; ?>">
              <p class="card-text"><?php echo $post_comment; ?></p>
              <a href="edit.php?post_id=<?php echo $post_id; ?>" class="btn btn-primary pull-right btn-sm">Editar Post</a>
            </div>
        </div>
<?php
    if(empty($user_id)){
      $btn = 'default';
        $message = 'Nenhum comentário para este post.';
      } else {
          $btn = 'success';
            $message = 'Nós temos '.count($user_id).' Comentários para este post.';
        }
?>
    <div class="col-md-8 comments">
      <div class="message-setter">
        <div class="panel panel-<?php echo $btn; ?>">
          <div class="panel-heading"><?php echo $message; ?></div>
        </div>
      </div>
<?php

  foreach ($user_id as $array) {
      $comment_id = $array['comment_id'];
        echo "<div class='media msg'>";
          echo "<a class='pull-left' href='#'><img class='thumbnail' src='../img/".$array[7]."'></a>";
            echo "<div class='media-body'>";
              echo "<small class='pull-right time'><i class='fa fa-clock-o'></i>".$array['comment_time']."</small>";
                echo "<h5 class='media-heading'>".$array['comment_title']."</h5>";
                echo "<small class='comment post-paragraph'><strong style='color:brown;'>".$array[6].": </strong>". $array['comments']."</small>";
                  echo  "<a href='delete_comment.php?post_id=$post_id&comment_id=$comment_id' type='submit' class='btn btn-warning pull-right btn-xs para-borar' name='delete'>Del</a>";
                    echo "<a href='edit_comment.php?post_id=$post_id&comment_id=$comment_id' class='btn btn-primary btn-sm pull-right btn-xs'>Edit</a>";
                    if($comment_id == $com_id){
                      echo "<form action='' method='post' id='form_hide'>";
                      echo "<div class='form-row'>";
                      echo "<div class='col'>";
                      echo "<input type='hidden' name='id' value='$com_id'>";
                      echo "<input type='text' autofocus='true' name='title' class='form-control form-control-sm' value='$com_title'>";
                      echo "</div>";
                      echo "<div class='col'>";
                      echo "<textarea class='form-control' rows='3' name='comment'>$com_comment</textarea>";
                      echo "<button type='submit' id='btn-update' name='update' class='btn btn-primary btn-sm pull-left'>Update</button>";
                      echo "</div>";
                      echo "</div>";
                      echo "</form>";
                    }
              echo "</div>";
          echo "</div>";
      }
  ?>

    <button type="button" class="btn btn-primary btn-sm pull-right btn-post-comment" data-toggle="modal" data-target="#exampleModalCenter">Criar comentário</button>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Comente aqui</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="comments.php" method="post">
                    <div class="form-group">
                      <label for="title">Título</label>
                      <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                      <input type="text" class="form-control" placeholder="Enter Title" name="post_title" value="<?php echo '' ?>">
                      <small class="form-text text-muted">O título deve ter menos de 20 caracteres.</small>
                    </div>
                    <div class="form-group">
                      <label for="comments">Comentários</label>
                      <textarea class="form-control" rows="3" name="post_comment"></textarea>
                      <small class="form-text text-muted">Comentários com conteúdo violento serão removidos.</small>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" name="submit" class="btn btn-primary btn-sm pull-left">Publicar comentário</button>
                      <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" name="comment">Cancelar</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
<?php }



} else {
  redirect("../logout.php");
}?>
<?php include("footer.php") ?>
