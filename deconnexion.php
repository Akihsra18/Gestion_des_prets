<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="fr-ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deconnexion</title>
</head>
<body>
    
    <?php
        session_unset();
        session_destroy();
        header('location:connexion.php');
    ?>

</body>
</html>