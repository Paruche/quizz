$(document).ready(function () {
    /* Cacher le bouttons submit du formulaire */
    $("#btn-quizz-submit").hide();
    /* Recuperer les input */
    nbQ = $(".nb-question");


    /* Cacher ceux a cacher */
    nbQ.hide()

    /* Le champ error */
    let err = $("#error-quizz")

    $("#btn-quizz-next").on("click", function(e) {
        
        /* Au click du suivant verifier que le champs est bien rempli */
        let title = $("#titre").val();
        /* Si la taille du titre est insuffisante reporter une erreur */
        if(title.length < 4) {
            err.text("Veuillez remplir le titre du quizz !")
            return false;
        } else {
            /* Si tout est ok cacher le msg d'erreur */
            err.hide();
        }
        /* Cacher l'input du titre */
        $(".titre").fadeOut(300);

        /* Afficher l'input du nb  de question*/
        nbQ.show();
        /* Masquer le boutton suivant et afficher le submit */
        $("#btn-quizz-next").hide()
        $("#btn-quizz-submit").show()
    });
    /* Des que le nombre change */
    $("#nb-question").on("change", function() {
        let err = $("#error-quizz")
        
        /* Recuperer la div des questions */
        let div = $(".questions");
        /* Recuperer le nombre de questions */
        let nb = $("#nb-question").val();
        /* Verifier qu'on a pas plus de 30 question */
        if(nb > 30) {
            err.show();
            err.text("La limite de questions est de 30 !")
            return false;
        } else {
            err.fadeOut(200);
        }
        /* Si le nombre est sup a 1 masquer le msg d'erreur */
        if(nb > 1) {
            err.fadeOut(200);
        }
        /* Vider le div questions */
        div.empty();

        /* Pour chaque dans nb question creer une div qui demande la question, les 4 reponse & la bonne repons */
        for(var i = 0; i < nb; i++) {

            /* Creer une nouvelle div */
            var newDiv = document.createElement("div");
            newDiv.classList.add("mb-3");

            /* Creer le label de la question */
            var titreLabel = document.createElement("label");
            titreLabel.classList.add("form-label");
            titreLabel.innerHTML = "Question numéro : " + (i + 1);

            /* Creer l'input du titre de la question */
            var titreInput = document.createElement("input");
            /* Lui donner ses attribut */
            titreInput.classList.add("form-control");
            titreInput.name = "titre" + (i + 1);
            titreInput.type = "text";
            titreInput.required = true;
            /* Creer la div des reponses */
            var divRep = document.createElement("div");
            divRep.classList.add("row");
            /* Creer le label de la div checks */
            checksLabel = document.createElement("label");
            checksLabel.classList.add("form-label");
            checksLabel.innerText = "Quel est la bonne réponse ? :"
            /* Creer la div des checkboxes pour la bonne rep */
            let checksDiv = document.createElement("div");
            checksDiv.classList.add("mb-3")
            checksDiv.appendChild(checksLabel);
            /* Creer les 4 boites pour les reponse */
            for(var j = 0; j < 4; j++) {
                /* Creer la div */
                divR = document.createElement("div");
                divR.classList.add("col-6");
                /* Creer le label de la reponse */
                var reponseLabel = document.createElement("label");
                reponseLabel.classList.add("form-label");
                reponseLabel.innerText = "Reponse numéro : " + (j + 1);

                /* Creer un input de reponse */
                var reponseInput = document.createElement("input");
                /* Lui donner ses attributs */
                reponseInput.name = "rep" + (i + 1) + "[]";
                reponseInput.classList.add("form-control");
                /* Ajouter la reponse a la div reponse */
                divR.appendChild(reponseLabel);
                divR.appendChild(reponseInput);
                /* Ajouter la div a la div reponses */
                divRep.append(divR);

                /* Creer l'input de checkboxes */
                var newCheck = document.createElement("input")
                /* Lui donner ses attributs */
                newCheck.type = "radio";
                newCheck.value = (j + 1);
                newCheck.name = "bonneRep-" + (i + 1);
                newCheck.required = "true";
                newCheck.classList.add("form-check-input")
                /* Creer son label */
                checkLabel = document.createElement("label");
                checkLabel.classList.add("form-check-label")
                checkLabel.innerText = (j + 1)

                /* Creer la div */
                let checkDiv = document.createElement("div")
                checkDiv.classList.add("form-check", "form-check-inline")

                /* Le mettre dans le checkdiv */
                checkDiv.appendChild(checkLabel);
                checkDiv.appendChild(newCheck);
                
                checksDiv.append(checkDiv);

            }
            /* Creer la div */
            var divBonne = document.createElement("div");
            /* Lui donner ses attribut */
            divBonne.classList.add("mb-3");

            /* Creer le label */
            var bonneLabel = document.createElement("label");
            /* Lui donner ses attribut */
            bonneLabel.classList.add("form-label");
            bonneLabel.innerText = "La bonne réponse de 1 a 4"
            /* Creer l'input de la bonne réponse */
            var bonneRep = document.createElement("input");
            /* Donner ses attribut */
            bonneRep.type = "number";
            bonneRep.classList.add("form-control")
            bonneRep.min = "1";
            bonneRep.max = "4";
            bonneRep.name = "bonne-" + (i + 1);
            /* Donner les elements a la div */
            divBonne.appendChild(bonneLabel);
            divBonne.appendChild(bonneRep);

            /* Ajouter les elements a la div */
            newDiv.appendChild(titreLabel)
            newDiv.appendChild(titreInput)
            newDiv.appendChild(divRep);
            /* Ajouter la div au conteneur */
            div.append(newDiv);
            div.append(checksDiv);
        }
        
    });
    /* A l'envoie du formulaire verifier qu'il y a au moin 2 question */
    $("#form-quizz").submit(function() {
        if($("#nb-question").val() < 2) {
            err.text("Veuillez remplir au moin 2 question(s)");
            err.show();
            return false;
        }
    })

});