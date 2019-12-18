<?php
    class Utilisateur{
        private $id_utilisateur;
        private $mdp_utilisateur;
        private $nom_utilisateur;
        private $prenom_utilisateur;
        private $mail_utilisateur;
        private $admin;
        
// Construction de données
        public function __construct($mdp = '', $nom = '', $prenom = '', $mail = '', $adm = 0, $id_utilisateur = -1){
            $this->id_utilisateur = $id_utilisateur;
            $this->mdp_utilisateur = $mdp;
            $this->nom_utilisateur = $nom;
            $this->prenom_utilisateur = $prenom;
            $this->mail_utilisateur = $mail;
            $this->admin = $adm;
        }

// Tostring
        public function __tostring(){
            return $this->nom_utilisateur.$this->mail_utilisateur.$this->mdp_utilisateur;
    
        }
        
// Autoriser la lecture d'une donnée 'private'
        public function getId(){
            return $this->id_utilisateur;
        }

        public function getMdp(){
            return $this->mdp_utilisateur;
        }

        public function getNom(){
            return $this->nom_utilisateur;
        }

        public function getPrenom(){
            return $this->prenom_utilisateur;
        }

        public function getMail(){
            return $this->mail_utilisateur;
        }

        public function getAdmin(){
            return $this->admin;
        }

// Modifier une donnée 'private'

        public function setId($id){
            $this->id_utilisateur = $id;
        }

        public function setMdp($mdp){
            $this->mdp_utilisateur = $mdp;
        }

        public function setNom($nom){
            $this->nom_utilisateur = $nom;
        }

        public function setPrenom($prenom){
            $this->prenom_utilisateur = $prenom;
        }
        
        public function setMail($mail){
            $this->mail_utilisateur = $mail;
        }            
    }
?>