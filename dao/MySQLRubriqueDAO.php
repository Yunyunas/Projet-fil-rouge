<?php

    require_once (__DIR__).'/../models/Rubrique.php';
    require_once 'RubriqueDao.php';

    class MySQLRubriqueDAO implements RubriqueDao{

        private $cnx;

        public function __construct($cnx){      // Constructor
            $this->cnx = $cnx;
        } 

        public function __destruct() {      // Destructor
            $this->cnx = null;
        }

        public function getAll()    //Display All from TABLE RUBRIQUE
        {
            try {
                $requete = $this->cnx->prepare("SELECT id_rubrique,libelle_rubrique FROM Rubrique
                                                HAVING libelle_rubrique not in ('Nouveautés')
                                                ORDER BY id_rubrique ASC");

                $requete->execute();
                $requete->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Rubrique');
                $rubrique = $requete->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Rubrique');
                return $rubrique;
                
            } catch (PDOException $e) {
                throw new BDDException($e->getMessage(), $e->getCode());
            }
        }

        public function insert(Rubrique $rub)     //return ID of the last INSERT, -1 for failure
        {
            try {
                $requete = $this->cnx->prepare("INSERT INTO Rubrique(libelle_rubrique) VALUES (:libelle_rubrique)");

                $requete->bindValue(':libelle_rubrique', $rub->getLibelle());
                $requete->execute();
                $rub = $requete->fetchObject("Rubrique");

                return $rub;
                
            } catch (PDOException $e) {
                throw new BDDException($e->getMessage(), $e->getCode());
                return -1;
            }
        }

        public function delete(Rubrique $rub)     //return rowcount, -1 for failure
        {   
            try {
                $requete = $this->cnx->prepare("DELETE FROM Rubrique WHERE id_rubrique = :val");

                $requete->bindValue(':val', $rub->getId());
                $rowcount = $requete->execute();

                return $rowcount;
                
            } catch (PDOException $e) {
                throw new BDDException($e->getMessage(), $e->getCode());
                return -1;
            }
        }

        public function update(Rubrique $rub) //return row count
        {
            try {
                $requete = $this->cnx->prepare("UPDATE Rubrique SET libelle_rubrique = :lib WHERE id_rubrique = :id");
                
                $requete->bindValue(':id', $rub->getId());
                $requete->bindValue(':lib', $rub->getLibelle());
                $rowcount = $requete->execute();
                
                return $rowcount;
                
            } catch (PDOException $e) {
                throw new BDDException($e->getMessage(), $e->getCode());
                return -1;
            }
        }
    }

?>