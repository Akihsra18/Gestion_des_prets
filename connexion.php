<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="fr-ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image/png" href="images/Logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <?php
        $_SESSION["connection"] = false;

        if ($_SERVER['REQUEST_METHOD'] != 'POST')
        {
    ?>

    <div id="background" class="container-fluid h-100 d-flex align-items-center">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div id="box" class="col-12 col-md-8 col-lg-6 col-xl-5 p-5">
                    <h2 class="fw-bold mb-5 text-uppercase text-center">Se connecter</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                        <div id="signInBtns" class="d-grid mx-auto text-center col-md-6 col-9 mb-4 rounded-pill text-light">
                            <div class="btn-group" role="group" aria-label="position">
                                <input id="Etudiant" value="Etudiant" type="radio" class="btn-check" name="position" autocomplete="off" checked>
                                <label class="btn rounded-pill" style="color: #DFCCE4;" for="Etudiant">Étudiant</label>
                                <input id="Professeur" value="Professeur" type="radio" class="btn-check" name="position" autocomplete="off">
                                <label class="btn rounded-pill" style="color: #DFCCE4;" for="Professeur">Professeur</label>
                            </div>
                        </div>
                        <label class="form-label" for="matricule">No. de matricule</label>
                        <input id="matricule" type="number" name="matricule" class="form-control form-control-lg mb-3">
                        <label class="form-label" for="mot_de_passe">Mot de passe</label>
                        <input id="mot_de_passe" type="password" name="mot_de_passe" class="form-control form-control-lg">
                        <div class="text-center m-4">
                            <input id="button" type="submit" value="Connexion" class="btn btn-outline-light btn-lg col-6 text-center">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
        }
        else if($_SERVER["REQUEST_METHOD"] == "POST") {
            $matricule = $_POST['matricule'];
            $mot_de_passe = $_POST['mot_de_passe'];
            $position = $_POST['position'];

            $mot_de_passe = sha1($mot_de_passe, false);

            $serverName = "localhost";
            $usernameDB = "root";
            $passwordDB = "";
            $dbName = "gestion_des_prets";

            $conn = new mysqli($serverName,$usernameDB,$passwordDB,$dbName);

            if($conn->connect_error) {
                die("Connexion échoué : " . $conn->connect_error);
            }

            $sql = "SELECT * FROM usagers 
                WHERE matricule = '$matricule' 
                AND mot_de_passe = '$mot_de_passe'
                AND position = '$position'";

            $result = $conn->query($sql);

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $_SESSION['matricule'] = $matricule;
                    $_SESSION['mot_de_passe'] = $mot_de_passe;
                    $_SESSION['position'] = $position;
                    $_SESSION['id_usager'] = $row['id_usager'];
                    $_SESSION['connection'] = true;
                    header('location:index.php');
                }
            }
            else {
                header('location:deconnexion.php');
                header('location:connexion.php');
            }
            $conn->close();
        }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>