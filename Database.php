<?php
class BaseDeDonnees {
    private $serveur = 'localhost';
    private $utilisateur = 'root';
    private $motDePasse = '';
    private $baseDeDonnees = 'bd_cv';
    public $connexion;

    public function __construct() {
        try {
            $this->connexion = new PDO("mysql:host={$this->serveur};dbname={$this->baseDeDonnees}", $this->utilisateur, $this->motDePasse);
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public function fermerConnexion() {
        $this->connexion = null;
    }
     public function query($sql) {
        return $this->connexion->query($sql);
    }
}
?>
