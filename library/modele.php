<?php
// Classe mere modele.php  : Gestion d'objet du modele de base de donnees 

/*  Liste fonctions : 
    
    function __construct(id = null) : si l'id est renseigne charger directement l'objet

    function get(nomChamp) : Getter pour retourner la valeur d'un champ ou un objet via un lien
    function set(nomChamp, valeur) : Setter pour changer la valeur d'un champ

    function id() : retour l'id de l'objet
    function IdLoad(id) : charger l'objet dans la bdd depuis l'id

    function is() : Verifier qu'un objet  existe et a un id
    function tabLoad($tab): charger l'objet depuis un tableau 
    function getAll(): recuperer un tableau de tout les objet de la table courante 

    function insert() : inserrer l'objet dans la bdd avec le dernier id 
    function update(): mettre a jour l'objet dans la bdd    
    function delete(): supprimer l'objet dans la bdd

    function makeUpdateInsertChamps() : Creer le morceau de requete sql pour la fonction insert()
    function makeParamChamps() : Creer le tableau de parametre pour la fonction insert()
    function executeRequest() : Preparer et executer la requete pour la bdd
 */
 




class _model
{

    protected $champs = []; /* Liste de tout les champs de la table "exemple", */
    protected $table = ""; /* Nom de la table pointé */
    protected $liens = []; /* Lien = "nomChamp" => "NomTablePointé" */

    protected $id = 0; /* Id = 0 si non chargé */
    protected $valeurs = []; /* Tableau des valeurs de l'objet*/


    function __construct($id = null)
    /* Constructeur Id  */
    /* Role : si id donné charger l'objet directement depuis l'id */
    /* Retour : none */
    /* Param : $id : id a charger */
    {
        if (isset($id)) {
            $this->IdLoad($id);
        }
    }

    function get($nomChamp)
    {
        /* Role : Retourne la valeur d'un champ ou l'objet si c'est un lien 
        Retour : La valeur du champs ou "" si n'existe pas
        Param : $nomChamp : Nom du champs ou de l'objet a retourner
        */

        /* Verifier que le NomChamps est un lien vers un objet */
        if(isset($this->liens[$nomChamp])) {
            return $this->getLink($nomChamp);
        }

        /* Si le champs existe et qu'on a son nom dans $->valeurs */
        /* Si la valeur n'est pas vide dans $->valeurs */
        if(in_array($nomChamp, $this->champs) and isset($this->valeurs[$nomChamp])) {
            return $this->valeurs[$nomChamp];
        } else {
            /* Sinon return "" */
            return "";
        }

    }
    function getLink($nomChamp) {
        // Rôle : retourner l'objet pointé par un champ donné
        // Retour : l'objet pointé, chargé si il existe sinon null
        // Paramètres :
        //      $nomChamp : nom de l'objet à retourner


        // Si $nomChmamp n'est un nom de line, on reourne null
        if ( ! isset($this->liens[$nomChamp]) ) {
            return null;
        }

        // On récupère la classe de l'objet lié
        $modelObjet = $this->liens[$nomChamp];
        // On récupère un objet de cette classe
        $objet = new $modelObjet();
        // ON le charge si on a une valeur pour ce champ
        if ( isset($this->valeurs[$nomChamp])) {
            $objet->idLoad( $this->valeurs[$nomChamp] );
        }
        // ON le retourne
        return $objet;

    }

    function set($nomChamp, $val)
    {
            /* 
            Role : set ou modif la valeur du champ visé
            Retour : true si ok false sinon
            Param : $nomChamp : Nom du champs visé et $val : nouvelle valeur du champs
            */
            /* Verifier que le nom champs existe sinon return false */
            if(!in_array($nomChamp, $this->champs)) {
                return false;
            }
            /* Sinon mettre la nouvelle valeur */
            $this->valeurs[$nomChamp] = $val;

            return true; 
    }
    function id() 
    {
        /* 
        Role : Retourner l'id
        Retour: valeur de l'id ou 0 si empty
        Param : none
        */

        /* Si l'id est vide return 0*/
        if(empty($this->id)) {
            return 0;
        } else {
        /* Sinon retournez l'id */
        return $this->id;
        }
    }
    function IdLoad($id){
        /* 
        Role : Charger un objet depuis un id
        Retour:  true si ok false sinon
        Param : $id = id recherché
        */
        
        /* On commence par vidé l'objet */
        $this->id = 0;
        $this->valeurs = [];

        /* Construire la requete sql */
        $sql = "SELECT `id` ";
        /* Pour chaque champs on ajoute , `nomChamp` */
        foreach($this->champs as $nomChamp) {
            $sql .= ", `$nomChamp`";
        }
        /* Ajouter la table et la condition a la requete */
        $sql .= " FROM `$this->table` WHERE `id` = :id";
        $param = [":id" => $id];

        /* Executer la requete */
        $req = $this->executeRequest($sql, $param);

        /* Verifier que la rep != false */
        if($req == false) {
            return false;
        }

        /* Recuperer les lignes */
        $lignes = $req->fetchAll(PDO::FETCH_ASSOC);

        /* Si le resultat est vide return false */
        if(empty($lignes)) {
            return false;
        } else {
            /* Sinon on charge les resultat dans l'objet */
            $this->tabLoad($lignes[0]);
            /* On recupere l'id */
            $this->id = $lignes[0]["id"];
            return true;
        }
    }
    function is(){
        /* 
        Role : Indiquer si un objet existe et qu'il a un id
        Retour : true si existe false sinon
        Param : none
        */

        return !empty($this->id);
    }

    function tabLoad($tab) {
        /* 
        Role : Charger les valeurs des champs d'un objets depuis un tableau
        Retour : none
        Param: $tab = tableau contenant les valeurs des champs
        */

        /* Pour chaque champ de l'objet si on a une valeur dans le $tab */
        foreach($this->champs as $nomChamp) {
            if(isset($tab[$nomChamp])) {
                $this->set($nomChamp, $tab[$nomChamp]);
            }
        }
    }
    function getAll() {
        // Rôle : Recuperer tout les objets de la table
        // Retour : tableaud'objets du type de cette classe indexe par l'id
        // paramètres : none

        // Construit le code SQL
        $sql = "SELECT `id`";
        // Pour chaque champ, on ajoute , `nomChamp`
        foreach($this->champs as $nomChamp) {
            $sql .= ", `$nomChamp`";
        }

        $sql .= " FROM `$this->table`";

        // On l'exécute
        $req = $this->executeRequest($sql);

        if ($req == false) {
            // Si erreur retourner tableau vide
            return [];
        }


        // On part d'un tableau de résultat vide
        $result = [];
        // Pour chaque ligne extraite :
        foreach($req->fetchAll(PDO::FETCH_ASSOC) as $ligne) {
            //      créer un ojet correspondant à la ligne
            $class = get_class($this);
            $obj = new $class();       // on crée un objet de la classe courante (mise dans $class). ON peut aussi faire $obj = new self();
            // Remplir l'objet
            // Son id
            $obj->id = $ligne["id"];
            // Les champs "classiques"
            $obj->tabLoad($ligne);
            //      ajouter cet objet dans le tableau de résultat (avec le bon index)
            $result[$ligne["id"]] = $obj;
        }

        // Retourne ce résultat
        return $result;
    }
    function insert() {
        // Rôle : Inserrer l'objet dans la bdd
        // Retour : true si on a réussi, false sinon
        // Paramètres : néant


        // construire la requête SQL
        $sql = "INSERT INTO `$this->table` SET ";
        $sql .= $this->makeUpdateInsertChamps(); 

        // Construction des paramétres;
        $param = $this->makeParamChamps();
        

        // Préparer / excéuter la requête
        $req = $this->executeRequest($sql, $param);

        // Si $req est false : on a echoué
        if ($req == false) {
            $this->id = 0;
            return false;
        }


        // Récuperer l'id crée (et le stocket dans $this->id)
        global $bdd;
        $this->id = $bdd->lastInsertId();
        return true;
    }
    function update() {
        // Rôle: mettre à jour l'objet courant dans la base de données
        // Retour : true si réussi, false sinon
        // Paramètres : néant

        // Construire la requete sql
            $sql = "UPDATE `" . $this->table . "` SET ";
            $param = [];  
            // on part d'un tableau vide           
            $tab = [];
            // Pour chaque champs implode dans la requete sql      
            foreach($this->champs as $nomChamp) {
                $tab[] =  " `$nomChamp` = :$nomChamp ";
                // On en profite pour valoriser le paramètre que l'on vient de "créer" : sa valeur $this->valeurs[$nomChamp] 
                // SI la valeur existe : on la met, sinon on met null
                $param[":$nomChamp"] = (isset($this->valeurs[$nomChamp])) ? $this->valeurs[$nomChamp] : null;               
            }
            $sql .= implode(', ', $tab);

            // on ajoute la condition WHERE
            $sql .= " WHERE `id` = :id";
            // On valorise le paramètre :id que l'on vient d'utiliser
            $param[":id"] = $this->id;          

            // Préparer la requête (en lui passant la requête)
            global $bdd;
            $req = $bdd->prepare($sql);
            // exécuter la requête préparée en lui npassantle tableau de valeurs des paramètres : ce exécuter nou dit si c'est réussi ou pas 
            $cr = $req->execute($param);


            return $cr;   
        }
    function delete() {
        // Rôle: supprimer l'objet donné de la base de données
        // Retour : true si réussi, false sinon
        // Paramètres : none


        /* Construire la requete sql */
        $sql = "DELETE FROM `$this->table` WHERE id = :id";
        $param = [ ":id" => $this->id ];

        /* Recuperer la requete ou false */
        $cr = $this->executeRequest($sql, $param);  

        // Si ok : mettre id à 0, retourner true
        if ($cr != false) {
            $this->id = 0;
            return true;
        } else {
            // Sinon : retourner false
            return false;
        }

    }
    function makeUpdateInsertChamps() {
        // Rôle : fabriquer le bout de de requête SQL `nomChamp1` = :valeur1, `nomChamp2` = :valeur2, .....
        // Retour : le texte fabriqué
        // Paramètres : néant

        // ON va fabriquer un tableau dont chaque élément est "`nomChamp1` = :valeur1"
        $tab = [];
        // Pour chacun des champs : crer le bout de sql nomChamp1 = valeur1
        foreach($this->champs as $nomChamp) {
            $tab[] = "`$nomChamp` = :$nomChamp";
        }

        return implode(', ', $tab);
        

    }

    function makeParamChamps() {
        // Rôle : fabriquer le tableau des paramètres pour les champs : [ ":nomChamp1" => valeur1, ... ]
        // Retour : le tableau
        // Paramètres : néant

        // ON va fabriquer un tableau dont chaque élément est ":nomChamp1" => valeur1
        $tab = [];
        // Pour chacun des champs : ajouet l'élément dans $tab
        foreach($this->champs as $nomChamp) {
            // Si la valeurexiste : on la met
            // Sinon : on met null
            if (isset($this->valeurs[$nomChamp])) {
                $tab[":$nomChamp"] = $this->valeurs[$nomChamp];
            } else {
                $tab[":$nomChamp"] = null;
            }
        }

        // On retourne le tableau fabriqué
        return $tab;
     

    }

    function executeRequest($sql, $param = [] ) {          
        // Role : prépare et execute une requête sur la BDD
        // Retour : la requête exécutée, false en cas d'échec
        // Paramètres :
        //   $sql : le texte de la requête
        //   $param : le tableau de valorisation des paramètres :xxx

        global $bdd;        // On récupère la BDD ouverte

        // Créer une requête
        $req = $bdd->prepare($sql);

        // Exécuter la requête
        if ( ! $req->execute($param)) {
            // La requête a échoué
            echo "Echec de la requête $sql avec les paramètres : ";
            print_r($param);
            return false;
        }

        // Cela s'est bien passé : on retourne la requête
        return $req;
    }
}
