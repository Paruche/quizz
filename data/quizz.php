<?php
// Classe  user.php  :


class quizz extends _model
{

    protected $champs = ["auteur", "date", "titre", "nbQuestion","verif"]; /* Liste de tout les champs de la table "exemple", */
    protected $table = "quizz"; /* Nom de la table pointé */
    protected $liens = ["auteur" => "user"]; /* Lien = "nomChamp" => "NomTablePointé" */
 


}
