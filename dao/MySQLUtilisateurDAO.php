<?php

    require_once  (__DIR__).'/../models/Utilisateur.php';
    require_once 'UtilisateurDao.php';

    class MySQLUtilisateurDAO implements UtilisateurDao{

        private $cnx;

        public function __construct($cnx){      // Constructor
            $this->cnx = $cnx;
        } 

        public function __destruct()        // Destructor
        {
            $this->cnx = null;
        }

        public function  insert(Utilisateur $utilisateur)        //return ID of the last INSERT, -1 for failure
        {
            // die($utilisateur->getNom());

            try {
                $requete = $this->cnx->prepare("INSERT INTO Utilisateur(mdp_utilisateur, nom_utilisateur, prenom_utilisateur, mail_utilisateur, admin) 
                                                VALUES (:mdp, :nom, :prenom, :email, :admin)");

                $requete->bindValue(':mdp', $utilisateur->getMdp());
                $requete->bindValue(':nom', $utilisateur->getNom());
                $requete->bindValue(':prenom', $utilisateur->getPrenom());
                $requete->bindValue(':email', $utilisateur->getMail());
                $requete->bindValue(':admin', $utilisateur->getAdmin());
                $requete->execute();
                $utilisateur = $requete->fetchObject("Utilisateur");
                
                return $utilisateur;
                
            } catch (PDOException $e) {
                throw new BDDException($e->getMessage(), $e->getCode());
                return -1;
            }
        }

        public function identifier(Utilisateur $utilisateur)     //retourne le nom et mdp de l'utilisateur identifié
        {

            try {
                $mdpClair = $utilisateur->getMdp();                    // Récupérer mdp en clair
                // var_dump($mdpClair);
                $mdpObscur = hash('sha256', $mdpClair);                // Le passer en crypté sur les mêmes bases que BDD
                // die($mdpObscur);

                $requete = $this->cnx->prepare("SELECT mail_utilisateur, mdp_utilisateur  FROM Utilisateur 
                                                WHERE mail_utilisateur = '{$utilisateur->getMail()}'
                                                AND mdp_utilisateur = '{$mdpObscur}'");
                $requete->execute();
                $result = $requete->fetchColumn(0); 

                if ($result != '') {
                    return true;
                    // return [
                    //     'test' => true,
                    //     'message' => '',
                    //     'code' => 200
                    // ];
                } else {
                    return false;
                    // return [
                    //     'test' => fasle,
                    //     'message' => 'rentre chez ta mère',
                    //     'code' => ''
                    // ];
                }
                

            } catch (PDOException $e) {
                throw new BDDException($e->getMessage(), $e->getCode());
                return -1;

                // return [
                //     'test' => fasle,
                //     'message' => $e->getMessage(),
                //     'code' => $e->getCode()
                // ];  
            }
        }

        public function sessionUtilisateur(Utilisateur $utilisateur)   
        {

            $text = "SELECT id_utilisateur, prenom_utilisateur, nom_utilisateur, mail_utilisateur, admin
                                            FROM Utilisateur
                                            WHERE mail_utilisateur = '{$utilisateur->getMail()}'";

            try {

                $requete = $this->cnx->prepare($text);
                $requete->execute();
     
                $requete->setFetchMode(PDO::FETCH_ASSOC);

                // $result = $requete->fetchColumn();

                $result = $requete->fetchAll();

                foreach($result as $j)
                {
                    $user[]= new Utilisateur("", $j['nom_utilisateur'], $j['prenom_utilisateur'], 
                                            $j['mail_utilisateur'], $j['admin'], $j['id_utilisateur']);
                }

                return $user[0];

            } catch (PDOException $e) {
                throw new BDDException($e->getMessage(), $e->getCode());
                return -1;
            }
        }
    }