<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon"  href="assets/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{block name=title}Models Kit Database{/block}</title>
    <link rel="stylesheet" href="assets/styles/general.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <link rel="stylesheet" href="assets/styles/header.css">
    <link rel="stylesheet" href="assets/styles/footer.css">
    <link rel="stylesheet" href="assets/styles/welcome.css">
    <link rel="stylesheet" href="assets/styles/param_general.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    {block name=styles}
    {/block}
    {block name=script}
    {/block}
</head>
<body>
    {include file='partials/_header.tpl'}
    {block name=body}

    {/block}
    {include file='partials/_footer.tpl'}
</body>
</html>