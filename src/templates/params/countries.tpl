{extends file="../_params_template.tpl"}
{block name=title}Paramètres - Pays{/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/params/country.css">
<link rel="stylesheet" href="assets/styles/params/single.css">
{/block}
{block name=script}
{if isset($connected) &&  isset(isAdmin)}
    <script src="assets/scripts/countries.js" defer></script>
    <script src="assets/scripts/single.js" defer></script>
{/if}
{/block}
{block name=innerMenu}
<div class="params-container">
    <section class="list">
        <h2 class="countries_title">Gestion des pays</h2>
        {if isset($list)}
            {if isset($connected) &&  isset(isAdmin)}
                <form action="parametres_countries" method="post" id="form-delete-country">
                    <input type="hidden" name="action" value="remove">
                    <input type="hidden" name="id" value="0" id="id_hidden">
                </form>
            {/if}
            <table class="single-table">
                <thead>
                    <tr class="single-row">
                        <th class="single-cell single-table-head">Nom</th>
                        <th class="single-cell single-table-head">Action</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$list item=country}
                        <tr class="single-row">
                            <td class="single-cell">
                                <span class="country-name" data-id="{$country->getId()}">
                                    {$country->getName()}
                                </span>
                            </td>
                            <td class="single-cell">
                                {if isset($connected) &&  isset(isAdmin)}
                                <button 
                                    class="single-delete-btn" 
                                    data-id="{$country->getId()}"
                                    data-name="{$country->getName()}">
                                    <svg 
                                        stroke="currentColor" 
                                        fill="currentColor" 
                                        stroke-width="0" 
                                        viewBox="0 0 448 512" 
                                        class="trash-simple" 
                                        height="1em" 
                                        width="1em" 
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path>
                                    </svg>
                                </button>
                                {else}
                                    &nbsp;
                                {/if}
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        {/if}
    </section>
    {if isset($connected)}
        <section class="single-form">
            <h2>Ajouter un nouveau pays</h2>
            <form action="parametres_countries" class="form-add-simple" method="post" id="form-add">
                <input type="hidden" name="action" value="add">
                <label for="new-name">Nom du nouvel élément : 
                    <input 
                        type="text" 
                        name="name" 
                        id="new-name"  
                        class="input_simple"
                        placeholder="Nom"
                        autocomplete="off"
                        >
                </label>
                <button type="submit" class="form-add-simple-btn">
                    <svg 
                    stroke="currentColor" 
                    fill="currentColor" 
                    stroke-width="0" 
                    viewBox="0 0 24 24" 
                    class="icon-add-simple-button"
                    height="1em" 
                    width="1em" 
                    xmlns="http://www.w3.org/2000/svg">
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path d="M18 13c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zm3 5.5h-2.5V21h-1v-2.5H15v-1h2.5V15h1v2.5H21v1zM7 5h13v2H7z"></path>
                        <circle cx="3.5" cy="18" r="1.5"></circle>
                        <path d="M18 11H7v2h6.11c1.26-1.24 2.99-2 4.89-2zM7 17v2h4.08c-.05-.33-.08-.66-.08-1s.03-.67.08-1H7z"></path>
                        <circle cx="3.5" cy="6" r="1.5"></circle>
                        <circle cx="3.5" cy="12" r="1.5"></circle>
                    </svg>
                    Ajouter
                </button>
            </form>
        </section>
    {/if}
</div>
{/block}
