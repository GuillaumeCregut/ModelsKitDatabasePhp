{extends file="../_params_template.tpl"}
{block name=title}Paramètres - Marques{/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/params/model.css">
<link rel="stylesheet" href="assets/styles/params/modelfilter.css">
<link rel="stylesheet" href="assets/styles/params/modelcard.css">
<link rel="stylesheet" href="assets/styles/params/modeladd.css">
{/block}
{block name=script}
{if isset($connected) &&  isset(isAdmin)}
    <script src="assets/scripts/models.js" defer></script>
{/if}
{/block}
{block name=innerMenu}
<div class="params-container">
    <section class="list">
        <h2 class="models_title">Gestion des modèles</h2>
        {if isset($list)}
            <section class="filter-models">
                <h3>Filtrage des modèles</h3>
                <form action="parametres_models" method="post">
                    <div class="filters-list">
                        <div class='filter-element-container'>
                            <label for="category-select" class='model-filter-label'>par catégorie :
                                {if isset($categories)}
                                    <select name="filter-category" id="category-select" class="select-filter">
                                        <option value="0">--</option>
                                        {foreach from=$categories item=category}
                                            <option value="{$category->getId()}">{$category->getName()}</option>
                                        {/foreach}
                                    </select>
                                {/if}
                            </label>
                            <label for="scale-select" class='model-filter-label'>par échelle :
                                {if isset($scales)}
                                    <select name="filter-scale" id="scale-select" class="select-filter">
                                        <option value="0">--</option>
                                        {foreach from=$scales item=scale}
                                            <option value="{$scale->getId()}">{$scale->getName()}</option>
                                        {/foreach}
                                    </select>
                            {/if}
                            </label>
                        </div>
                        <div class='filter-element-container'>
                            <label for="period-select" class='model-filter-label'>par période :
                                {if isset($periods)}
                                <select name="filter-period" id="period-select" class="select-filter">
                                    <option value="0">--</option>
                                        {foreach from=$periods item=period}
                                            <option value="{$period->getId()}">{$period->getName()}</option>
                                        {/foreach}
                                </select>
                                {/if}
                            </label>
                            <label for="builder-select" class='model-filter-label'>par constructeur :
                                {if isset($builders)}
                                <select name="filter-builder" id="builder-select" class="select-filter">
                                    <option value="0">--</option>
                                        {foreach from=$builders item=builder}
                                            <option value="{$builder->getId()}">{$builder->getName()}</option>
                                        {/foreach}
                                    </select>
                                {/if}
                            </label>
                        </div>
                        <div class='filter-element-container'>
                            <label for="country-select" class='model-filter-label'>par pays :
                                {if isset($countries)}
                                    <select name="filter-country" id="country-select" class="select-filter">
                                        <option value="0">--</option>
                                        {foreach from=$countries item=country}
                                            <option value="{$country->getId()}">{$country->getName()}</option>
                                        {/foreach}
                                    </select>
                                {/if}
                            </label>
                            <label for="brand-select" class='model-filter-label'>par fabricant :
                                {if isset($brands)}
                                <select name="filter-brand" id="brand-select" class="select-filter">
                                    <option value="0">--</option>
                                        {foreach from=$brands item=brand}
                                            <option value="{$brand->getId()}">{$brand->getName()}</option>
                                        {/foreach}
                                    </select>
                                {/if}
                            </label>
                        </div>
                        <label for="name-filter" class='model-filter-label'>par nom :
                            <input type="text" name="filter-name" id="name-filter" class="filter-name-input">
                        </label>
                    </div>
                    <button class='btn-filter' type="submit">
                        <svg 
                            stroke="currentColor" 
                            fill="currentColor" 
                            stroke-width="0" 
                            viewBox="0 0 24 24" 
                            class="search-model-icon" 
                            height="1em" 
                            width="1em" 
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"></path>
                            <path d="M11.412 8.586c.379.38.588.882.588 1.414h2a3.977 3.977 0 0 0-1.174-2.828c-1.514-1.512-4.139-1.512-5.652 0l1.412 1.416c.76-.758 2.07-.756 2.826-.002z"></path>
                        </svg>Trier
                    </button>
                </form>
            </section>
            <div class="model-container">
                {if isset($connected) &&  isset(isAdmin)}
                    <form action="parametres_models" method="post" id="form-delete-model">
                        <input type="hidden" name="action" value="remove">
                        <input type="hidden" name="id" value="0" id="id_hidden">
                    </form>
                {/if}
               
            </div>
        {else}
            <p>Il n'y a aucun résultat</p>
        {/if}
    </section>
    {if isset($connected)}
        <section class="single-form">
            <h2>Ajouter un nouveau modèle</h2>
            <form action="parametres_models" class="form-add-simple" method="post" id="form-add">
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
    {if isset($connected) &&  isset(isAdmin)}
        <div class="singleModal modal-hidden">
            <section class="single-modal-container">
                <form action="parametres_models" method="post" id="update_single">
                    <label for="newNameMod">Nouveau nom
                        <input type="text" name="name" id="newNameMod" class="input_simple">    
                    </label>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="0" id="modSingle">
                        <button type="submit">Modifier</button>
                </form>
                <button id="close-modal">
                    <i class="fa-solid fa-xmark" ></i>
                </button>
            </section>
        </div>
    {/if}
{/block}
