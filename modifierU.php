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
    <title>Modifier usager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image/png" href="images/Logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <?php
        include 'fonction.php';
        include 'variables.php';

        echo $navbar;

        $serverName = "localhost";
        $usernameDB = "root";
        $passwordDB = "";
        $dbName = "gestion_des_prets";

        $conn = new mysqli($serverName,$usernameDB,$passwordDB,$dbName);

        if($conn->connect_error) {
            die("Connexion échoué : " . $conn->connect_error);
        }

        $id_usager = $_GET['id_usager'];

        $sql = "SELECT * FROM usagers WHERE id_usager='$id_usager'";

        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $matricule = $row['matricule'];
                $mot_de_passe = $row['mot_de_passe'];
                $position = $row['position'];
            }
        }

        $formErrors = false;
        $mot_de_passe = "";
        $matriculeErr = $mot_de_passeErr = "";
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if(empty($_POST['matricule'])) {
                $matriculeErr = "Numéro de matricule requis";
                $formErrors = true;
            }
            else {
                $matricule = test_input($_POST['matricule']);
            }

            if(empty($_POST['mot_de_passe'])) {
                $mot_de_passeErr = "Mot de passe requis";
                $formErrors = true;
            }
            else {
                $mot_de_passe = test_input($_POST['mot_de_passe']);
            }
        }
    ?>

    <?php
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || $formErrors == true)
        {
    ?>
        
            <div class="container-fluid col-lg-7 col-md-9 col-11 mx-auto mt-5 m-2 p-1 text-center border border-5" style="background-color: rgba(200, 200, 200);">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id_usager=<?php echo $id_usager; ?>" method="POST" class="m-5">
                    Matricule : 
                    <input name="matricule" pattern="[0-9]{5,7}" value="<?php echo $matricule; ?>"><br><br>
                    <?php 
                        if ($matriculeErr != "") {
                            echo "<p class='text-danger'>" . $matriculeErr . "</p><br>";
                        }
                    ?>
                    Mot de passe : 
                    <input type="password" name="mot_de_passe"><br><br>
                    <?php 
                        if ($mot_de_passeErr != "") {
                            echo "<p class='text-danger'>" . $mot_de_passeErr . "</p><br>";
                        }
                    ?>
                    Position : 
                    <?php 
                        if($position == 'Etudiant') {
                    ?>
                        <select name="position">
                            <option value="Etudiant" selected>Etudiant</option>
                            <option value="Professeur">Professeur</option>
                        </select><br><br>
                    <?php
                        }
                        else if($position == 'Professeur') {
                    ?>
                        <select name="position">
                            <option value="Etudiant">Etudiant</option>
                            <option value="Professeur" selected>Professeur</option>
                        </select><br><br>
                    <?php
                        }
                    ?>
                    <input type="submit" value="Sauvegarder" class="btn btn-success m-3">
                    <button type="button" value="Supprimer" class="btn btn-danger m-3" onclick="document.location.href='supprimerU.php?id_usager=<?php echo $id_usager?>';">
                        Supprimer
                    </button>
                    <button type="button" value="Retourner" class="btn btn-dark m-3" onclick="document.location.href='usager.php';">
                        Retourner
                    </button>
                    <br>
                </form>
            </div>

    <?php
        }
        else if ($_SERVER['REQUEST_METHOD'] == 'POST' || $formErrors == false) {
            $mot_de_passe = sha1($mot_de_passe, false);
            $position = $_POST['position'];

            $sql = "UPDATE usagers 
            SET matricule='$matricule', mot_de_passe='$mot_de_passe', adresse_courriel='$matricule@cegeptr.qc.ca', position='$position' 
            WHERE id_usager='$id_usager'";

            if($conn->query($sql) == TRUE) {
                header('location:usager.php');
            }
            else {
                echo "Erreur lors de la mise à jour de l'enregistrement: " . $conn->error;
            }
        }
        $conn->close();
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>