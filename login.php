<?php 
/* Include le header */

require_once "temp/frag/header.php";

/* Verifier que l'utilisateur n'est pas déja connecté */
if(isConnected()){
    header('Location: index.php');
    return false;
}
?>


<main>


<!-- Inclure les 2 formulaire de connexion et d'inscription -->
<?php 
include_once "temp/form-login.php";
include_once "temp/form-register.php";


/* Gerer l'inscription : */
/* A l'envoie du formulaire de d'inscription */
if(isset($_POST["formulaire"]) && ($_POST["formulaire"] == "reg") && ($_SERVER["REQUEST_METHOD"] == "POST")) {
    /* Verifier qu'il ne sont pas vide */
    /* Recuperer les parametres */
    $email = $_POST["reg-email"];
    /* Verifier le format de l'email */
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        $_SESSION["error-reg"] = "Le format de l'email est incorrect !";
        return false;
        
    }
    $password = password_hash($_POST["reg-password"], PASSWORD_DEFAULT);
    /* Creer un nouvelle utilisateur */
    $user = new user;
    /* Lui attribuer les parametres */
    $user->set("email", $email);
    $user->set("password", $password);
    $user->set("role", 3);
    /* Inserrer l'utilsiateur dans la bdd */
    $user->insert();
    /* Mettre l'id dans le $session */
    $_SESSION["id"] = $user->id();
    /* Rediriger a l'accueil */
    header('Location: index.php');

}

/* Gerer la connexion : */

/* A l'envoie du formulaire de connexion */
if(isset($_POST["formulaire"]) && ($_POST["formulaire"] == "log") && ($_SERVER["REQUEST_METHOD"] == "POST")) {

    /* Si les champs ne sont pas vide */
    if(!empty($_POST["email"]) && !empty($_POST["password"])) {
        /* Recuperer les valeur des champs */
        $email = $_POST["email"];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        $_SESSION["error-log"] = "Le format de l'email est incorrect !";
        header('Location: login.php');
        return false;
        
    }
        $password = $_POST["password"];
        /* Creer un nouvelle utilisateur */
        $user = new user();

        /* Fonction pour verifier les informations */
        if($user->verifLogin($email, $password)) {
            /* Mettre l'id dans le sessioon id */
            $_SESSION["id"] = $user->id();
            /* Rediriger a la page d'accueil */
            header('Location: index.php');
        }

    }
}
/* A l'envoie du formulaire de connexion  */
?>



<?php 
/* Include le footer */

require_once "temp/frag/footer.php";
?>