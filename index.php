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
    <title>Accueil</title>
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

        $serverName = "localhost";
        $usernameDB = "root";
        $passwordDB = "";
        $dbName = "gestion_des_prets";

        $conn = new mysqli($serverName,$usernameDB,$passwordDB,$dbName);

        if($conn->connect_error) {
            die("Connexion échoué : " . $conn->connect_error);
        }

        if($position == "Etudiant") {

            $sql = "SELECT * FROM periodiques";

            $result = $conn->query($sql);

            if($result->num_rows > 0) {
    ?>

                <div class="row g-0 m-3 justify-content-around">

    <?php
                    while($row = $result->fetch_assoc()) {

                        $id_periodique=$row['id_periodique'];
                        $disabledOuNon = "";
                        $emprunterOuNon = "";

                        $sqlEP = "SELECT * FROM emprunts WHERE id_periodique='$id_periodique'";

                        $resultEP = $conn->query($sqlEP);

                        if($resultEP->num_rows > 0) {
                            $emprunterOuNon = "Ce périodique a déjà été emprunté";
                            $disabledOuNon = "disabled";
                        }
                        else {
                            $sqlEU = "SELECT * FROM emprunts WHERE id_usager='$id_usager'";

                            $resultEU = $conn->query($sqlEU);

                            if($resultEU->num_rows >= 3) {
                                $emprunterOuNon = "Vous avez déjà emprunté 3 périodiques";
                                $disabledOuNon = "disabled";
                            }
                        }

                        echo 
                            "<div class='card col-xl-2 col-lg-3 col-md-5 col-8 m-3 mb-4'>
                                <img src='" . $row['url'] . "' class='card-img-top' alt='img_periodique'>
                                <div class='card-body'>
                                    <h5 class='card-title'>" . $row['nom'] . " - Issue " . $row['numero'] . "</h5>
                                    <p class='card-text'>" . $row['titre'] . "<br>" . $row['mois'] . " " . $row['annee'] . "</p>
                                    <div class='text-end'>
                                    <button type='button' class='m-1 border border-0' data-bs-toggle='modal' data-bs-target='#bookmarkModal" . $id_periodique . "'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-bookmark' viewBox='0 0 16 16'><path d='M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z'/></svg>
                                    </button>
                                    </div>
                                    <div class='modal fade align-content-center' id='bookmarkModal" . $id_periodique . "' tabindex='-1' aria-labelledby='bookmarkModalLabel" . $id_periodique . "' aria-hidden='true'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h5 class='modal-title' id='bookmarkModalLabel" . $id_periodique . "'>
                                                        " . $row['nom'] . " - Issue " . $row['numero'] . "
                                                    </h5>
                                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                </div>
                                                <div class='modal-body'>
                                                    " . $emprunterOuNon . "
                                                </div>
                                                <div class='modal-footer'>
                                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Annuler</button>
                                                    <button type='button' class='btn btn-primary' " . $disabledOuNon . "><a href='ajouterE.php?id_periodique=" . $id_periodique . "'  class='text-light text-decoration-none'>Emprunter</a></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>";

                        $disabledOuNon = "";
                        $emprunterOuNon = "";
                    }

    ?>

                </div>

    <?php
            }
        }
        else if($position == "Professeur") {

            $sql = "SELECT * FROM periodiques";

            $result = $conn->query($sql);

            if($result->num_rows > 0) {
    ?>

                <div class="row g-0 m-3 justify-content-around">

    <?php
                    while($row = $result->fetch_assoc())
                        echo 
                            "<div class='card col-xl-2 col-lg-3 col-md-5 col-8 m-3 mb-4'>
                                <img src='" . $row['url'] . "' class='card-img-top' alt='img_periodique'>
                                <div class='card-body'>
                                    <h5 class='card-title'>" . $row['nom'] . " - Issue " . $row['numero'] . "</h5>
                                    <p class='card-text'>" . $row['titre'] . "<br>" . $row['mois'] . " " . $row['annee'] . "</p>
                                    <div class='text-end'>
                                        <a href='modifierP.php?id_periodique=" . $row['id_periodique'] . "' class='m-1'>
                                            <svg height='20' width='20' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><path d='M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z'/></svg>
                                        </a>
                                        <button type='button' class='m-1 border border-0' data-bs-toggle='modal' data-bs-target='#confirmationModal" . $row['id_periodique'] . "'>
                                            <svg xmlns='http://www.w3.org/2000/svg' height='20' width='22.5' viewBox='0 0 576 512'><path d='M290.7 57.4L57.4 290.7c-25 25-25 65.5 0 90.5l80 80c12 12 28.3 18.7 45.3 18.7L288 480l9.4 0L512 480c17.7 0 32-14.3 32-32s-14.3-32-32-32l-124.1 0L518.6 285.3c25-25 25-65.5 0-90.5L381.3 57.4c-25-25-65.5-25-90.5 0zM297.4 416l-9.4 0-105.4 0-80-80L227.3 211.3 364.7 348.7 297.4 416z'/></svg>
                                        </button>                                          
                                    </div>
                                    <div class='modal fade align-content-center' id='confirmationModal" . $row['id_periodique'] . "' tabindex='-1' aria-labelledby='confirmationModalLabel" . $row['id_periodique'] . "' aria-hidden='true'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h5 class='modal-title' id='confirmationModalLabel" . $row['id_periodique'] . "'>
                                                        Confirmer la suppression
                                                    </h5>
                                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                </div>
                                                <div class='modal-body'>
                                                    Etes-vous sûr de vouloir supprimer ce périodique?
                                                </div>
                                                <div class='modal-footer'>
                                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Annuler</button>
                                                    <a href='supprimerP.php?id_periodique=" . $row['id_periodique'] . "'><button type='button' class='btn btn-danger'>Supprimer</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>";
    ?>

                </div>
                <div class="d-flex justify-content-end m-4 p-5 pt-0">
                    <button type="button" value="Ajouter un periodique" class="btn btn-outline-dark" onclick="document.location.href='ajouterP.php'">
                        Ajouter un périodique
                    </button>
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