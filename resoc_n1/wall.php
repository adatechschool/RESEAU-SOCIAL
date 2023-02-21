<?php
    include 'header.php';
?>
        <div id="wrapper">

        

            <?php
            /**
             * Etape 1: Le mur concerne un utilisateur en particulier
             * La première étape est donc de trouver quel est l'id de l'utilisateur
             * Celui ci est indiqué en parametre GET de la page sous la forme user_id=...
             * Documentation : https://www.php.net/manual/fr/reserved.variables.get.php
             * ... mais en résumé c'est une manière de passer des informations à la page en ajoutant des choses dans l'url
             */
            $userId =intval($_GET['user_id']);
            ?>
            <?php
            /**
             * Etape 2: se connecter à la base de donnée
             */
            $mysqli = new mysqli("localhost", "root", "", "socialnetwork");
            ?>

            <aside>
                <?php
                /**
                 * Etape 3: récupérer le nom de l'utilisateur
                 */                
                $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $user = $lesInformations->fetch_assoc();
                //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous
                // echo "<pre>" . print_r($user, 1) . "</pre>";
                ?>
                <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez tous les message de l'utilisatrice : <a href="wall.php?user_id=<?php echo $user["id"] ?>"> <?php echo $user["alias"] ; ?></a>
                        
                        (n° <?php echo $userId ?>)

                       <article>
      
            <?php
    $user_id1 = $_SESSION['connected_id'];
    //echo "<pre>" . print_r($_GET['user_id']) . "</pre>";
    if($_GET['user_id'] == $_SESSION['connected_id']){ 
        ?> <h1>Poster un message</h1>

        <?php
   
    if (isset($_POST['message'])){
        $postContent1 = $mysqli->real_escape_string($_POST['message']);

        $lInstructionSql1 = "INSERT INTO posts (user_id, content, created) "
        . "VALUES ('$user_id1', '$postContent1', NOW())";

        $ok = $mysqli->query($lInstructionSql1);
        if (!$ok) {
            echo "Impossible d'ajouter le message: " . $mysqli->error;
        } else {
            echo "Message posté avec succès";
        }
    } 
?>
                   
                    <form action="wall.php?user_id=<?php echo $user["id"] ?>" method="post">
                        <input type='hidden' name='user_id1' value="<?php echo $user_id1; ?>">
                        <dl>
                            <dt><label for='message'>Ecrire un nouveau message</label></dt>
                            <dd><textarea name='message'></textarea></dd>
                        </dl>
                        <input type='submit'>
                    </form>               
    </article>
               
 <?php } else { 
 $querySQL = "SELECT id FROM followers WHERE followed_user_id = $userId AND following_user_id = $user_id1";
 $idFriend = $mysqli->query($querySQL)->fetch_assoc();
 
 if (!$idFriend){
     $button = "Suivre";
 } else {
     $button = "Ne plus suivre";
 }
 
 $buttonClick = isset($_POST['subscribe']);
 
 if ($buttonClick) {
     if ($button == "Suivre"){
         $questionSQL = "INSERT INTO followers VALUES (NULL, '$userId', '$user_id1')";              
         $newOk = $mysqli->query($questionSQL);
 
         if (!$newOk){
             echo "Impossible de suivre cette utilisatrice" . $mysqli->error;
         } else {
             echo "Vous suivez cette utilisatrice";
             $button = "Ne plus suivre";
         }
     } else if ($button == "Ne plus suivre") {
         $otherQuestion = "DELETE FROM followers WHERE followed_user_id = $userId AND following_user_id = $user_id1";
         $newOk = $mysqli->query($otherQuestion);
 
         if (!$newOk){
             echo "impossible d'arrêter de suivre cette utilisatrice" . $mysqli->error;
         } else {
             echo "Vous ne suivez pas cette utilisatrice";
             $button = "Suivre";
         }
     }
 }

?>

<form method='post'>
 <input type='hidden'>
 <input class="submit" name="subscribe" type='submit' value="<?php echo $button; ?>">
</form>


            <?php } ?>
                    </p>

                </section>
                <?php

                
    ?>


  
            </aside>
            <main>
                <?php
                /**
                 * Etape 3: récupérer tous les messages de l'utilisatrice
                 */
                $laQuestionEnSql = "
                    SELECT posts.content, posts.created, users.alias as author_name, 
                    COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE posts.user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                }

                /**
                 * Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
                 */
                while ($post = $lesInformations->fetch_assoc())
                {

                    //echo "<pre>" . print_r($post, 1) . "</pre>";
                    ?>                
                    <article>
                        <h3>
                            <time datetime='2020-02-01 11:12:13' >31 février 2010 à 11h12</time>
                        </h3>
                        <address>par <a href="wall.php?user_id=<?php echo $user["id"] ?>"> <?php echo $user["alias"] ; ?></a></address>
                        <div>
                            <p><?php echo $post["content"] ?></p>
                            
                        </div>                                            
                        <footer>

<?php 
$query = "SELECT id FROM posts";
$result = $mysqli->query($query);
$idPost = $result->fetch_assoc()['id'];
$newQuerySQL = "SELECT id FROM likes WHERE user_id = $user_id1 AND post_id = $idPost";
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
        $requette = "INSERT INTO likes VALUES (NULL, '$user_id1', '$idPost')";
        $lastOk = $mysqli->query($requette);

            if (!$lastOk){
             echo "Impossible de liker ce post" . $mysqli->error;
            } else {
                echo "Vous likez ce post";
                $like = "Unlike";
            }

    } else if ($like == "Unlike"){
        $requette = "DELETE FROM likes WHERE user_id = $user_id1 AND post_id = $idPost";
        $lastOk = $mysqli->query($requette);

        if (!$lastOk){
            echo "Impossible d'unliker ce post" . $mysqli->error;
           } else {
               echo "Vous ne likez plus ce post";
               $like = "Like";
           }
    }
}

?>

                            <small> 
                            <form method='post'>
                            <input type='hidden'>
                            <input class="submit" name="like" type='submit' value=" ♥ <?php echo $like; ?>  <?php echo $post["like_number"] ?>">
                            </form>
                            </small>
                            <a href="">#  <?php echo $post["taglist"] ?></a>,
                            <!-- <a href="">#piscitur</a>, -->
                        </footer>
                    </article>
                <?php } ?>


            </main>
        </div>
    </body>
</html>
