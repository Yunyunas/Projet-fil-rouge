<?php

    require_once  (__DIR__).'/../models/Annonce.php';
    require_once  (__DIR__).'/../models/Rubrique.php';
    require_once  (__DIR__).'/../models/Utilisateur.php';
    require_once 'AnnonceDao.php';

    class MySQLAnnonceDAO implements AnnonceDao {

        private $cnx;

        /**
         * 
         *
         */
        public function __construct($cnx){      // Constructor
            $this->cnx = $cnx;
        } 

        //Constructor
        /**
         * 
         */
        public function __destruct() {      // Destructor
            $this->cnx = null;
        }

        public function getByRubrique(Rubrique $rub) // : tableau d'Annonce(s)
        {
            try {
                $requete = $this->cnx->prepare("SELECT * FROM annonce 
                                                INNER JOIN rubrique ON rubrique.id_rubrique = annonce.id_rubrique
                                                INNER JOIN utilisateur ON utilisateur.id_utilisateur = annonce.id_utilisateur
                                                WHERE rubrique.id_rubrique = :id_rubrique");

                $requete->bindValue(':id_rubrique', $rub->getId());
                $requete->setFetchMode(PDO::FETCH_ASSOC);
                $requete->execute();
                $data = $requete->fetchAll();
                $tableau = array();
                
                foreach($data as $j)
                {
                    $u = new Utilisateur($j['mdp_utilisateur'], $j['nom_utilisateur'], $j['prenom_utilisateur'],
                                         $j['mail_utilisateur'], $j['admin'], $j['id_utilisateur']);

                    $rub = new Rubrique($j['libelle_rubrique'], $j['id_rubrique']);

                    $tableau[]=new Annonce($u, $rub, $j['en_tete_annonce'],$j['corps_annonce'], $j['date_depot'], 
                                            $j['date_validite'],$j['id_annonce'] );
                             
                }
                return $tableau;
            }  
             catch (PDOException $e) {
                throw new BDDException($e->getMessage(), $e->getCode());
                return -1;
            }
        } 

        public function getByUtilisateur(Utilisateur $utilisateur)
        {
            try {
                $requete = $this->cnx->prepare("SELECT * FROM Annonce 
                                                INNER JOIN rubrique ON rubrique.id_rubrique = annonce.id_rubrique
                                                INNER JOIN utilisateur ON utilisateur.id_utilisateur = annonce.id_utilisateur
                                                WHERE utilisateur.id_utilisateur = :id_utilisateur");

                $requete->bindValue(':id_utilisateur', $utilisateur->getId());
                $requete->setFetchMode(PDO::FETCH_ASSOC);
                $requete->execute();
                $data = $requete->fetchAll();
                $tableau = array();

                foreach($data as $j){
                $rub = new Rubrique($j['libelle_rubrique'], $j['id_rubrique']);

                $tableau[]=new Annonce($utilisateur, $rub, $j['en_tete_annonce'],$j['corps_annonce'], 
                                    $j['date_depot'], $j['date_validite'],$j['id_annonce'] );         
             }
                return $tableau;
            }  

            catch (PDOException $e) {
                throw new BDDException($e->getMessage(), $e->getCode());
                return -1;
            }
        }

        public function insert(Annonce $annonce) : int // retourne le id d'annonce généré
        {
            try {
                $requete = $this->cnx->prepare("INSERT INTO Annonce(id_rubrique,id_utilisateur,en_tete_annonce,corps_annonce)
                                                VALUES (:id_rubrique, :id_utilisateur, :en_tete_annonce, :corps_annonce)");
                
                $requete->bindValue(':id_rubrique', $annonce->getRubrique()->getId());
                $requete->bindValue(':id_utilisateur', $annonce->getUser()->getId());
                $requete->bindValue(':en_tete_annonce', $annonce->getEnTete());
                $requete->bindValue(':corps_annonce', $annonce->getCorps());

                $requete->execute();
                $annonce = $requete->fetchObject("Annonce");
                return $annonce;
                
            } catch (PDOException $e) {
                throw new BDDException($e->getMessage(), $e->getCode());
                return -1;
            }
        }

        public function delete(Annonce $annonce) : int // retourne le row count, -1 for failure
        {   
            try {
                $requete = $this->cnx->prepare("DELETE FROM ANNONCE WHERE id_annonce = :val");
                $requete->bindValue(':val', $annonce->getId());
                $rowcount = $requete->execute();
                return $rowcount;
                
            } catch (PDOException $e) {
                throw new BDDException($e->getMessage(), $e->getCode());
                return -1;
            }
        }

        public function update(annonce $annonce) : int // retourne le row count
        {
            try {
                $requete = $this->cnx->prepare("UPDATE ANNONCE SET en_tete_annonce = :entete, corps_annonce = :corps 
                                                WHERE id_annonce = :id");

                $requete->bindValue(':id', $annonce->getId());
                $requete->bindValue(':entete', $annonce->getEnTete());
                $requete->bindValue(':corps', $annonce->getCorps());
                $rowcount = $requete->execute();

                return $rowcount;
                
            } catch (PDOException $e) {
                throw new BDDException($e->getMessage(), $e->getCode());
                return -1;
            }
        }

        public function updateRubrique($id, $idRubrique): int // retourne le row count
        {
            try {
                $requete = $this->cnx->prepare("UPDATE ANNONCE SET id_rubrique = :idRubrique 
                                                WHERE id_annonce = :id");
                $requete->bindParam(':id', $id);
                $requete->bindParam(':idRubrique', $idRubrique);
                $rowcount = $requete->execute();

                return $rowcount;
                
            } catch (PDOException $e) {
                throw new BDDException($e->getMessage(), $e->getCode());
                return -1;
            }
        }

        public function deletePerimees() : int// retourne le row count
        {
            try {
                $requete = $this->cnx->prepare("DELETE FROM Annonce WHERE CURDATE() = date_validite");
                $rowcount = $requete->execute();

                return $rowcount;

            } catch (PDOException $e) {
                throw new BDDException($e->getMessage(), $e->getCode());
                return -1;
            }
        }

        public function getAll() // : tableau d'Annonce(s)
        {
            try {
                $requete = $this->cnx->prepare("SELECT * FROM annonce 
                                                INNER JOIN rubrique ON rubrique.id_rubrique = annonce.id_rubrique
                                                INNER JOIN utilisateur ON utilisateur.id_utilisateur = annonce.id_utilisateur
                                                ORDER BY date_depot DESC
                                                LIMIT 8");

                $requete->setFetchMode(PDO::FETCH_ASSOC);
                $requete->execute();
                $data = $requete->fetchAll();
                $tableau = array();
                foreach($data as $j)
                {
                    $u = new Utilisateur($j['mdp_utilisateur'], $j['nom_utilisateur'], $j['prenom_utilisateur'],
                                         $j['mail_utilisateur'], $j['admin'], $j['id_utilisateur']);

                    $rub = new Rubrique($j['libelle_rubrique'], $j['id_rubrique']);

                    $tableau[] = new Annonce($u, $rub, $j['en_tete_annonce'],$j['corps_annonce'], $j['date_depot'],
                                            $j['date_validite'],$j['id_annonce'] );           
                }
                
                return $tableau;
            } catch (PDOException $e) {
                throw new BDDException($e->getMessage(), $e->getCode());
                return -1;
            }
        }

        /**
         * Renvoi une annonce depuis son id
         */
        public function getById(int $id)
        {
            try {

                $requete = $this->cnx->prepare("SELECT * FROM annonce 
                                                LEFT JOIN rubrique ON rubrique.id_rubrique = annonce.id_rubrique
                                                LEFT JOIN utilisateur ON utilisateur.id_utilisateur = annonce.id_utilisateur
                                                WHERE id_annonce=" . $id);

                $requete->setFetchMode(PDO::FETCH_ASSOC);
                $requete->execute();
                $result = $requete->fetchAll();

                return $result[0];

            } catch (PDOException $e) {
                throw new BDDException($e->getMessage(), $e->getCode());
                return -1;
            }
        }
    }
