<?php
//Fonctions de base pour les quetes a la bdd


function requestSelect($sql, $param) {
    // Rôle: préparer et exécuter une requete sql dans la bdd
    // Retour : tableau de chaque elements trouvé sinon tableau vide 
    // Paramètres :
    //      $sql : requête SQL SELECT
    //      $param : tableau pour valoriser les parametre sql

    // récupérer la base de données ouverte
    global $bdd;

    // Créer une requête préparée
    $req = $bdd->prepare($sql);
    if ($req === false) {
        return [];
    }

    // Exécuter la requête (en apssant les paramètres)
    if ( $req->execute($param) == false) {
        return [];
    }

    // récupérer le tableau de résultat
    return $req->fetchAll(PDO::FETCH_ASSOC);

}


function requestUpdate($sql, $param) {
    // Rôle: préparer et exécuter une req sql dans la bdd de type UPDATE ou DELETE
    // Retour : true si ok, false sinon
    // Paramètres :
    //      $sql : requête SQL commençant UPDATE ou DELETE
    //      $param : tableau pour valoriser les parametre sql

    // récupérer la base de données ouverte
    global $bdd;

    // Créer une requête préparée
    $req = $bdd->prepare($sql);
    if ($req === false) {
        return false;
    }

    // Exécuter la requête (en apssant les paramètres)
    if ( $req->execute($param) == false) {
        return false;
    }

    // Si tout est ok return true
    return true;

}

function requestInsert($sql, $param) {
    // Rôle: préparer et exécuter une req SQL dans la bdd de type INSERT
    // Retour : null si erreur, l'id de la ligne créée si la création s'est bien passée
    // Paramètres :
    //      $sql : requête SQL commençant par UPDATE (avec éventuellement des paramètres :xxx)
    //      $param : tableau valorisant les paramètres SQL :xxx

    // récupérer la base de données ouverte
    global $bdd;

    // Créer une requête préparée
    $req = $bdd->prepare($sql);
    if ($req === false) {
        return null;
    }

    // Exécuter la requête (en apssant les paramètres)
    if ( $req->execute($param) == false) {
        return null;
    }

    // c'est bon : on retourne l'id créé
    return $bdd->lastInsertId();
}
function isConnected() {
    /* 
    Role : Verifier qu'un utilisateur est connecté
    Retour: true si ok false sinon
    Param: none    
    */
    if(empty($_SESSION["id"])) {
        return false;
    } else {
        return true;
    }
}
function isAdmin() {
    /* Role : Verifier qu'un utilisateur est admin 
    Retour : true si ok false sinon
    Param : $SESSION id*/
    
    /* Admin: id=1 */
    /* Si l'id est vide */
    if(empty($SESSION["id"])) {
        return false;
    } 
    /* Ou s'il nest pas bon */
    if($_SESSION["id"] == 1) {
        return true;
    } else {
        return false;
    }
}
