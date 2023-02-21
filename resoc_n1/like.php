<?php 
$query = "SELECT id FROM posts";
$result = $mysqli->query($query);
$idPost = $result->fetch_assoc()['id'];
$userid1 = $_SESSION['connected_id'];
$newQuerySQL = "SELECT id FROM likes WHERE user_id = $userid1 AND post_id = $idPost";
$result = $mysqli->query($newQuerySQL);
$idLike = $result->fetch_assoc();

if(!$idLike){
    $like = "Like";
} else {
    $like = "Unlike";
}

$otherButtonClick = isset($_POST['like']);

if ($otherButtonClick){
    if ($like == "Like"){
        $requette = "INSERT INTO likes VALUES (NULL, '$userid1', '$idPost')";
        $lastOk = $mysqli->query($requette);

            if (!$lastOk){
             echo "Impossible de liker ce post" . $mysqli->error;
            } else {
                echo "Vous likez ce post";
                $like = "Unlike";
            }

    } else if ($like == "Unlike"){
        $requette = "DELETE FROM likes WHERE user_id = $userid1 AND post_id = $idPost";
        $lastOk = $mysqli->query($requette);

        if (!$lastOk){
            echo "Impossible d'unliker ce post" . $mysqli->error;
           } else {
               echo "Vous ne likez plus ce post";
               $like = "Like";
           }
    }
}

$newQuery = "SELECT COUNT(post_id) FROM likes WHERE post_id = $idPost";
$newResult = $mysqli->query($newQuery);
$countLike = $newResult->fetch_assoc()['COUNT(post_id)'];

?>
                        <footer>
                            <small> 
                            <form method='post'>
                            <input type='hidden'>
                            <input class="submit" name="like" type='submit' value=" ♥ <?php echo $countLike; ?>  ">
                               
                        </form>
                            
                            </small>
                            <a href="">#  <?php echo $post["taglist"] ?></a>,
                            
                        </footer>