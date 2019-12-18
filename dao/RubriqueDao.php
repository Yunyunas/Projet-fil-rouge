<?php
    interface RubriqueDao{
        public function insert(Rubrique $rub);
        public function delete (Rubrique $rub);
        public function update (Rubrique $rub);
        public function getAll();
    }
?>