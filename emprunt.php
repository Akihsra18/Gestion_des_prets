<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    if (($_SESSION['connection']) == false) {
        header('location:deconnexion.php');
        header('location:connexion.php');
    }
?>

<!DOCTYPE html>
<html lang="fr-ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emprunt</title>
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

        $matricule = $_SESSION['matricule'];
        $position = $_SESSION['position'];
        $id_usager = $_SESSION['id_usager'];
        $id_periodique="";

        $serverName = "localhost";
        $usernameDB = "root";
        $passwordDB = "";
        $dbName = "gestion_des_prets";

        $conn = new mysqli($serverName,$usernameDB,$passwordDB,$dbName);

        if($conn->connect_error) {
            die("Connexion échoué : " . $conn->connect_error);
        }

        if($position == "Etudiant") {

            $sql = "SELECT * FROM emprunts WHERE id_usager='$id_usager'";

            $result = $conn->query($sql);

            if($result->num_rows > 0) {
    ?>

                <div class="row g-0 m-3 justify-content-around">
                    <div class='card col-lg-4 col-md-6 col-8 mx-auto align-self-center m-2 p-1'>
                        <div class="card-header">
                            Périodiques empruntés
                        </div>
                        <ul class='list-group list-group-flush'>

    <?php
                            while($row = $result->fetch_assoc()) {

                                $id_periodique=$row['id_periodique'];
                                $id_emprunt=$row['id_emprunt'];

                                $sqlP = "SELECT * FROM periodiques WHERE id_periodique='$id_periodique'";

                                $resultP = $conn->query($sqlP);

                                if($resultP->num_rows > 0) {
                                    while($row = $resultP->fetch_assoc()) {
                                        echo 
                                            "<li class='list-group-item'>
                                                <h5 class='card-title'>" . $row['nom'] . " - Issue " . $row['numero'] . "</h5>
                                                <p class='card-text'>" . $row['titre'] . "<br>" . $row['mois'] . " " . $row['annee'] . "</p>
                                                <div class='text-end'>
                                                    <a href='supprimerE.php?id_emprunt=" . $id_emprunt . "' class='text-decoration-none'>
                                                        Retourner le périodique<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-return-left' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5'/></svg>
                                                    </a>
                                                </div>
                                            </li>";
                                    }
                                }
                            }

    ?>
                        </ul>       
                    </div>
                </div>

    <?php
            }
            else {
    ?>

                <div class="row g-0 m-3 justify-content-around">
                    <div class='card col-lg-4 col-md-6 col-8 mx-auto align-self-center m-2 p-1'>
                        <div class="card-header">
                            Aucun périodique emprunté
                        </div>
                    </div>
                </div>
                
    <?php
            }
        }
        else if($position == "Professeur") {

            $sql = "SELECT * FROM emprunts";
            
            $result = $conn->query($sql);
    ?>

            <div class="container col-md-11 col-12 m-4 mx-auto">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Matricule</th>
                            <th scope="col">Périodique</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

    <?php
                        if($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $id_emprunt=$row['id_emprunt'];
                                $id_usager=$row['id_usager'];
                                $id_periodique=$row['id_periodique'];

                                $sqlU = "SELECT * FROM usagers WHERE id_usager='$id_usager'";

                                $resultU = $conn->query($sqlU);

                                if($resultU->num_rows > 0) {
                                    while($row = $resultU->fetch_assoc()) {
                                        $matricule=$row['matricule'];

                                        $sqlP = "SELECT * FROM periodiques WHERE id_periodique='$id_periodique'";

                                        $resultP = $conn->query($sqlP);
        
                                        if($resultP->num_rows > 0) {
                                            while($row = $resultP->fetch_assoc()) {
                                                $nomP = $row['nom'];
                                                $numeroP = $row['numero'];

                                                echo 
                                                    "<tr>
                                                        <th scope='row'>" . $id_emprunt . "</th>
                                                        <td>" . $matricule . "</td>
                                                        <td>" . $nomP . " - Issue " . $numeroP . "</td>
                                                        <td>
                                                            <button type='button' class='border border-0' data-bs-toggle='modal' data-bs-target='#confirmationModal" . $id_emprunt . "'>
                                                                <svg xmlns='http://www.w3.org/2000/svg' height='20' width='22.5' viewBox='0 0 576 512'><path d='M290.7 57.4L57.4 290.7c-25 25-25 65.5 0 90.5l80 80c12 12 28.3 18.7 45.3 18.7L288 480l9.4 0L512 480c17.7 0 32-14.3 32-32s-14.3-32-32-32l-124.1 0L518.6 285.3c25-25 25-65.5 0-90.5L381.3 57.4c-25-25-65.5-25-90.5 0zM297.4 416l-9.4 0-105.4 0-80-80L227.3 211.3 364.7 348.7 297.4 416z'/></svg>
                                                            </button>
                                                            <div class='modal fade align-content-center' id='confirmationModal" . $id_emprunt . "' tabindex='-1' aria-labelledby='confirmationModalLabel" . $id_emprunt . "' aria-hidden='true'>
                                                                <div class='modal-dialog'>
                                                                    <div class='modal-content'>
                                                                        <div class='modal-header'>
                                                                            <h5 class='modal-title' id='confirmationModalLabel" . $id_emprunt . "'>
                                                                                Confirmer la suppression
                                                                            </h5>
                                                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                                        </div>
                                                                        <div class='modal-body'>
                                                                            Etes-vous sûr de vouloir supprimer cet emprunt?
                                                                        </div>
                                                                        <div class='modal-footer'>
                                                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Annuler</button>
                                                                            <a href='supprimerE.php?id_emprunt=" . $id_emprunt . "'><button type='button' class='btn btn-danger'>Supprimer</button></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        else {
                            echo 
                                "<tr class='text-center'>
                                    <td colspan='4'>Aucun emprunt</td>
                                </tr>";
                        }
    ?>
                    
                        </tbody>
                    </table>
            
                    <div class="d-flex justify-content-end m-4">
                        <button id="addEmprunt" type="button" value="Ajouter un emprunt" class="btn btn-outline-dark" onclick="document.location.href='ajouterE.php'">
                            Ajouter un emprunt
                        </button>
                    </div>
                </div>

    <?php
        }
        else {
            echo "Aucun résultat";
        }
        $conn->close();
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>