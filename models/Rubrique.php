<?php
    class Rubrique{
        private $id_rubrique;
        private $libelle_rubrique;

// Construction de données
        public function __construct($libelle_rubrique = '', $id_rubrique = -1){
            $this->id_rubrique = $id_rubrique;
            $this->libelle_rubrique = $libelle_rubrique;
        }

// Tostring
        public function __tostring(){
            return $this->libelle_rubrique;
        }
        
// Autoriser la lecture d'une donnée 'private'
        public function getId(){
            return $this->id_rubrique;
        }
        
        public function getLibelle(){
            return $this->libelle_rubrique;
        }

// Modifier une donnée 'private'

        public function setId($id_rubrique){
            $this->id_rubrique = $id_rubrique;
        }

        public function setLibelle($libelle_rubrique){
            $this->libelle_rubrique = $libelle_rubrique;
        }              
    }
?>