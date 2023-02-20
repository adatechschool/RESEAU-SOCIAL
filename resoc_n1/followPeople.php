<?php $user_idactuel = $_SESSION['connected_id'] ?>
<div>
    <?php
    //Récupérer l'id du compte sur lequel on se trouve
    $userId = intval($_GET['user_id']);
    //Connexion à la base de données
    $mysqli = new mysqli("localhost", "root", "", "socialnetwork");
    //Si on suit déjà le compte, on stocke l'id de cette "amitié" dans $following_followed
    $querySQL = "SELECT id FROM followers WHERE followed_user_id = $userId AND following_user_id = $user_idactuel";
    $following_followed = $mysqli->query($querySQL)->fetch_assoc();
    //Si l'amitié n'existe pas (=pas d'id dans la table followers), le bouton est "S'abonner" (et inversement)
    if (! $following_followed) {
        $value = "S'abonner";
    } else {
        $value = "Se désabonner";
    }
    //Vérifier si le bouton est cliqué
    $enCoursDeTraitement = isset($_POST['subscribe']);
    //Si le bouton est "S'abonner" :
    if ($value == "S'abonner") {
        // Si le bouton est cliqué :
        if ($enCoursDeTraitement) {
            //Changer la valeur du bouton
            $value = "Se désabonner";
            //Construire la requête : ajouter le compte aux comptes qu'on suit
            $lInstructionSql = "INSERT INTO followers VALUES (NULL, '$userId', '$user_idactuel')";
                //VALUES = id, followed_user_id (=le compte qu'on suit), following_user_id (=nous)
            //Executer la requête
            $ok = $mysqli->query($lInstructionSql);
            if (! $ok) {
                echo "Impossible de suivre ce compte : " . $mysqli->error;
            } else {
                echo "Vous suivez désormais le compte de l'utilisatrice n°$userId";
            }
        }
    //Sinon, lorsque le bouton est "Se désabonner" :
    } elseif ($value == "Se désabonner") {
        // Si le bouton est cliqué :
        if ($enCoursDeTraitement) {
            //Changer la valeur du bouton
            $value = "S'abonner";
            //Construire la requête : supprimer le compte des comptes qu'on suit
            $sqlQuery = "DELETE FROM followers WHERE following_user_id = $user_idactuel";
            //Executer la requête
            $queryOk = $mysqli->query($sqlQuery);
            if (! $queryOk) {
                echo "Impossible de ne plus suivre ce compte : " . $mysqli->error;
            } else {
                echo "Vous ne suivez plus le compte de l'utilisatrice n°$userId";
            }
        }
    }
    ?>
    <form method='post'>
        <input type='hidden' name='???' value='a_changer'>
        <input class="submit" name="subscribe" type='submit' value="<?php echo $value;?>">
    </form>
</div>






