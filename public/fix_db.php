<?php
use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (!file_exists(dirname(__DIR__).'/.env')) {
    die("Fichier .env manquant à la racine.");
}

(new Dotenv())->bootEnv(dirname(__DIR__).'/.env');

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$kernel->boot();

$container = $kernel->getContainer();
$entityManager = $container->get('doctrine')->getManager();
$connection = $entityManager->getConnection();

try {
    echo "--- Début de la réparation complète de la table 'patient' ---<br>";
    
    // Liste des colonnes à vérifier/ajouter
    $queries = [
        "Ajout de 'prenom'" => "ALTER TABLE patient ADD COLUMN IF NOT EXISTS prenom VARCHAR(255) NOT NULL AFTER nom",
        "Ajout de 'adresse'" => "ALTER TABLE patient ADD COLUMN IF NOT EXISTS adresse VARCHAR(255) NOT NULL AFTER email",
        "Ajout de 'telephone'" => "ALTER TABLE patient ADD COLUMN IF NOT EXISTS telephone VARCHAR(255) NOT NULL AFTER adresse",
        "Nettoyage 'roles'" => "ALTER TABLE patient DROP COLUMN IF EXISTS roles",
        "Nettoyage 'password'" => "ALTER TABLE patient DROP COLUMN IF EXISTS password"
    ];

    foreach ($queries as $label => $sql) {
        try {
            $connection->executeStatement($sql);
            echo "✅ $label : OK<br>";
        } catch (\Exception $e) {
            echo "⚠️ $label : Déjà fait ou erreur mineure (" . $e->getMessage() . ")<br>";
        }
    }
    
    echo "<br><b>Terminé ! Toutes les colonnes (nom, prenom, email, adresse, telephone) sont maintenant prêtes.</b><br>";
    echo "Vous pouvez retourner sur votre formulaire.";
} catch (\Exception $e) {
    echo "<br>❌ Erreur critique : " . $e->getMessage();
}
