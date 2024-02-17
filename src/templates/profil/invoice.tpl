{extends file="../_profil_template.tpl"}
{block name=title}Models Kit Database - Commandes{/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/profil_general.css">
<link rel="stylesheet" href="assets/styles/profil/invoice.css">
{/block}
{block name=script}
<script src="assets/scripts/invoices.js" defer></script>
{/block}
{block name=innerMenu}
<div class="main-profil-container">
    <h2>Mes Commandes</h2>
    <section class="orders-container">
        Mes commandes
        <button class="order-list-btn" id="order-show-btn">Afficher</button>
        <div class="list-order-container {if isset($open)}list-order-deployed{/if}">
            {if isset($orders)}
            <table class="order-list-table">
                <thead class="head-orders">
                    <tr>
                        <th class="orders-cell ref-order-cell cell-head">Référence
                            {if $sortBy=='reference' }
                            <a href="?sort=reference&by={if $orderBy=='asc'}desc{else}asc{/if}">
                                {else}
                                <a href="?sort=reference&by=asc">
                                {/if}
                                    <svg width="30" height="30" viewBox="0 0 264.58332 264.58334" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"
                                    class="sort-by {if $sortBy=='reference' && $orderBy=='desc'}sorted{/if}"
                                    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                                    xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/">
                                    <defs />
                                    <rect
                                        style="fill:#f7f7f7;fill-opacity:1;stroke:none;stroke-width:10.5833;stroke-linecap:square;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:stroke markers fill"
                                         width="264.58334" height="264.58334" x="-1.350586e-05"
                                        y="-1.4210855e-14" />
                                    <g  transform="translate(50.262283,10.171626)">
                                        <path
                                            style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                            d="M 65.517103,79.786786 H 144.89211" id="path7857" />
                                        <path
                                            style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                            d="M 65.517103,107.56579 H 131.66294" id="path7859" />
                                        <path
                                            style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                            d="M 65.517103,135.34479 H 118.43377" id="path7861" />
                                        <path
                                            style="fill:none;stroke:#4d4d4d;stroke-width:7.93747;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                            d="M 65.517103,163.12379 H 105.2046" id="path7863" />
                                    </g>
                                    <g  transform="translate(-87.32106,9.411583)"
                                        style="stroke:#0573e1;stroke-opacity:1">
                                        <path
                                            style="fill:none;stroke:#0573e1;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                            d="M 171.36926,80.546827 V 159.92184" id="path7867" />
                                        <path 
                                            style="fill:none;fill-opacity:1;stroke:#0573e1;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:fill markers stroke"
                                            d="m 185.98853,150.59424 -14.61927,14.61927 -14.61927,-14.61927" />
                                    </g>
                                </svg>
                                </a>
                        </th>
                        <th class="orders-cell provider-cell cell-head">Fournisseur
                            {if $sortBy=='supplier' }
                            <a href="?sort=supplier&by={if $orderBy=='asc'}desc{else}asc{/if}">
                                {else}
                                <a href="?sort=supplier&by=asc">
                                {/if}
                                    <svg width="30" height="30" viewBox="0 0 264.58332 264.58334" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"
                                    class="sort-by {if $sortBy=='supplier' && $orderBy=='desc'}sorted{/if}"
                                    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                                    xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/">
                                    <defs />
                                    <rect
                                        style="fill:#f7f7f7;fill-opacity:1;stroke:none;stroke-width:10.5833;stroke-linecap:square;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:stroke markers fill"
                                         width="264.58334" height="264.58334" x="-1.350586e-05"
                                        y="-1.4210855e-14" />
                                    <g  transform="translate(50.262283,10.171626)">
                                        <path
                                            style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                            d="M 65.517103,79.786786 H 144.89211" id="path7857" />
                                        <path
                                            style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                            d="M 65.517103,107.56579 H 131.66294" id="path7859" />
                                        <path
                                            style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                            d="M 65.517103,135.34479 H 118.43377" id="path7861" />
                                        <path
                                            style="fill:none;stroke:#4d4d4d;stroke-width:7.93747;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                            d="M 65.517103,163.12379 H 105.2046" id="path7863" />
                                    </g>
                                    <g  transform="translate(-87.32106,9.411583)"
                                        style="stroke:#0573e1;stroke-opacity:1">
                                        <path
                                            style="fill:none;stroke:#0573e1;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                            d="M 171.36926,80.546827 V 159.92184" id="path7867" />
                                        <path 
                                            style="fill:none;fill-opacity:1;stroke:#0573e1;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:fill markers stroke"
                                            d="m 185.98853,150.59424 -14.61927,14.61927 -14.61927,-14.61927" />
                                    </g>
                                </svg>
                                </a>
                        </th>
                        <th class="orders-cell date-cell cell-head">Date
                            {if $sortBy=='date' }
                            <a href="?sort=date&by={if $orderBy=='asc'}desc{else}asc{/if}">
                                {else}
                                <a href="?sort=date&by=asc">
                                {/if}
                                    <svg width="30" height="30" viewBox="0 0 264.58332 264.58334" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"
                                    class="sort-by {if $sortBy=='date' && $orderBy=='desc'}sorted{/if}"
                                    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                                    xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/">
                                    <defs />
                                    <rect
                                        style="fill:#f7f7f7;fill-opacity:1;stroke:none;stroke-width:10.5833;stroke-linecap:square;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:stroke markers fill"
                                         width="264.58334" height="264.58334" x="-1.350586e-05"
                                        y="-1.4210855e-14" />
                                    <g  transform="translate(50.262283,10.171626)">
                                        <path
                                            style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                            d="M 65.517103,79.786786 H 144.89211" id="path7857" />
                                        <path
                                            style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                            d="M 65.517103,107.56579 H 131.66294" id="path7859" />
                                        <path
                                            style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                            d="M 65.517103,135.34479 H 118.43377" id="path7861" />
                                        <path
                                            style="fill:none;stroke:#4d4d4d;stroke-width:7.93747;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                            d="M 65.517103,163.12379 H 105.2046" id="path7863" />
                                    </g>
                                    <g  transform="translate(-87.32106,9.411583)"
                                        style="stroke:#0573e1;stroke-opacity:1">
                                        <path
                                            style="fill:none;stroke:#0573e1;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                            d="M 171.36926,80.546827 V 159.92184" id="path7867" />
                                        <path 
                                            style="fill:none;fill-opacity:1;stroke:#0573e1;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:fill markers stroke"
                                            d="m 185.98853,150.59424 -14.61927,14.61927 -14.61927,-14.61927" />
                                    </g>
                                </svg>
                                </a>
                        </th>
                        <th class="orders-cell order-detail-cell cell-head">Détails</th>
                    </tr>
                </thead>
                    <tbody>
                        {foreach from=$orders item=order}
                        <tr>
                            <td class="orders-cell ref-order-cell">{$order->reference}</td>
                            <td class="orders-cell provider-cell">{$order->name}</td>
                            <td class="orders-cell date-cell">
                                {if isset($order->dateOrder)}
                                    {$order->dateOrder}
                                {else}
                                    --
                                {/if}
                            </td>
                            <td class="orders-cell order-detail-cell">
                                <button 
                                class="order-list-btn detail-btn" 
                                data-id="{$order->reference}"
                                data-key="{$order->owner}"
                                >Détails</button>
                            </td>
                        </tr>
                        {foreachelse}
                        <tr>
                            <td class="orders-cell" colspan="4">Il n'y a aucune commande</td>
                        </tr>
                        {/foreach}
                    </tbody>
            </table>
            {else}
            <p>Il n'y a aucune commande</p>
            {/if}
        </div>
    </section>
    <section class="new-order-container">
        <h2 class="ew-order-title">Ajouter une nouvelle commmande</h2>
        <form action="profil_commandes" method="post" class="new-order-form" id="new-order-form">
            <input type="hidden" name="token" value="{$token}">
            <div class="form-header-inputs">
                <label for="new-ref" class="label-add-order">Référence de la commande :
                    <input type="text" name="newRef" id="new-ref" placeholder="Référence" class="input-ref-order input-new-order">
                </label>
                <div class="order-details">
                    <label for="new-provider" class="label-add-order">Fournisseur : 
                        <select name="newProvider" id="new-provider" class="provider-list">
                            <option value="0">--</option>
                            {if isset($providers)}
                                {foreach from=$providers item=$provider}
                                    <option value="{$provider->getId()}">{$provider->getName()}</option>
                                {/foreach}
                            {/if}
                        </select>
                    </label>
                    <label for="new-date" class="label-add-order">Date :
                        <input type="date" name="newDate" id="new-date" class="order-date input-new-order">
                    </label>
                </div>
            </div>
            <div class="order-list-btn new-model-add">Ajouter un modèle à la commande</div>
            <div class="model-list-added">
                <table class="new-order-list">
                    <thead>
                        <tr>
                            <td class="orders-cell">Nom du modèle</td>
                            <td class="orders-cell">Marque</td>
                            <td class="orders-cell">Echelle</td>
                            <td class="orders-cell">Quantité</td>
                            <td class="orders-cell">Prix unitaire</td>
                        </tr>
                    </thead>
                    <tbody id="order-list-body">
                        
                    </tbody>
                </table>
            </div>
            <button class="order-list-btn">Valider</button>
        </form>
    </section>
</div>
{/block}