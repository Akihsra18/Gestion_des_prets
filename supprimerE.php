<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    if (($_SESSION['connection']) == false) {
        header('location:deconnexion.php');
        header('location:index.php');
    }
?>

<!DOCTYPE html>
<html lang="fr-ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer emprunt</title>
</head>
<body>
    
    <?php
        $id_emprunt = $_GET['id_emprunt'];

        $serverName = "localhost";
        $usernameDB = "root";
        $passwordDB = "";
        $dbName = "gestion_des_prets";

        $conn = new mysqli($serverName,$usernameDB,$passwordDB,$dbName);

        if($conn->connect_error) {
            die("Connexion échoué : " . $conn->connect_error);
        }

        $sql = "DELETE FROM emprunts WHERE id_emprunt='$id_emprunt'";

        if($conn->query($sql) === TRUE) {
            header('location:emprunt.php');
        }
        else {
            echo "Erreur lors de la suppression de l'enregistrement: " . $conn->error;
        } 
        $conn->close();
    ?>
</body>
</html>