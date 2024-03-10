<?php
require('Database.php');
session_start();

class Authentification {
    private $bd;

    public function __construct(BaseDeDonnees $bd) {
        $this->bd = $bd;
    }

    public function connexion($email, $motDePasse) {
        $requete = "SELECT * FROM inscription WHERE email=:email AND mot_pass=:motDePasse";
        $stmt = $this->bd->connexion->prepare($requete);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':motDePasse', $motDePasse);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            header("Location: GEN-CV.html");
            exit();
        } else {
            echo "Identifiants invalides. Veuillez réessayer.";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $motDePasse = $_POST['mot_pass'];

    $bd = new BaseDeDonnees();
    $auth = new Authentification($bd);
    $auth->connexion($email, $motDePasse);

    $bd->fermerConnexion();
}
?>
