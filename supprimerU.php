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
    <title>Supprimer usager</title>
</head>
<body>
    
    <?php
        $serverName = "localhost";
        $usernameDB = "root";
        $passwordDB = "";
        $dbName = "gestion_des_prets";

        $id_usager = $_GET['id_usager'];

        $conn = new mysqli($serverName,$usernameDB,$passwordDB,$dbName);

        if($conn->connect_error) {
            die("Connexion échoué : " . $conn->connect_error);
        }

        $sql = "DELETE FROM usagers WHERE id_usager='$id_usager'";

        if($conn->query($sql) === TRUE) {
            header('location:usager.php');
        }
        else {
            echo "Erreur lors de la suppression de l'enregistrement: " . $conn->error;
        } 
        $conn->close();
    ?>
</body>
</html>