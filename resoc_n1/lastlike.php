<?php 

$new_user_id = $_SESSION['connected_id'];
$new_post_id = $postId;

$new_user_id  = $mysqli->real_escape_string($new_user_id);
$new_post_id  = $mysqli->real_escape_string($new_post_id);

//check if a unique row exists with the combination  of userId and PostID 
$requeteSQL = "SELECT * FROM likes WHERE user_id=$new_user_id AND post_id=$new_post_id";
$rowExist = $mysqli->query($requeteSQL)->fetch_all();

if($rowExist == []) {//insert
    $lInstructionSql = "INSERT INTO likes "
        . "(id, user_id, post_id) "
        . "VALUES (NULL, "
        . $new_user_id . ", "
        . $new_post_id . "); "
        ;

     $ok = $mysqli->query($lInstructionSql);
     $like = "Unlike";
     
        if (!$ok) {
            echo "like erreur" . $mysqli->error . $lInstructionSql;   
        }
} else {
    $lInstructionSql = "DELETE FROM likes WHERE user_id = $new_user_id AND post_id = $new_post_id";
        $ok = $mysqli->query($lInstructionSql);
        $like = "Like";
}




?>
                 