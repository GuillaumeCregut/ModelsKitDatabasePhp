<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Bonjour,</h2>
    <p>Ce message vous est envoyé par la plateforme Model Kit Database, car {$userName} vous a envoyé le message suivant concernant le modèle <br>
    Nom : {$modelName}<br>
    Marque : {$modelBrand} <br>
    Echelle: {$modelScale} <br>
    Référence : {$modelReference}</p>
    <p>Son message : </p>
    <p>{$message}</p>
    <p>Vous pouvez lui répondre à cette adresse : <a href="mailto:{$userMail}">{$userMail}</a></p>
    <p>Cette personne n'a pas connaissance de votre mail.</p>
    <p>Vous souhaitant une bonne journée.</p>
    <p>L'équipe de ModelsKitDatabase</p>
</body>
</html>