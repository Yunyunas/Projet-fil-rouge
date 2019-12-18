<?php

    require_once "Rubrique.php";
    require_once "Utilisateur.php";


    class Annonce{

        private $id_annonce;
        private $utilisateur;
        private $rubrique;
        private $en_tete_annonce;
        private $corps_annonce;
        private $date_depot;
        private $date_validite;

// Construction
        public function __construct(Utilisateur $utilisateur = NULL, Rubrique $rubrique = NULL,
                                    $enTete = '', $corps = '', $dateDepot = NULL, $dateValidite = NULL,
                                    $id_annonce = -1)
        {
            $this->id_annonce = $id_annonce;
            $this->utilisateur = $utilisateur;
            $this->rubrique = $rubrique;
            $this->en_tete_annonce = $enTete;
            $this->corps_annonce = $corps;
            $this->date_depot = new DateTime($dateDepot);
            $dateValidite = $dateValidite;
            $this->date_validite = new DateTime($dateDepot);
            $this->date_validite->add(new Dateinterval("P21D"));
        }

//Tostring
        public function __toString(){
            return 
            $this->utilisateur->getNom().' | '.
            $this->utilisateur->getPrenom().' | '.
            $this->utilisateur->getMail().' | '.
            $this->rubrique->getLibelle().' | '.
            $this->en_tete_annonce.' | '.
            $this->corps_annonce.' | '.
            $this->date_depot->format("Y-m-d").' | '.
            $this->date_validite->format("Y-m-d");
        }

//Getters
        public function getId(){
            return $this->id_annonce;
        }
// getIdUser
        public function getUser(){
            return $this->utilisateur;
        }

        public function getRubrique(){
            return $this->rubrique;
        }

        public function getEnTete(){
            return $this->en_tete_annonce;
        }

        public function getCorps(){
            return $this->corps_annonce;
        }

        public function getDate_depot(){
            return $this->date_depot->format("Y-m-d");
        }

        public function getDateValidite(){
            return $this->date_validite->format("Y-m-d");
        }

//Setters
        public function setIdAnnonce($id){
            $this->id_annonce = $id;
        }

        public function setUser($id_user){
            $this->utilisateur = $id_user;
        }

        public function setRub($id_rub){
            $this->rubrique = $id_rub;
        }

        public function setEnTete($enTete){
            $this->en_tete_annonce = $enTete;
        }

        public function setCorps($corps){
            $this->corps_annonce = $corps;
        }

        public function setDateDepot($dateDepot){
            $this->date_depot = new DateTime($dateDepot);
        }

        public function setDateValidite($dateValidite){
            $this->date_validite = new DateTime($dateValidite);
        }
}
?>