<?php
class Utilisateur {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function inscrireUtilisateur($prenom, $nom, $email, $mdp, $nuser, $role) {
        try {
            // Hashage du mot de passe
            $hashedPassword = password_hash($mdp, PASSWORD_DEFAULT);

            // Préparation de la requête SQL
            $sql = "INSERT INTO utilisateur (prenom, nom, email, mdp, nuser, role) VALUES (:prenom, :nom, :email, :mdp, :nuser, :role)";
            $stmt = $this->db->prepare($sql);

            // Liaison des paramètres
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':mdp', $hashedPassword);
            $stmt->bindParam(':nuser', $nuser);
            $stmt->bindParam(':role', $role, PDO::PARAM_INT);

            // Exécution de la requête
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            // Gestion des erreurs
            return "Erreur : " . $e->getMessage();
        }
    }
}