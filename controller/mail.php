<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Envoi d'un message par formulaire</title>
</head>
<body>
    <?php
    $retour = mail('virg.franfran@gmail.com', 'Envoi depuis la page Contact', $_POST['message'], 'From : virg.franfran@gmail.com');
    if ($retour) {
        echo '<p>Votre message a bien été envoyé.</p>';
    else 
        echo '<p>Une erreur s est produite'</p>;
    }
    ?>
</body>
</html>