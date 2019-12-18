<?php

session_start();

require_once 'dao/ConnexionBdd.php';
require_once 'dao/BDDException.php';

require_once 'dao/MySQLRubriqueDAO.php';
require_once 'models/Rubrique.php';

require_once 'dao/MySQLUtilisateurDAO.php';
require_once 'models/Utilisateur.php';

require_once 'dao/MySQLAnnonceDAO.php';
require_once 'models/Annonce.php';

use Twig\Environment;

require 'vendor/autoload.php';

$action = 'accueil';
if(!isset($_POST['action']) && !isset($_GET['action'])) {
    $action ='accueil';
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];
}
else if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
    
//Rendu du template

$loader = new Twig\Loader\FilesystemLoader('views');
$twig = new Environment($loader, [
    'cache' => false, //.DIR.'/tmp',
]);


// DEBUT DU SWITCH
switch ($action) {

    case 'accueil':
     echo $twig->render('accueil.html.twig', [
        'annonce'=>AfficherToutesLesAnnonces(),
        'rubrique'=>afficherRubriques(),
         'session'=> $_SESSION
         ]);
    break;

// ----------------------------------------- AFFICHER RUBRIQUES --------------------------------------------------------------------  

    // Afficher la liste des rubriques
    case 'afficherRubriques':
        afficherRubriques();
        echo $twig->render('afficherRubriques.html.twig', [
            'rubrique'=>afficherRubriques(),
            'session'=> $_SESSION
            ]);
    break;

// ---------------------------------------- AJOUTER UNE RUBRIQUE ---------------------------------------------------------------------  

    // Afficher formulaire pour ajouter une rubrique
    case 'formAjouterRubrique':
        echo $twig->render('formAjouterRubrique.html.twig', [
            'rubrique'=>afficherRubriques(),
            'session'=> $_SESSION
            ]);
    break;

    // Ajouter une rubrique
    case 'ajouterRubrique':
        ajouterRubrique();
        afficherRubriques();
        echo $twig->render('afficherRubriques.html.twig', [
            'rubrique'=>afficherRubriques(),
            'session'=> $_SESSION
            ]);
    break;

// ---------------------------------------- MODIFIER UNE RUBRIQUE ---------------------------------------------------------------------  

    // Afficher formulaire pour modifier une rubrique
    case 'formModifierRubrique':
        echo $twig->render('formModifierRubrique.html.twig', [
            'rubrique'=>afficherRubriques(),
            'libelle'=> $_GET['paramLibelle'],
            'session'=> $_SESSION
        ]);
    break;

    // Modifier une rubrique
    case 'modifierRubrique':
        modifierRubrique();
        afficherRubriques();
        echo $twig->render('afficherRubriques.html.twig', [
            'param'=> $_GET['param'],
            'paramLibelle'=> $_GET['paramLibelle'],
            'rubrique'=>afficherRubriques(),
            'session'=> $_SESSION
            ]);
    break;


// ---------------------------------------- SUPPRIMER UNE RUBRIQUE ---------------------------------------------------------------------  

    // Supprimer une rubrique
    case 'supprimerRubrique':
        supprimerRubrique();
        afficherRubriques();
            echo $twig->render('afficherRubriques.html.twig', [
                'rubrique'=>afficherRubriques(),
                'session'=> $_SESSION
                ]);
    break;


// ---------------------------------------- AFFICHER UNE ANNONCE ---------------------------------------------------------------------  

    // Afficher les annonces par rubrique
    case 'afficherAnnonces':
        afficherAnnonces();
        echo $twig->render('afficherAnnonces.html.twig', [
            'rubrique'=>afficherRubriques(),
            'annonce'=>afficherAnnonces(),
            'param'=> $_GET['param'],
            'paramLibelle'=> $_GET['paramLibelle'],
            'session'=> $_SESSION
            ]);
    break;

    // Afficher UNE annonce (Zoom sur une annonce)
    case 'afficherUneAnnonce':
        $annonce = AfficherUneAnnonce($_GET['paramIdAnnonce']);
        echo $twig->render('afficherUneAnnonce.html.twig', [
            'annonce'=> $annonce,
            'rubrique' => afficherRubriques(),
            'session'=> $_SESSION
            ]);
    break;

    // Afficher les annonces - NOUVEAUTES
    case 'afficherAnnoncesNouveautes':
        echo $twig->render('afficherAnnoncesNouveautes.html.twig', [
            'param'=> $_GET['param'],
            'paramLibelle'=> $_GET['paramLibelle'],
           'annonce'=>AfficherToutesLesAnnonces(),
           'rubrique'=>afficherRubriques(),
            'session'=> $_SESSION
            ]);
       break;


// ---------------------------------------- AJOUTER UNE ANNONCE ---------------------------------------------------------------------
    
    // Afficher le formulaire pour ajouter une annonce
    case 'formAjouterAnnonce':
        echo $twig->render('formAjouterAnnonce.html.twig' , [
            'rubrique'=>afficherRubriques(),
            'session'=> $_SESSION]);
    break;

    // Ajouter une annonce
    case 'ajouterAnnonce':
        ajouterAnnonce();
        afficherAnnoncesParUtilisateur();
        echo $twig->render('compteUtilisateur.html.twig', [
            'rubrique'=>afficherRubriques(),
            'annonce'=>afficherAnnoncesParUtilisateur(),
            'session'=> $_SESSION
            ]);
    break;

// ---------------------------------------- MODIFIER UNE ANNONCE ---------------------------------------------------------------------
    
    // Afficher le formulaire pour ajouter une annonce
    case 'formModifierAnnonce':

        
        $annonce = AfficherUneAnnonce($_GET['param']);

        echo $twig->render('formModifierAnnonce.html.twig' , [
            'rubrique'=>afficherRubriques(),
            'annonce' => $annonce,
            'entete'=> $_GET['entete'],
            'session'=> $_SESSION]);
    break;

    // Ajouter une annonce
    case 'modifierAnnonce':
        modifierAnnonce();
        // afficherAnnoncesParUtilisateur();
        echo $twig->render('compteUtilisateur.html.twig', [
            'entete'=> $_GET['entete'],
            'rubrique'=>afficherRubriques(),
            'annonce'=>afficherAnnoncesParUtilisateur(),
            'session'=> $_SESSION
            ]);
    break;

    // ---------------------------------------- SUPPRIMER UNE ANNONCE ---------------------------------------------------------------------  

    // Supprimer une rubrique
    case 'supprimerAnnonce':
        supprimerAnnonce();
        afficherAnnoncesParUtilisateur();
        echo $twig->render('compteUtilisateur.html.twig', [
            'rubrique'=>afficherRubriques(),
            'annonce'=>afficherAnnoncesParUtilisateur(),
            'session'=> $_SESSION
            ]);
    break;


// ------------------------------------------- INSCRIPTION ------------------------------------------------------------------  

    // Inscription
    case 'inscription':
        echo $twig->render('inscription.html.twig', [
            'rubrique'=>afficherRubriques(),
            'session'=> $_SESSION
            ]);
    break;

    case 'ajouterUtilisateur':
        ajouterUtilisateur();
        echo $twig->render('connexion.html.twig', [
            'rubrique'=>afficherRubriques(),
            'session'=> $_SESSION
            ]);
    break;

// ------------------------------------------ CONNEXION -------------------------------------------------------------------  

    // Affichage de la page "se connecter"
    case 'connexion':
        echo $twig->render('connexion.html.twig', [
            'message' => '',
            'rubrique'=>afficherRubriques(),
            'session'=> $_SESSION
            ]);
    break;

    // Connexion
    case 'identifierUtilisateur':
        $user = identifierUtilisateur();

        if ($user) { // si $user n'est pas false

            setSession($user->getMail());
            afficherAnnoncesParUtilisateur();
        
            echo $twig->render('compteUtilisateur.html.twig', [
                'rubrique'=>afficherRubriques(),
                'annonce'=>afficherAnnoncesParUtilisateur(),
                'session'=> $_SESSION
                ]);

        } else {

            echo $twig->render('connexion.html.twig', [
                'message' => 'Adresse mail ou mot de passe incorrect',
                'rubrique'=>afficherRubriques(),
                'session'=> $_SESSION
                ]);
        }

    break;

// ---------------------------- COMPTE UTILISATEUR + AFFICHER ANNONCES PAR UTILISATEUR ---------------------------------------------------

    // Si connexion "réussie" = affichage du compte de l'utilisateur
    case 'compteUtilisateur':
        afficherAnnoncesParUtilisateur();
        echo $twig->render('compteUtilisateur.html.twig', [
            'rubrique'=>afficherRubriques(),
            'annonce'=>afficherAnnoncesParUtilisateur(),
            'session'=> $_SESSION
            ]);

    break;

// ------------------------------------------- DECONNEXION ------------------------------------------------------------------

    // Deconnexion
    case 'deconnexion':
        deconnexion();
        echo $twig->render('accueil.html.twig', [
            'annonce'=>AfficherToutesLesAnnonces(),
            'rubrique'=>afficherRubriques(),
            'session'=> $_SESSION
            ]);
    break;

// ----------------------------------------------------------------------------------------------------------------------

    default:
        header('HTTP/1.0 404 Not Found');
        echo $twig->render('404.twig');

    break;
    }

// ------------------------------------------- FONCTIONS ------------------------------------------------------------------

// INSCRIPTION - AJOUTER UN UTILISATEUR 
function ajouterUtilisateur() {
    $cnx = ConnexionBdd::getConnexion();
    $userDAO = new MySQLUtilisateurDAO($cnx);

    $user = new Utilisateur();
    $user->setMdp($_POST['mdp_utilisateur']);
    $user->setNom($_POST['nom_utilisateur']);
    $user->setPrenom($_POST['prenom_utilisateur']);
    $user->setMail($_POST['mail_utilisateur']);

    try {
        $userDAO->insert($user);
    }
    catch (BDDException $e) {
        echo 'erreur !';
    }
}


// CONNEXION - IDENTIFIER UN UTILISATEUR
function identifierUtilisateur() {

    $cnx = ConnexionBdd::getConnexion();
    $userDAO = new MySQLUtilisateurDAO($cnx);

    if (!empty($_POST['mail_utilisateur']) && !empty($_POST['mdp_utilisateur'])) { 
        
        $user = new Utilisateur();
        $user->setMdp($_POST['mdp_utilisateur']);
        $user->setMail($_POST['mail_utilisateur']); 
    }

    try {

        $result = $userDAO->identifier($user);

        if ($result) { // same que === true
            return $user;
        } else {
            return false;
        }
        // $userDAO->setSession($user);

    } catch (BDDException $e) {
        echo 'erreur !';
    }          
}


// INTEGRER DONNEES UTILISATEUR DANS LA SESSION
function setSession() {
    $cnx = ConnexionBdd::getConnexion();
    $userDAO = new MySQLUtilisateurDAO($cnx);

    $user = new Utilisateur();
    $user->setMail($_POST['mail_utilisateur']);

    $userSession = $userDAO->sessionUtilisateur($user);

    // insertion des données utilisateur dans la session
    $_SESSION['utilisateur'] = [
    'id_utilisateur' => $userSession->getId(),
    'prenom_utilisateur' => $userSession->getPrenom(),
    'nom_utilisateur' => $userSession->getNom(),
    'mail_utilisateur' => $userSession->getMail(),
    'admin' => $userSession->getAdmin()
    ];
}


// DECONNEXION
function deconnexion() {
    session_unset();
}


// ----------------------------------------------- RUBRIQUES --------------------------------------------------------------  


// AFFICHER / LISTER LES RUBRIQUES
function afficherRubriques() {
    $cnx = ConnexionBdd::getConnexion();
    $rubDAO = new MySQLRubriqueDAO($cnx);
    $rubs = $rubDAO->getAll();

    return $rubs;
}


// AJOUTER UNE RUBRIQUE
function ajouterRubrique() {
    $cnx = ConnexionBdd::getConnexion();
    $rubDAO = new MySQLRubriqueDAO($cnx);

    $rub = new Rubrique();
    $rub->setLibelle($_POST['libelle_rubrique']);

    try {
        $rubDAO->insert($rub);
    }
    catch (BDDException $e) {
        echo 'erreur !';
    }
}


// MODIFIER UNE RUBRIQUE
function modifierRubrique() {
    $cnx = ConnexionBdd::getConnexion();
    $rubDAO = new MySQLRubriqueDAO($cnx);

    $rub = new Rubrique();
    $rub->setId($_GET['param']);
    $rub->setLibelle($_POST['libelle_rubrique']);
    
    try {
        $rubDAO->update($rub);
    }
    catch (BDDException $e) {
        echo 'erreur !';
    }
}


// SUPPRIMER UNE RUBRIQUE
function supprimerRubrique() {
    $cnx = ConnexionBdd::getConnexion();
    $rubDAO = new MySQLRubriqueDAO($cnx);

    $rub = new Rubrique();
    $rub->setId($_GET['param']);

    try {
        $rubDAO->delete($rub);
    }
    catch (BDDException $e) {
        echo 'erreur !';
    }
}

// ----------------------------------------------- ANNONCES --------------------------------------------------------------


// AFFICHER LES ANNONCES PAR RUBRIQUE
function afficherAnnonces() {
    $cnx = ConnexionBdd::getConnexion();
    $annonceDAO = new MySQLAnnonceDAO($cnx);

    $rub = new Rubrique();
    $rub->setId($_GET['param']);

    $annonces = $annonceDAO->getByRubrique($rub);

    return $annonces;
}


// AFFICHER LES ANNONCES PAR UTILISATEUR (COMPTE UTILISATEUR)
function afficherAnnoncesParUtilisateur() {
    $cnx = ConnexionBdd::getConnexion();
    $annonceDAO = new MySQLAnnonceDAO($cnx);

    $user = new Utilisateur();
    $user->setId($_SESSION['utilisateur']['id_utilisateur']);

    $annonces = $annonceDAO->getByUtilisateur($user);

    return $annonces;
}


// AFFICHER LES DERNIERES ANNONCES
function AfficherToutesLesAnnonces(){
    $cnx = ConnexionBdd::getConnexion();
    $annonceDAO = new MySQLAnnonceDAO($cnx);
    $annonce = $annonceDAO->getAll();
    return $annonce;
}

// AFFICHER UNE ANNONCE (ZOOM SUR UNE ANNONCE)
function AfficherUneAnnonce(int $id) {

    $cnx = ConnexionBdd::getConnexion();
    $annonceDAO = new MySQLAnnonceDAO($cnx);

    return $annonceDAO->getById($id);
}

// AJOUTER UNE ANNONCE
function ajouterAnnonce() {
    $cnx = ConnexionBdd::getConnexion();
    $annonceDAO = new MySQLAnnonceDAO($cnx);

    $rub = new Rubrique();
    // // $rub->setLibelle($_POST['rubrique']);
    $rub->setId($_POST['rubrique']);

    // //  var_dump($_POST);
    // // var_dump($rub);
    // // die('stop');

    $user = new Utilisateur();
    $user->setId($_SESSION['utilisateur']['id_utilisateur']);

    // echo ($_SESSION['utilisateur']['id_utilisateur']);
    // die('stop');

    $annonce = new Annonce();
    $annonce->setUser($user);
    $annonce->setRub($rub);
    $annonce->setEnTete($_POST["en_tete_annonce"]);
    $annonce->setCorps($_POST["corps_annonce"]);

    // echo ($annonce);
    // var_dump($annonce);
    // die('stop');

    try {
        $annonceDAO->insert($annonce);
    }
    catch (BDDException $e) {
        echo 'erreur !';
    }
}


// MODIFIER UNE ANNONCE
function modifierAnnonce() {
    $cnx = ConnexionBdd::getConnexion();
    $annonceDAO = new MySQLAnnonceDAO($cnx);

    $rub = new Rubrique();
    $rub->setId($_POST['rubrique']);
    // $rub->setLibelle($_POST['libelle_rubrique']);

    $user = new Utilisateur();
    $user->setId($_SESSION['utilisateur']['id_utilisateur']);

    $annonce = new Annonce();
    $annonce->setIdAnnonce($_GET['param']);
    $annonce->setUser($user);
    $annonce->setRub($rub);
    $annonce->setEnTete($_POST["en_tete_annonce"]);
    $annonce->setCorps($_POST["corps_annonce"]);

try {
    $annonceDAO->update($annonce);
}
catch (BDDException $e) {
    echo 'erreur !';
}
}


// SUPPRIMER UNE ANNONCE
function supprimerAnnonce() {
    $cnx = ConnexionBdd::getConnexion();
    $annonceDAO = new MySQLAnnonceDAO($cnx);
    $annonce = new Annonce();
    $annonce->setIdAnnonce($_GET['param']);

    try {
        $annonceDAO->delete($annonce);
    }
    catch (BDDException $e) {
        echo 'erreur !';
    }
}