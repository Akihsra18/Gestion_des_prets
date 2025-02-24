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
    <title>Ajouter emprunt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image/png" href="images/Logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <?php
        $position = $_SESSION['position'];

        $serverName = "localhost";
        $usernameDB = "root";
        $passwordDB = "";
        $dbName = "gestion_des_prets";

        $conn = new mysqli($serverName,$usernameDB,$passwordDB,$dbName);

        if($conn->connect_error) {
            die("Connexion échoué : " . $conn->connect_error);
        }

        if($position == "Etudiant") {

            $id_usager = $_SESSION['id_usager'];
            $id_periodique = $_GET['id_periodique'];

            $sql = "INSERT INTO emprunts (id_usager, id_periodique)
            VALUES ('$id_usager', '$id_periodique')";

            if($conn->query($sql) == TRUE) {
                header('location:index.php');
            }
        }
        else if($position == "Professeur") {

            include 'fonction.php';
            include 'variables.php';
            
            echo $navbar;

            $formErrors = false;
            $matricule = $nomP = $numeroP = "";
            $matriculeErr = $nomPErr = $numeroPErr = "";

            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                if(empty($_POST['matricule'])) {
                    $matriculeErr = "Matricule requis";
                    $formErrors = true;
                }
                else {
                    $matricule = test_input($_POST['matricule']);
                }

                if(empty($_POST['nomP'])) {
                    $nomPErr = "Nom du périodique requis";
                    $formErrors = true;
                }
                else {
                    $nomP = test_input($_POST['nomP']);
                }

                if(empty($_POST['numeroP'])) {
                    $numeroPErr = "Numéro du périodique requis";
                    $formErrors = true;
                }
                else {
                    $numeroP = test_input($_POST['numeroP']);
                }
            }
        ?>

        <?php
            if ($_SERVER['REQUEST_METHOD'] != 'POST' || $formErrors == true)
            {
        ?>

                <div class="container-fluid col-lg-6 col-md-8 col-10 mx-auto mt-5 m-2 p-1 text-center border border-5" style="background-color: rgba(200, 200, 200);">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="m-5">
                        Matricule de l'usager : 
                        <input name="matricule" pattern="[0-9]{5,7}" value=<?php echo $matricule; ?>><br><br>
                        <?php 
                            if ($matriculeErr != "") {
                                echo "<p class='text-danger'>" . $matriculeErr . "</p><br>";
                            }
                        ?>
                        Nom du périodique : 
                        <input type="text" name="nomP" value=<?php echo $nomP; ?>><br><br>
                        <?php 
                            if ($nomPErr != "") {
                                echo "<p class='text-danger'>" . $nomPErr . "</p><br>";
                            }
                        ?>
                        Numéro du périodique : 
                        <input type="number" name="numeroP" value=<?php echo $numeroP; ?>><br><br>
                        <?php 
                            if ($numeroPErr != "") {
                                echo "<p class='text-danger'>" . $numeroPErr . "</p><br>";
                            }
                        ?>
                        <br><br>
                        <input type="submit" value="Soumettre" class="btn btn-dark m-3">
                        <button type="button" value="Retourner" class="btn btn-dark m-3" onclick="document.location.href='emprunt.php';">
                            Retourner
                        </button>
                        <br>
                    </form>
                </div>

        <?php
            }
            else if ($_SERVER['REQUEST_METHOD'] == 'POST' || $formErrors == false) {
                $serverName = "localhost";
                $usernameDB = "root";
                $passwordDB = "";
                $dbName = "gestion_des_prets";

                $conn = new mysqli($serverName,$usernameDB,$passwordDB,$dbName);

                if($conn->connect_error) {
                    die("Connexion échoué : " . $conn->connect_error);
                }

                $sqlU = "SELECT * FROM usagers WHERE matricule='$matricule'";

                $resultU = $conn->query($sqlU);

                if($resultU->num_rows > 0) {
                    while($row = $resultU->fetch_assoc()) {
                        $id_usager=$row['id_usager'];

                        $sqlP = "SELECT * FROM periodiques WHERE nom='$nomP' AND numero='$numeroP'";

                        $resultP = $conn->query($sqlP);
        
                        if($resultP->num_rows > 0) {
                            while($row = $resultP->fetch_assoc()) {
                                $id_periodique = $row['id_periodique'];

                                $sqlEP = "SELECT * FROM emprunts WHERE id_periodique='$id_periodique'";
                        
                                $resultEP = $conn->query($sqlEP);

                                if($resultEP->num_rows > 0) {
                                    header('location:emprunt.php');
                                }
                                else {
                                    $sqlEU = "SELECT * FROM emprunts WHERE id_usager='$id_usager'";
                        
                                    $resultEU = $conn->query($sqlEU);
    
                                    if($resultEU->num_rows < 3) {
                                        $sqlEI = "INSERT INTO emprunts (id_usager, id_periodique)
                                        VALUES ('$id_usager', '$id_periodique')";

                                        if($conn->query($sqlEI) == TRUE) {
                                            header('location:emprunt.php');
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                header('location:emprunt.php');
            }
        }
        else {
            echo "Erreur lors de l'ajout de l'enregistrement: " . $conn->error;
        } 
        $conn->close();
        
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<!-- 
    ALTER TABLE `emprunts`
    MODIFY `id_emprunt` int(0) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
-->