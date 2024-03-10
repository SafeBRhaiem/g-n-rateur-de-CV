<?php
require('Database.php');

$bd = new BaseDeDonnees();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $u = isset($_POST['nom']) ? $_POST['nom'] : '';
    $e = isset($_POST['email']) ? $_POST['email'] : '';
    $p = isset($_POST['mot_pass']) ? $_POST['mot_pass'] : '';
    
    $stmt = $bd->connexion->prepare("INSERT INTO inscription(nom, email, mot_pass) VALUES (:nom, :email, :mot_pass)");
    $stmt->bindParam(':nom', $u);
    $stmt->bindParam(':email', $e);
    $stmt->bindParam(':mot_pass', $p);

    if ($stmt->execute()) {
        echo "<div><h3>Vous êtes inscrit avec succès</h3><p>Cliquez ici pour vous <a href='connexion.html'>connecter</a></p></div>";
    } else {
        echo 'Requête non exécutée';
    }

    $stmt->closeCursor();
} else {
    echo "Erreur : Les données ne sont pas correctes.";
}

$bd->fermerConnexion();
?>
