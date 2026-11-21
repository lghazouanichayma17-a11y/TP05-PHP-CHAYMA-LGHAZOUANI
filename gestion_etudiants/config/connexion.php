<?php
require_once __DIR__ . '/config.php';

/**
 * Retourne un objet PDO connecté à la base de données.
 * La connexion est créée une seule fois (variable statique).
 *
 * >>> À COMPLÉTER (Partie 2) <<<
 */
function getConnexion(): PDO
{
    static $pdo = null;

    if ($pdo === null) {

        // TODO 2.1 : construire le DSN à partir des constantes de config.php
        //   format : mysql:host=...;port=...;dbname=...;charset=...
        $dsn = '';

        // TODO 2.2 : définir le tableau d'options PDO :
        //   - mode d'erreur        : PDO::ERRMODE_EXCEPTION
        //   - mode de fetch défaut : PDO::FETCH_ASSOC
        //   - PDO::ATTR_EMULATE_PREPARES => false
        $options = [
            // ...
        ];

        // TODO 2.3 : créer l'objet PDO dans un bloc try / catch (PDOException $e)
        //   En cas d'erreur : afficher $e->getMessage() puis arrêter le script (die)


    
        $host = 'localhost';
        $dbname = 'gestion_etudiants';
        $username = 'root';
        $password = '';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
         }
    

    }

    return $pdo;
}

/** Raccourci pour échapper une valeur avant de l'afficher dans le HTML (protection XSS) — FOURNI */
function e(?string $valeur): string
{
    return htmlspecialchars($valeur ?? '', ENT_QUOTES, 'UTF-8');
}
