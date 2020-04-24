<?php

require_once ('Model.php');

class Controller {

    public static function recup_adherent(){
       $tab = Model::select();
       echo json_encode($tab);
    }

    public static function recup_emprunt(){
        $tab = Model::select_emprunt();
        echo json_encode($tab);
    }

    public static function recup_livre(){
        $tab = Model::select_livre();
        echo json_encode($tab);
    }

    public static function ajout_adherent(){
        $nom = $_GET["nom"];
        Model::insert_adherent($nom);
        $tab1 = Model::select();
        echo json_encode($tab1);
    }

    public static function ajout_livre(){
        $livre = $_GET["livre"];
        Model::insert_livre($livre);
        $tab1 = Model::select();
        echo json_encode($tab1);
    }

    public static function info_adherent(){
        $idadherent = $_GET["idAdherent"];
        $tab = Model::info_click_adherent($idadherent);
        echo json_encode($tab);
    }
}

?>