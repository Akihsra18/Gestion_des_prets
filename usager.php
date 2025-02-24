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
    <title>Usager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image/png" href="images/Logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    
    <?php
        include 'variables.php';

        echo $navbar;

        $matricule = $_SESSION['matricule'];
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

            $sql = "SELECT * FROM usagers WHERE matricule = '$matricule'";

            $result = $conn->query($sql);

            if($result->num_rows > 0) {
    ?>

                <div class="row g-0 h-50 d-flex">

    <?php
                    while($row = $result->fetch_assoc())
                        echo 
                            "<div class='card col-lg-4 col-md-6 col-8 mx-auto align-self-center m-2 p-1'>
                                <div class='card-body'>
                                    <h5 class='card-title'>Matricule: " . $row['matricule'] . "</h5>
                                    <p class='card-text'>Adresse courriel: " . $row['adresse_courriel'] . "</p>
                                    <p class='card-text'>Position: " . $row['position'] . "</p>
                                </div>
                            </div>";
    ?>

                </div>
        
    <?php
            }
        }
        else if($position == "Professeur") {

            $sql = "SELECT * FROM usagers";
            
            $result = $conn->query($sql);

            if($result->num_rows > 0) {
    ?>
    
                <div class="container col-md-11 col-12 mt-4 mx-auto">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Matricule</th>
                                <th scope="col">Adresse courriel</th>
                                <th scope="col">Position</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
            
    <?php
                            while($row = $result->fetch_assoc())
                                echo 
                                    "<tr>
                                        <th scope='row'>" . $row['id_usager'] . "</th>
                                        <td>" . $row['matricule'] . "</td>
                                        <td>" . $row['adresse_courriel'] . "</td>
                                        <td>" . $row['position'] . "</td>
                                        <td>
                                            <a href='modifierU.php?id_usager=" . $row['id_usager'] . "'>
                                                <svg height='20' width='20' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><path d='M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z'/></svg>
                                            </a>
                                        </td>
                                        <td>
                                            <button type='button' class='border border-0' data-bs-toggle='modal' data-bs-target='#confirmationModal" . $row['id_usager'] . "'>
                                                <svg xmlns='http://www.w3.org/2000/svg' height='20' width='22.5' viewBox='0 0 576 512'><path d='M290.7 57.4L57.4 290.7c-25 25-25 65.5 0 90.5l80 80c12 12 28.3 18.7 45.3 18.7L288 480l9.4 0L512 480c17.7 0 32-14.3 32-32s-14.3-32-32-32l-124.1 0L518.6 285.3c25-25 25-65.5 0-90.5L381.3 57.4c-25-25-65.5-25-90.5 0zM297.4 416l-9.4 0-105.4 0-80-80L227.3 211.3 364.7 348.7 297.4 416z'/></svg>
                                            </button>
                                            <div class='modal fade align-content-center' id='confirmationModal" . $row['id_usager'] . "' tabindex='-1' aria-labelledby='confirmationModalLabel" . $row['id_usager'] . "' aria-hidden='true'>
                                                <div class='modal-dialog'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header'>
                                                            <h5 class='modal-title' id='confirmationModalLabel" . $row['id_usager'] . "'>
                                                                Confirmer la suppression
                                                            </h5>
                                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                        </div>
                                                        <div class='modal-body'>
                                                            Etes-vous sûr de vouloir supprimer cet usager?
                                                        </div>
                                                        <div class='modal-footer'>
                                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Annuler</button>
                                                            <a href='supprimerU.php?id_usager=" . $row['id_usager'] . "'><button type='button' class='btn btn-danger'>Supprimer</button></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>";
    ?>

                        </tbody>
                    </table>
            
                    <div class="d-flex justify-content-end m-4">
                        <button id="addUser" type="button" value="Ajouter un usager" class="btn btn-outline-dark" onclick="document.location.href='ajouterU.php'">
                            Ajouter un usager
                        </button>
                    </div>
                </div>
        
    <?php
            }
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