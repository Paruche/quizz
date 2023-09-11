/* Fonction jquery */
$(document).ready(function () {

    /* Recuperer les elements */
    const formLog = $("#form-login");
    const switchLog = $("#switch-login");
    const formReg = $("#form-reg");
    const switchReg = $("#switch-reg");
    /* Masquer le formulaire d'inscription */
    formReg.toggle();
     /* Si on click sur le switchLog on masque le form log et on affiche le form de reg */
    $(switchLog).on("click", function () {
        /* Masquer le form de login */
        $(formLog).fadeOut(300, function() {
            $(formReg).fadeIn(300);
        })
    });

     /* Si on click sur le switchReg on masque le form reg et on affiche le form de log */
     $(switchReg).on("click", function () {
        /* Masquer le form de login */
        $(formReg).fadeOut(300, function() {
            $(formLog).fadeIn(300);
        })
    });
   
    /* A l'envoie du formulaire d'inscription verifier les champs ainsi que l'email n'est pas déja utilisé */
    $(formReg).submit(function (e) { 
        /* Annuler l'envoie du formulaire */
        e.preventDefault();
        /* Recuperer les parametres */
        let email = $("#reg-email").val();
        let password = $("#reg-password").val();
        let rpPass = $("#reg-rp-password").val();

        /* RegExp */
        /* Faire des verifications des champs email*/
        if(email.length < 5) {
            $("#error-reg").text("L'adresse email trop courte !");
            return false;
        }
        
        /* Verifier une longueur de 8 */
        if(password.length < 8) {
            $("#error-reg").text("Le mot de passe est trop court , 8 chracateres minimum")
            return false;
        }
        /* Verifier que les 2 mot de passe sont les meme */
        if(password !== rpPass) {
            $("#error-reg").text("Les 2 mots de passe ne correspondent pas !")
            return false;
        }
        

        /* Mettre en tableau les informations */
        
        let champs = {
            email: email,
        }
        /* Faire la requete ajax qui envoie l'email en verification */
        $.ajax({
            type: "POST",
            url: "verif_mail.php",
            data: champs,
            success: function (response) {
                /* Si la reponse est ok on peut envoyer le formulaire */
                if(response == "true") {
                    document.getElementById("form-reg").submit();
                } else {
                    $("#error-reg").text("L'adresse email est déja utilisé !")
                    return false;
                }
            },
        });
        
    });

    /* Gerer l'envoie du formulaire de connexion */
    $(formLog).submit(function (e) { 
        /* Annuler l'envoie du formulaire */
        

        /* Recuperer les valeurs des champs */
        let email = $("#email").val();
        let password=  $("#password").val();
        
        /* Verifier que l'email est bien rempli */
        if(email.length < 1) {
            $("#error-log").text("Veuillez renseignez votre email !")
            return false;
        }
        /* Verifier que le password est bien rempli */
        if(password.length < 1) {
            $("#error-log").text("Veuillez renseignez votre mot de passe !")
            return false;
        }
        if(email.length < 5) {
            $("#error-log").text("Le format d'email est incorrect !")
            return false;
        }
        
        
    });
    

});

