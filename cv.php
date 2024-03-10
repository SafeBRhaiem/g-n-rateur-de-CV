<?php
require('Database.php');

class CV
{
    private $baseDeDonnees;

    public function __construct(BaseDeDonnees $baseDeDonnees)
    {
        $this->baseDeDonnees = $baseDeDonnees;
    }

    public function ajouterCV($donnees)
    {
        $prenom = $donnees['prenom'];
        $nom = $donnees['nom'];
        $dateNaissance = $donnees['date-naissance'];
        $langue = $donnees['langue'];
        $email = $donnees['email'];
        $telephone = $donnees['phone'];
        $titreExperience = $donnees['titre-exp'];
        $entreprise = $donnees['entreprise'];
        $descriptionExperience = $donnees['experience_description'];
        $diplome = $donnees['education_degree'];
        $ecole = $donnees['ecole'];
        $descriptionEducation = $donnees['education_description'];
        $competences = $donnees['skills'];

         $sql = "INSERT INTO cv (prenom, nom, date_naissance, email, phone, langue, titre_exp, entreprise, 
            experience_description, education_degree, ecole, education_description, skills) 
            VALUES ('$prenom', '$nom', '$dateNaissance', '$email', '$telephone', '$langue', '$titreExperience', '$entreprise',
            '$descriptionExperience', '$diplome', '$ecole', '$descriptionEducation', '$competences')";

    $resultat = $this->baseDeDonnees->query($sql);

    if ($resultat) {
        echo "Données ajoutées avec succès à la base de données.";
    } else {
        echo "Erreur d'insertion dans la base de données : " . $this->baseDeDonnees->errorInfo();
    }
}
    

    public function getDernierCV()
{
    $resultat = $this->baseDeDonnees->query("SELECT * FROM cv ORDER BY id DESC LIMIT 1");

    if ($resultat) {
        $ligne = $resultat->fetch(PDO::FETCH_ASSOC);
        return $ligne;
    } else {
        return null;
    }
}

}

$baseDeDonnees = new BaseDeDonnees('localhost', 'root', '', 'bd_cv');
$cv = new CV($baseDeDonnees);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cv->ajouterCV($_POST);
}

$dernierCV = $cv->getDernierCV();
$baseDeDonnees->fermerConnexion();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage du CV</title>
    <style>
        #cv-container {
    font-family: 'Arial', sans-serif;
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
}

#cv-container h1 {
    color: #333;
    text-align: center;
}

ul {
    list-style-type: none;
    padding: 0;
}

li {
    margin-bottom: 10px;
}

strong {
    font-weight: bold;
}

#cv-container ul li {
    border-bottom: 1px solid #ddd;
    padding-bottom: 8px;
}

#cv-container ul li:last-child {
    border-bottom: none;
}

#cv-container ul li strong {
    display: inline-block;
    width: 150px; /* Ajustez la largeur selon votre préférence */
}

#cv-container ul li span {
    color: #555;
}

</style>

 <script>
        var donneesDernierCV = <?php echo json_encode($dernierCV); ?>;
        
        function afficherDernierCV() {
            var conteneurCV = document.getElementById('cv-container');

            if (typeof donneesDernierCV !== 'undefined' && donneesDernierCV !== null) {
                var contenuHTML = "<h1>  CV :</h1>";
                contenuHTML += "<ul>";
                
                contenuHTML += "<li><strong>Prénom:</strong> " + donneesDernierCV['prenom'] + "</li>";
                contenuHTML += "<li><strong>Nom:</strong> " + donneesDernierCV['nom'] + "</li>";
                contenuHTML += "<li><strong>Date de Naissance:</strong> " + donneesDernierCV['date_naissance'] + "</li>";
                contenuHTML += "<li><strong>Email:</strong> " + donneesDernierCV['email'] + "</li>";
                contenuHTML += "<li><strong>Téléphone:</strong> " + donneesDernierCV['phone'] + "</li>";
                contenuHTML += "<li><strong>Langue:</strong> " + donneesDernierCV['langue'] + "</li>";
                contenuHTML += "<li><strong>Titre Expérience:</strong> " + donneesDernierCV['titre_exp'] + "</li>";
                contenuHTML += "<li><strong>Entreprise:</strong> " + donneesDernierCV['entreprise'] + "</li>";
                contenuHTML += "<li><strong>Description Expérience:</strong> " + donneesDernierCV['experience_description'] + "</li>";
                contenuHTML += "<li><strong>Diplôme:</strong> " + donneesDernierCV['education_degree'] + "</li>";
                contenuHTML += "<li><strong>École:</strong> " + donneesDernierCV['ecole'] + "</li>";
                contenuHTML += "<li><strong>Description Éducation:</strong> " + donneesDernierCV['education_description'] + "</li>";
                contenuHTML += "<li><strong>Activités sociale:</strong> " + donneesDernierCV['skills'] + "</li>";

                contenuHTML += "</ul>";
                conteneurCV.innerHTML = contenuHTML;
            } else {
                conteneurCV.innerHTML = "Aucun CV enregistré dans la base de données.";
            }
        }

        window.onload = function() {
            afficherDernierCV();
        };
    </script>
</head>
<body>
    <div id="cv-container">

    </div>
</body>
</html>