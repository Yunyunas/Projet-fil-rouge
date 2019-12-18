<?php
    interface UtilisateurDao{
        public function insert(Utilisateur $utilisateur);
        public function identifier(Utilisateur $utilisateur); 
    }
?>