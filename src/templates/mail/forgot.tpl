<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récupération de mot de passe</title>
</head>
<body>
    <p>Bonjour {$firstname},<br>
     vous avez demandé à réinitialiser votre mot de passe sur le site Models Kit Database.</p>
     <p>Si vous n'êtes pas à l'initiative de cette demande, il n'est pas nécessaire d'effectuer quoi que ce soit</p>
     <p>Dans la cas où vous avez bien demandé à changer de mot de passe, veuillez vous rendre à l'adresse suivante :</p>
     <p><a href="https://{$server}">adresse de réinitialisation</a> et saisir le code suivant : {$code}</p>
     <p>Vous disposez de 24 heures pour réaliser cette opération.</p>
     <p>Cordialement, l'équipe de Models Kit Database</p>
</body>
</html>