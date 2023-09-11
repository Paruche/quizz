<?php
// Classe  user.php  :


class question extends _model
{

    protected $champs = ["quizz", "text"]; /* Liste de tout les champs de la table "exemple", */
    protected $table = "question"; /* Nom de la table pointé */
    protected $liens = ["quizz" => "quizz"]; /* Lien = "nomChamp" => "NomTablePointé" */
 


}
