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
    <title>Modifier périodique</title>
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

        $id_periodique = $_GET['id_periodique'];

        $sql = "SELECT * FROM periodiques WHERE id_periodique='$id_periodique'";

        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $nomP = $row['nom'];
                $titreP = $row['titre'];
                $anneeP = $row['annee'];
                $moisP = $row['mois'];
                $numeroP = $row['numero'];
                $urlP = $row['url'];
            }
        }

        $formErrors = false;
        $nomPErr = $titrePErr = $anneePErr = $moisPErr = $numeroPErr = $urlPErr = "";
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if(empty($_POST['nomP'])) {
                $nomPErr = "Nom de périodique requis";
                $formErrors = true;
            }
            else {
                $nomP = test_input($_POST['nomP']);
            }

            if(empty($_POST['titreP'])) {
                $titrePErr = "Titre requis";
                $formErrors = true;
            }
            else {
                $titreP = test_input($_POST['titreP']);
            }

            if(empty($_POST['anneeP'])) {
                $anneePErr = "Année requis";
                $formErrors = true;
            }
            else {
                $anneeP = test_input($_POST['anneeP']);
            }

            if(empty($_POST['moisP'])) {
                $moisPErr = "Mois requis";
                $formErrors = true;
            }
            else {
                $moisP = test_input($_POST['moisP']);
            }

            if(empty($_POST['numeroP'])) {
                $numeroPErr = "Numéro requis";
                $formErrors = true;
            }
            else {
                $numeroP = test_input($_POST['numeroP']);
            }

            if(empty($_POST['urlP'])) {
                $urlPErr = "URL photo requis";
                $formErrors = true;
            }
            else {
                $urlP = test_input($_POST['urlP']);
            }
        }
    ?>

    <?php
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || $formErrors == true)
        {
    ?>
        
            <div class="container-fluid col-lg-7 col-md-9 col-11 mx-auto mt-5 m-2 p-1 text-center border border-5" style="background-color: rgba(200, 200, 200);">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id_periodique=<?php echo $id_periodique; ?>" method="POST" class="m-5">
                    Nom : 
                    <input type="text" name="nomP" value=<?php echo $nomP; ?>><br><br>
                    <?php 
                        if ($nomPErr != "") {
                            echo "<p class='text-danger'>" . $nomPErr . "</p><br>";
                        }
                    ?>
                    Titre : 
                    <input type="text" name="titreP" value=<?php echo $titreP; ?>><br><br>
                    <?php 
                        if ($titrePErr != "") {
                            echo "<p class='text-danger'>" . $titrePErr . "</p><br>";
                        }
                    ?>
                    Année : 
                    <input name="anneeP" pattern="[0-9]{4}" value=<?php echo $anneeP; ?>><br><br>
                    <?php 
                        if ($anneePErr != "") {
                            echo "<p class='text-danger'>" . $anneePErr . "</p><br>";
                        }
                    ?>
                    Mois : 
                    <input type="text" name="moisP" value=<?php echo $moisP; ?>><br><br>
                    <?php 
                        if ($moisPErr != "") {
                            echo "<p class='text-danger'>" . $moisPErr . "</p><br>";
                        }
                    ?>
                    Numéro : 
                    <input type="number" name="numeroP" value=<?php echo $numeroP; ?>><br><br>
                    <?php 
                        if ($numeroPErr != "") {
                            echo "<p class='text-danger'>" . $numeroPErr . "</p><br>";
                        }
                    ?>
                    URL photo : 
                    <input type="text" name="urlP" value=<?php echo $urlP; ?>><br><br>
                    <?php 
                        if ($urlPErr != "") {
                            echo "<p class='text-danger'>" . $urlPErr . "</p><br>";
                        }
                    ?>
                    <br><br>
                    <input type="submit" value="Soumettre" class="btn btn-dark m-3">
                    <button type="button" value="Retourner" class="btn btn-dark m-3" onclick="document.location.href='index.php';">
                        Retourner
                    </button>
                    <br>
                </form>
            </div>

    <?php
        }
        else if ($_SERVER['REQUEST_METHOD'] == 'POST' || $formErrors == false) {

            $sql = "UPDATE periodiques 
            SET nom='$nomP', titre='$titreP', annee='$anneeP', mois='$moisP', numero='$numeroP', url='$urlP' 
            WHERE id_periodique='$id_periodique'";

            if($conn->query($sql) == TRUE) {
                header('location:index.php');
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