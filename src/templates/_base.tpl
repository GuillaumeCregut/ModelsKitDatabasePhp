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
    <link rel="stylesheet" href="assets/styles/admin_general.css">
    <link rel="stylesheet" href="assets/styles/flash.css">
    {*Ci dessous, peut être à enlever *}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">
    {block name=styles}
    {/block}
    <script src="assets/scripts/flash.js" defer></script>
    {block name=script}
    {/block}
</head>
<body>
    {include file='partials/_header.tpl'}
    {if isset($flash)}
      {include file="partials/_flash.tpl"}
    {/if}
    {block name=body}

    {/block}
    {include file='partials/_footer.tpl'}
</body>
</html>