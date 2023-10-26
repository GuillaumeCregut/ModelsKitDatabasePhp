<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Models Kit Database</title>
</head>
<body>
    {if isset($messages)}
    {foreach from=$messages item=message}
        <p>{$message}</p>
    {/foreach}
    {/if}
</body>
</html>