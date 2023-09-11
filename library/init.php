<?php
/* 
Initialisation générale des prohrammes (URL)
Ficher à inclure en début de toutes les URL
*/
/* Demarrer une sessions */
session_start();
/* include */

include 'library/outils.php';
include 'library/modele.php';
include 'library/functions.php';

include 'data/user.php';
include 'data/role.php';
include 'data/reponse.php';
include 'data/quizz.php';
include 'data/question.php';




// Pour la mise au point : afficher les messages d'erreur PHP
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Ouvrir la base de données dans la variable globale $bdd
global $bdd;       
$bdd = new PDO("mysql:host=localhost;dbname=admin;charset=UTF8", "root", "" );
// En mise au point : pour afficher les erreurs que remonte la base d données
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

?>