<?php

require_once ('Conf.php');

class Model {

    public static $pdo;

    public static function init_pdo() {
        $host   = Conf::getHostname();
        $dbname = Conf::getDatabase();
        $login  = Conf::getLogin();
        $pass   = Conf::getPassword();
        try {
            // connexion à la base de données
            // le dernier argument sert à ce que toutes les chaines de charactères
            // en entrée et sortie de MySql soit dans le codage UTF-8
            self::$pdo = new PDO("mysql:host=$host;dbname=$dbname;", $login, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            // on active le mode d'affichage des erreurs, et le lancement d'exception en cas d'erreur
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            die("Problème lors de la connexion à la base de données.");
        }
    }

     public static function select() {
            try {
                // préparation de la requête
                $sql = Model::$pdo->query("SELECT a.idAdherent,a.nomAdherent, COUNT(e.idAdherent) AS nbEmprunt FROM adherent a LEFT OUTER JOIN emprunt e ON a.idAdherent = e.idAdherent GROUP BY a.idAdherent ");
                $sql->setFetchMode(PDO::FETCH_OBJ);
                $tabResults = $sql->fetchAll();
                return $tabResults;
            } catch (PDOException $e) {
                echo $e->getMessage();
                die("Erreur lors de la recherche dans la base de données.");
            }
        }


      public static function select_emprunt() {
          try {
                   $sql = Model::$pdo->query("SELECT * FROM livre l JOIN emprunt e ON l.idLivre = e.idLivre");
                   $sql->setFetchMode(PDO::FETCH_OBJ);
                   $tabResults = $sql->fetchAll();
                   return $tabResults;
               } catch (PDOException $e) {
                    echo $e->getMessage();
                    die("Erreur lors de la recherche dans la base de données.");
                 }
      }


      public static function select_livre() {
                try {
                         $sql = Model::$pdo->query("SELECT * FROM livre l WHERE l.idLivre NOT IN (SELECT e.idLivre FROM emprunt e)");
                         $sql->setFetchMode(PDO::FETCH_OBJ);
                         $tabResults = $sql->fetchAll();
                         return $tabResults;
                     } catch (PDOException $e) {
                          echo $e->getMessage();
                          die("Erreur lors de la recherche dans la base de données.");
                       }
            }

     public static function insert_adherent($nom) {
             try {
                      $sql = "INSERT INTO adherent(nomAdherent) VALUES (:nomtag)";
                      $req_prep = self::$pdo->prepare($sql);
                      $values = array("nomtag" => $nom);
                      $req_prep->execute($values);
                      return $req_prep;
                  } catch (PDOException $e) {
                         echo $e->getMessage();
                         die("Erreur lors de la recherche dans la base de données.");
                  }
     }

     public static function insert_livre($nom) {
                  try {
                       $sql = "INSERT INTO livre(titreLivre) VALUES (:nomtag)";
                       $req_prep = self ::$pdo->prepare($sql);
                       $values = array ("nomtag" => $nom);
                       $req_prep->execute($values);

                       return $req_prep;
                       } catch (PDOException $e) {
                             echo $e->getMessage();
                             die("Erreur lors de la recherche dans la base de données.");
                       }
          }

     public static function info_click_adherent($id){
         try {
              $sql = "SELECT a.nomAdherent,l.titreLivre FROM adherent a JOIN emprunt e ON a.idAdherent = e.idAdherent JOIN livre l ON e.idLivre = l.idLivre WHERE a.idAdherent =:nomtag";
              $req_prep = self::$pdo->prepare($sql);
              $values = array("nomtag" => $id);
              $req_prep->execute($values);
              $tab = $req_prep->fetchAll();
              return $tab;
         } catch (PDOException $e) {
               echo $e->getMessage();
               die("Erreur lors de la recherche dans la base de données.");
         }
     }

}

// on initialise la connexion $pdo
Model::init_pdo();

?>
