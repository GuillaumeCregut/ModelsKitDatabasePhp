{extends file="../_profil_template.tpl"}
{block name=title}Models Kit Database - Fournisseurs{/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/profil_general.css">
<link rel="stylesheet" href="assets/styles/profil/provider.css">
{/block}
{block name=script}
<script src="assets/scripts/provider.js" defer></script>
{/block}
{block name=innerMenu}
<div class="provider-container main-profil-container">
    <h2>Mes Fournisseurs</h2>
    <div>
        <table class="provider-table">
            <thead>
                <tr class="provider-row">
                    <th class="provider-cell">&nbsp;</th>
                    <th class="provider-cell">Nom</th>
                    <th class="provider-cell">Détails</th>
                    <th class="provider-cell">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                {if isset($providers)}
                {foreach from=$providers item=provider}
                <tr class="provider-row">
                    <td class="provider-cell">
                        <button class="provider-delete-btn provider-btn" data-id="{$provider->getId()}"
                            data-name="{$provider->getName()}">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512"
                                class="trash-provider" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z">
                                </path>
                            </svg>
                        </button>
                    </td>
                    <td class="provider-cell">{if $provider->getURL()!=''}<a href="{$provider->getURL()}"
                            target="_blank" rel="noreferrer">{$provider->getName()}</a>{else}{$provider->getName()}{/if}
                        <div data-id="{$provider->getName()}" class="hidden-details">
                            <table class="details-table">
                                <thead>
                                    <tr>
                                        <th>Référence</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {foreach from=$provider->getOrders() item=order}
                                    <tr>
                                        <td class="detail-cell"><span class="order-item" data-id="{$order->reference}" data-key="{{$order->owner}}">{$order->reference}</span></td>
                                        <td class="detail-cell">{$order->dateOfOrder}</td>
                                    </tr>
                                    {/foreach}
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td class="provider-cell">
                        <button class="details-btn" data-supplier="{$provider->getName()}">
                            Détails
                        </button>
                    </td>
                    <td class="provider-cell">
                        <button class="provider-update-btn provider-btn" data-id="{$provider->getId()}"
                            data-name="{$provider->getName()}">
                            <svg class="change-provider" stroke="currentColor" fill="none" stroke-width="0"
                                viewBox="0 0 15 15" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M1.90321 7.29677C1.90321 10.341 4.11041 12.4147 6.58893 12.8439C6.87255 12.893 7.06266 13.1627 7.01355 13.4464C6.96444 13.73 6.69471 13.9201 6.41109 13.871C3.49942 13.3668 0.86084 10.9127 0.86084 7.29677C0.860839 5.76009 1.55996 4.55245 2.37639 3.63377C2.96124 2.97568 3.63034 2.44135 4.16846 2.03202L2.53205 2.03202C2.25591 2.03202 2.03205 1.80816 2.03205 1.53202C2.03205 1.25588 2.25591 1.03202 2.53205 1.03202L5.53205 1.03202C5.80819 1.03202 6.03205 1.25588 6.03205 1.53202L6.03205 4.53202C6.03205 4.80816 5.80819 5.03202 5.53205 5.03202C5.25591 5.03202 5.03205 4.80816 5.03205 4.53202L5.03205 2.68645L5.03054 2.68759L5.03045 2.68766L5.03044 2.68767L5.03043 2.68767C4.45896 3.11868 3.76059 3.64538 3.15554 4.3262C2.44102 5.13021 1.90321 6.10154 1.90321 7.29677ZM13.0109 7.70321C13.0109 4.69115 10.8505 2.6296 8.40384 2.17029C8.12093 2.11718 7.93465 1.84479 7.98776 1.56188C8.04087 1.27898 8.31326 1.0927 8.59616 1.14581C11.4704 1.68541 14.0532 4.12605 14.0532 7.70321C14.0532 9.23988 13.3541 10.4475 12.5377 11.3662C11.9528 12.0243 11.2837 12.5586 10.7456 12.968L12.3821 12.968C12.6582 12.968 12.8821 13.1918 12.8821 13.468C12.8821 13.7441 12.6582 13.968 12.3821 13.968L9.38205 13.968C9.10591 13.968 8.88205 13.7441 8.88205 13.468L8.88205 10.468C8.88205 10.1918 9.10591 9.96796 9.38205 9.96796C9.65819 9.96796 9.88205 10.1918 9.88205 10.468L9.88205 12.3135L9.88362 12.3123C10.4551 11.8813 11.1535 11.3546 11.7585 10.6738C12.4731 9.86976 13.0109 8.89844 13.0109 7.70321Z"
                                    fill="currentColor"></path>
                            </svg>
                        </button>
                    </td>
                </tr>
                {/foreach}
                {else}
                <tr>
                    <td colspan="3">Aucun fournisseur trouvé</td>
                </tr>
                {/if}
            </tbody>
        </table>
        <form action="profil_fournisseurs" method="post" id="delete-provider">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="token" value="{$token}">
            <input type="hidden" name="id" value="0" id="deleteId">
        </form>
    </div>
    <div class="form-add-supplier-container">
        <h3>Ajouter un fournisseur</h3>
        <form action="profil_fournisseurs" method="post" class="form-add-provider">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="token" value="{$token}">
            <label for="name">
                Nom du fournisseur :
                <input type="text" class="input_provider" name="name" id="name" autocomplete="off" required
                    autocomplete="off">
            </label>
            <button type="submit" class="provider-form-btn add-btn">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                    class="add-supplier-icon" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <path
                        d="M18 13c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zm3 5.5h-2.5V21h-1v-2.5H15v-1h2.5V15h1v2.5H21v1zM7 5h13v2H7z">
                    </path>
                    <circle cx="3.5" cy="18" r="1.5"></circle>
                    <path
                        d="M18 11H7v2h6.11c1.26-1.24 2.99-2 4.89-2zM7 17v2h4.08c-.05-.33-.08-.66-.08-1s.03-.67.08-1H7z">
                    </path>
                    <circle cx="3.5" cy="6" r="1.5"></circle>
                    <circle cx="3.5" cy="12" r="1.5"></circle>
                </svg>Ajouter
            </button>
        </form>
    </div>
</div>
<div class="provider-modal modal-hidden">
    <section class="provider-modal-container">
        <h3>Modifier</h3>
        <form action="profil_fournisseurs" method="post" id="update_provider">
            <label for="newNameMod">Nouveau nom
                <input type="text" name="name" id="newNameMod" required autocomplete="off" class="input_provider">
            </label>
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="token" value="{$token}">
            <input type="hidden" name="id" value="0" id="mod-provider">
            <button type="submit" class="provider-form-btn">Modifier</button>
        </form>
        <button id="close-modal">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </section>
</div>
{/block}