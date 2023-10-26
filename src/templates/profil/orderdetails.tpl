<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/profil/popupdetail.css">
    <title>Models Kit Database - Détails</title>
</head>
<body>
    <div class="inner-popup">
        {if isset($orderInfo)}
            <p>Fournisseur :{$orderInfo->getProviderName()}</p>
            <p>Référence : {$orderInfo->getRef()}</p>
            <p>Date : {if $orderInfo->getDateOrder()==''}--{else}{$orderInfo->getDateOrder()}{/if}</p>
            <p>Détails</p>
            {if isset($orderDetails)}
                <ul>
                {foreach from=$orderDetails item=detail}
                    <li> - {$detail->name} -Quantité :{$detail->qtte} - Prix unitaire :{$detail->price} euros</li>
                {/foreach}
                </ul> 
            {else}
            <p>Il n'y a aucun détail</p>
            {/if}
        {/if}
    </div>
</body>
</html>