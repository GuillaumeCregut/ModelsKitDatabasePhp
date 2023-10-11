{extends file="../_profil_template.tpl"}
{block name=title}Commandes{/block}
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
        <div class="list-order">
            {if isset($orders)}
            <table class="order-list">
                <thead>
                    <tr>
                        <th class="orders-cell ref-order-cell cell-head">Référence</th>
                        <th class="orders-cell provider-cell cell-head">Fournisseur</th>
                        <th class="orders-cell date-cell cell-head">Date</th>
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
        <form action="profil_commandes" method="post" class="new-order-form">
            <div class="form-header-inputs">
                <label for="">Référence de la commande
                    <input type="text" name="" id="" class="input-ref-order">
                </label>
                <div class="order-details">
                    <label for="">Fournisseur : 
                        <select name="" id="" class="provider-list">
                            <option value="0">--</option>
                            {if isset($providers)}
                                {foreach from=$providers item=$provider}
                                    <option value="{$provider->getId()}">{$provider->getName()}</option>
                                {/foreach}
                            {/if}
                        </select>
                    </label>
                    <label for="">Date :
                        <input type="date" name="" id="" class="order-date">
                    </label>
                </div>
            </div>
            <button class="order-list-btn">Ajouter un modèle à la commande</button>
            <div class="model-list-added">
                <table>
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