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
    <title>Supprimer périodique</title>
</head>
<body>
    
    <?php
        $serverName = "localhost";
        $usernameDB = "root";
        $passwordDB = "";
        $dbName = "gestion_des_prets";

        $id_periodique = $_GET['id_periodique'];

        $conn = new mysqli($serverName,$usernameDB,$passwordDB,$dbName);

        if($conn->connect_error) {
            die("Connexion échoué : " . $conn->connect_error);
        }

        $sql = "DELETE FROM periodiques WHERE id_periodique='$id_periodique'";

        if($conn->query($sql) === TRUE) {
            header('location:index.php');
        }
        else {
            echo "Erreur lors de la suppression de l'enregistrement: " . $conn->error;
        } 
        $conn->close();
    ?>
</body>
</html>