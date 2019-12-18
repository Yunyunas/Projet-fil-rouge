<?php
    interface AnnonceDao{
        public function insert(Annonce $annonce);
        public function delete(Annonce $annonce);
        public function update(Annonce $annonce);
        public function getByRubrique(Rubrique $rub);
        public function getByUtilisateur(Utilisateur $utilisateur);
        public function deletePerimees();
    }
?>