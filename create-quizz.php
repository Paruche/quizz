<!-- Controller : creatioon d'un quizz -->

<?php 

include 'temp/frag/header.php';

/* Verifier qu'il est connecté sinon rediriger a l'ecran de connexion */
if(!isConnected()) {
    header('Location: login.php');
    return false;
}

/* Include le questionnaire */
include 'temp/form-quizz.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /* Creer une instance de quizz */
    $quizz = new quizz();
    /* Recuperer les parametres */
    $quizzTitre = htmlspecialchars($_POST["titre"]);
    $nbQ = $_POST["nb-question"];
    /* Les attribué au quizz */
    $quizz->set("titre", $quizzTitre);
    $quizz->set("date", date("F j, Y, g:i a"));
    $quizz->set("auteur", $_SESSION["id"]);
    $quizz->set("verif", false);
    $quizz->set("nbQuestion", $nbQ);
    /* L'inserrer dans la bdd */
    $quizz->insert();

    /* Pour chaque question */
    for($i = 1; $i <= $nbQ; $i++) {
        /* Creer une question */
        $question = new question();
        /* Lui donner l'id du quizz */
        $question->set("quizz", $quizz->id());
        /* Recuperer le titre */
        $qTitre = $_POST["titre" . $i];
        /* Le metttre dans la question */
        $question->set("text", $qTitre);
        /* L'inserer dans la bdd */
        $question->insert();
        /* Recuperer les reponse */
        $reps = $_POST["rep" . $i];
        /* Recuperer la boonne reponse */
        $bonneRep = $_POST["bonneRep-" . $i];
        /* Pour chaque reponse l'inserer dans la bdd avec l'id de la question */
        foreach($reps as $index => $rep) {
            $reponse = new reponse();
            $reponse->set("text", $rep);
            $reponse->set("question", $question->id());
            if($index == (int)$bonneRep){
                $reponse->set("correct", true);
            } else {
                $reponse->set("correct", false);              
            }
            $reponse->insert();
        }
    };
    $_SESSION["messasge"] = "Votre quizz va etre inspecter par notre equipe de modération avant d'etre afficher sur le site";
    header('Location: index.php');
}

?>

