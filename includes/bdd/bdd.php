 <?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "discussion" ;
// test pour voir si MAJ hors GIT 2ème essai
try {
    $conn = new PDO("mysql:host=".$servername.";dbname=".$db, $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo "Connexion à la base de données échouée : " . $e->getMessage();
    }
?> 