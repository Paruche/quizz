<?php 

/* Include :  */
include "library/init.php";
/* Role : Verifier que l'adresse mail n'est pas déja utilisé */

/* Recuperer les parametres */
$email = $_POST["email"];

/* Creer la requete sql */
$sql = "SELECT `email` FROM `user` WHERE `email` = :email";
$param = [":email" => $email];
/* Recuperer les resultats */
$result = requestSelect($sql, $param);

/* Si un element a ete trouvé return true */
if(empty($result)) {
    echo "true";
} else {
    /* Sinon return false */
    echo "false";
}


?>