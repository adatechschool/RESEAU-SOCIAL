<?php
    include 'header.php';
?>
        <div id="wrapper">          
            <aside>
                <img src = "https://img.freepik.com/free-vector/tiny-people-beautiful-flower-garden-inside-female-head-isolated-flat-illustration_74855-11098.jpg?w=826&t=st=1677081124~exp=1677081724~hmac=ac2206dde303e4f32582f5588a7a845bb9a583095ac17674d05106cfcd19f9a4" alt = "Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez la liste des personnes qui
                        suivent les messages de l'utilisatrice 
                        n° <?php echo intval($_GET['user_id']) ?>
                        


                </section>
            </aside>
            <main class='contacts'>
                <?php
                // Etape 1: récupérer l'id de l'utilisateur
                $userId = intval($_GET['user_id']);
                // Etape 2: se connecter à la base de donnée
                $mysqli = new mysqli("localhost", "root", "", "socialnetwork");
                // Etape 3: récupérer le nom de l'utilisateur
                $laQuestionEnSql = "
                    SELECT users.*
                    FROM followers
                    LEFT JOIN users ON users.id=followers.following_user_id
                    WHERE followers.followed_user_id='$userId'
                    GROUP BY users.id
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                // Etape 4: à vous de jouer
                //@todo: faire la boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous 
                while ($post = $lesInformations->fetch_assoc()){
                     echo "<pre>" . print_r($post, 1) . "</pre>";
                ?>
                <article>
                    <img src="user.jpg" alt="blason"/>
                    <h3><a href="wall.php?user_id=<?php echo $post["id"] ?>"> <?php echo $post["alias"] ?></a></h3>
                    <p>id : <?php echo $post['id'] ?></p>
                </article>
                <?php
                }
                ?>
            </main>
        </div>
    </body>
</html>
