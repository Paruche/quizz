<?php
// Classe  user.php  :


class user extends _model
{

    protected $champs = ["email", "password", "role", "best", "score"]; /* Liste de tout les champs de la table "exemple", */
    protected $table = "user"; /* Nom de la table pointé */
    protected $liens = ["role" => "role"]; /* Lien = "nomChamp" => "NomTablePointé" */
    

    function verifLogin($email, $password) {
        /* Role : Verifier les informations de connexin
        Retour : True si ok false sinon
        Param : $email et $password du formulaire
         */

        /* Construire la requete sql */
        $sql = "SELECT `id`, `email`, `password` FROM `user` WHERE `email` = :email";
        $param = [":email" => $email];
        /* Recuperer les resultats */
        $result = requestSelect($sql, $param);
        /* Si le tableau est vide c'est que aucun email ne correspond */
        if(empty($result)) {
            $_SESSION["error-log"] = "L'adresse email n'existe pas !";
            return false;
        }
        /* Verifier que le mot de passe correspond bien */
        if(password_verify($password, $result[0]["password"])) {
            /* Donner l'id a l'utilisateur */
            $this->id = $result[0]["id"];
            /* Si tout est ok return true */
            return true;
        } else {
            /* Sinon retourner false */
            $_SESSION["error-log"] = "Le mot de passe ne correspond pas !";
            return false;
        }
        /* Retoourner false si une erreur est pas detecté */
        return false;
    }

}
