<?php
// Classe  user.php  :


class reponse extends _model
{

    protected $champs = ["question", "text", "correct"]; /* Liste de tout les champs de la table "exemple", */
    protected $table = "reponse"; /* Nom de la table pointé */
    protected $liens = ["question" => "question"]; /* Lien = "nomChamp" => "NomTablePointé" */
 


}
