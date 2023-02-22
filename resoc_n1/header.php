<?php
session_start();
if (isset($_SESSION['connected_id'])){
    $_SESSION['connected_id'];
} else {
    header('Location: login.php');
    exit();
};


?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Mur</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"> 
    </head>
    <body>
        <header>
            <img src="https://img.freepik.com/free-vector/young-people-standing-talking-each-other-speech-bubble-smartphone-girl-flat-vector-illustration-communication-discussion_74855-8741.jpg?w=900&t=st=1677080008~exp=1677080608~hmac=691ddc52cbcabcf2cc0a5c6e2c9703767fa598e88fddedc1281aeb2de1b71f2c" alt="Logo de notre réseau social"/>
            <nav id="menu">
                <a href="news.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Actualités</a>
                <a href="wall.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Mur</a>
                <a href="feed.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Flux</a>
                <a href="tags.php?tag_id=1">Mots-clés</a>
            </nav>
            <nav id="user">
                <a href="#">Profil</a>
                <ul>
                    <li><a href="settings.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Paramètres</a></li>
                    <li><a href="followers.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Mes suiveurs</a></li>
                    <li><a href="subscriptions.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Mes abonnements</a></li>
                </ul>

            </nav>
        </header>
        <style>
            body {
    background-color: #60a3d9;
    font-family: 'Poppins', sans-serif;
            }
            body>header {
    background-color:#c2e2f5;
    box-shadow:5px 5px 2px #746c70 ;
    border-radius:15px;
            }
 
        </style>