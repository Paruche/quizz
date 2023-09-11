<!-- Fragment header de notre page -->

<?php include "library/init.php" ;

/* Recuperer le role de l'utilisateur */
if(!empty($_SESSION["id"])) {
    $user = new user($_SESSION["id"]);
    $role = $user->get("role")->id();
}


?>

<!-- Html -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/jquery.js"></script>
<script src="js/forms.js"></script>
<script src="js/quizz.js"></script>

</head>
<body>
    <!-- NavBar -->
<header>
        <div class="logo">
            <a href="index.php"><h1>Logo</h1></a>
        </div>
        
        <div class="nav">
            <a href="list-quizz.php">Les Quizz</a>
            <a href="create-quizz.php">Creer un quizz</a>
        </div>
        <!-- Afficher ce boutton que si l'utilisateur n'est pas connecter-->
        <?php 
        if(!isConnected()) {
            echo '<a href="login.php" class="nav-lien">Connexion / Inscription</a>';
        } else if ($role == 1 || $role == 2) {
            echo '<a href="admin.php" class="nav-lien">Admin</a>';
        } else {
            echo '<a href=""></a>';
        }
        ?>
        
        <!-- Si le role de l'utilisateur est admin ou modo afficher le boutton admin sinon laisser vide-->
        
</header>
