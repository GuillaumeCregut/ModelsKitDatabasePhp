{extends file="../_params_template.tpl"}
{block name=title}Models Kit Database - Paramètres - Modèles{/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/params/model.css">
<link rel="stylesheet" href="assets/styles/params/modelfilter.css">
<link rel="stylesheet" href="assets/styles/params/modelcard.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
{/block}

{block name=script}
{if isset($connected) && isset(isAdmin)}
<script src="assets/scripts/models.js" defer></script>
<script src="assets/scripts/modelscard.js" defer></script>
{else}
<script src="assets/scripts/modelscardalone.js" defer></script>
{/if}
{/block}
{block name=innerMenu}
<div class="params-container">
    <section class="list">
        <h2 class="models_title">Gestion des modèles</h2>
        {if isset($list)}
        <p>Nombre de kit en stock : {$nbKits}</p>
        <section class="filter-models">
            <h3>Filtrage des modèles</h3>
            <form action="parametres_models" method="post">
                <input type="hidden" name="token" value="{$token}" id="token">
                <input type="hidden" name="action" value="search">
                <div class="filters-list">
                    <div class='filter-element-container'>
                        <label for="category-select" class='model-filter-label'>par catégorie :
                            {if isset($categories)}
                            <select name="filter-category" id="category-select" class="select-filter">
                                <option value="0">--</option>
                                {foreach from=$categories item=category}
                                <option value="{$category->getId()}" {if isset($fCategory) && $category->getId()==$fCategory}selected{/if}>{$category->getName()}</option>
                                {/foreach}
                            </select>
                            {/if}
                        </label>
                        <label for="scale-select" class='model-filter-label'>par échelle :
                            {if isset($scales)}
                            <select name="filter-scale" id="scale-select" class="select-filter">
                                <option value="0">--</option>
                                {foreach from=$scales item=scale}
                                <option value="{$scale->getId()}" {if isset($fScale) && $scale->getId()==$fScale}selected{/if}>{$scale->getName()}</option>
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
                                <option value="{$period->getId()}" {if isset($fPeriod) && $period->getId()==$fPeriod}selected{/if}>{$period->getName()}</option>
                                {/foreach}
                            </select>
                            {/if}
                        </label>
                        <label for="builder-select" class='model-filter-label'>par constructeur :
                            {if isset($builders)}
                            <select name="filter-builder" id="builder-select" class="select-filter">
                                <option value="0">--</option>
                                {foreach from=$builders item=builder}
                                <option value="{$builder->getId()}" {if isset($fBuilder) && $builder->getId()==$fBuilder}selected{/if}>{$builder->getName()}</option>
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
                                <option value="{$country->getId()}" {if isset($fCountry) && $country->getId()==$fCountry}selected{/if}>{$country->getName()}</option>
                                {/foreach}
                            </select>
                            {/if}
                        </label>
                        <label for="brand-select" class='model-filter-label'>par fabricant :
                            {if isset($brands)}
                            <select name="filter-brand" id="brand-select" class="select-filter">
                                <option value="0">--</option>
                                {foreach from=$brands item=brand}
                                <option value="{$brand->getId()}" {if isset($fBrand) && $brand->getId()==$fBrand}selected{/if}>{$brand->getName()}</option>
                                {/foreach}
                            </select>
                            {/if}
                        </label>
                    </div>
                    <label for="name-filter" class='model-filter-label'>par nom :
                        <input type="text" name="filter-name" id="name-filter" class="filter-name-input" {if isset($fName)}value="{$fName}" {/if}>
                    </label>
                    <label for="ref-filter" class='model-filter-label'>par référence :
                        <input type="text" name="filter-ref" id="ref-filter" class="filter-name-input" {if isset($fRef)}value="{$fRef}" {/if}>
                    </label>      
                </div>
                <div class='filter-element-container'>
                    <label for="only-like">Seulement les kits que j'ai likés
                        <input type="checkbox" name="only-like" id="only-like" {if $isLiked}checked{/if}>
                    </label>
                </div>
                <button class='btn-filter' type="submit">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                        class="search-model-icon" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z">
                        </path>
                        <path
                            d="M11.412 8.586c.379.38.588.882.588 1.414h2a3.977 3.977 0 0 0-1.174-2.828c-1.514-1.512-4.139-1.512-5.652 0l1.412 1.416c.76-.758 2.07-.756 2.826-.002z">
                        </path>
                    </svg>Trier
                </button>
            </form>
        </section>
        {if isset($filtered)}Filtrage actif{/if}
        <div class="model-container">
            {if isset($connected) && isset(isAdmin)}
            <form action="parametres_models" method="post" id="form-delete-model">
                <input type="hidden" name="action" value="remove">
                <input type="hidden" name="token" value="{$token}">
                <input type="hidden" name="id" value="0" id="id_hidden">
            </form>
            {/if}
            {foreach from=$list item=model}
            <article class="model-block">
                <div class="model-card-container">
                    <div class="card-flip card-settings">
                        <div class="card-inner">
                            <div class="flip-card-front">
                                <img src="{if $model->getImage()}{$model->getImage()}{else} assets/uploads/models/no_image.jpg {/if}"
                                    alt="{$model->getName()}" class="model-picture">
                            </div>
                            <div class="flip-card-back">
                                constructeur: {$model->getBuilder()}<br>
                                Pays: {$model->getCountryName()}<br>
                                Catégorie: {$model->getCategory()}<br>
                                Période: {$model->getPeriod()}<br>
                                {if {$model->getScalemates()}!='' or $model->getScalemates()!=null }
                                    <a href="{$model->getScalemates()}" target="_blank">scalemates</a>
                                {/if}
                                {include file='params/_starRating.tpl' id=$model->getId() rating=0 globalrate=$model->getGlobalRate()}
                            </div>
                        </div>
                    </div>
                    <h3 class="model-card-title">{$model->getBrand()}<br>{$model->getName()}</h3>
                    <p class="model-reference">{$model->getRef()} - {$model->getScale()}</p>
                    {if isset($connected)}
                        <div class="user-buttons">
                            <button class="like-card-btn cards-btn" data-id="{$model->getId()}"
                                data-like="{$model->getLiked()}">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024"
                                    class="model-like {if $model->getLiked() }model-like-true{/if}" height="1em" width="1em"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M923 283.6a260.04 260.04 0 0 0-56.9-82.8 264.4 264.4 0 0 0-84-55.5A265.34 265.34 0 0 0 679.7 125c-49.3 0-97.4 13.5-139.2 39-10 6.1-19.5 12.8-28.5 20.1-9-7.3-18.5-14-28.5-20.1-41.8-25.5-89.9-39-139.2-39-35.5 0-69.9 6.8-102.4 20.3-31.4 13-59.7 31.7-84 55.5a258.44 258.44 0 0 0-56.9 82.8c-13.9 32.3-21 66.6-21 101.9 0 33.3 6.8 68 20.3 103.3 11.3 29.5 27.5 60.1 48.2 91 32.8 48.9 77.9 99.9 133.9 151.6 92.8 85.7 184.7 144.9 188.6 147.3l23.7 15.2c10.5 6.7 24 6.7 34.5 0l23.7-15.2c3.9-2.5 95.7-61.6 188.6-147.3 56-51.7 101.1-102.7 133.9-151.6 20.7-30.9 37-61.5 48.2-91 13.5-35.3 20.3-70 20.3-103.3.1-35.3-7-69.6-20.9-101.9zM512 814.8S156 586.7 156 385.5C156 283.6 240.3 201 344.3 201c73.1 0 136.5 40.8 167.7 100.4C543.2 241.8 606.6 201 679.7 201c104 0 188.3 82.6 188.3 184.5 0 201.2-356 429.3-356 429.3z">
                                    </path>
                                </svg>
                                <span class="liketip tooltip">Ajouter à mes favoris</span>
                            </button>
                            <button class="cart-add-card cards-btn" data-id="{$model->getId()}">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                                    class="add-cart-model" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="none" d="M0 0h24v24H0V0z"></path>
                                    <path
                                        d="M11 9h2V6h3V4h-3V1h-2v3H8v2h3v3zm-4 9c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2zm-8.9-5h7.45c.75 0 1.41-.41 1.75-1.03l3.86-7.01L19.42 4l-3.87 7H8.53L4.27 2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2z">
                                    </path>
                                </svg>
                                <span class="addtip tooltip">Ajouter à mon stock</span>
                            </button>
                            <a href="/contactowner?id={$model->getId()}" class="contact"><svg 
                                stroke="currentColor" 
                                fill="currentColor" 
                                stroke-width="0" 
                                viewBox="0 0 24 24" 
                                class="contact-icon" 
                                height="1em" 
                                width="1em" 
                                xmlns="http://www.w3.org/2000/svg">
                                    <path fill="none" d="M0 0h24v24H0V0z"></path>
                                    <path d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6zm-2 0l-8 5-8-5h16zm0 12H4V8l8 5 8-5v10z"></path>
                                </svg><span class="message-tip tooltip">Contacter les propriétaires</span></a>
                        </div>
                        {if isset($isAdmin)}
                            <div class="card-btn-container">
                                <button class="update-card cards-btn" data-id="{$model->getId()}">
                                    <svg stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 15 15"
                                        class="update-rm-btn" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M1.90321 7.29677C1.90321 10.341 4.11041 12.4147 6.58893 12.8439C6.87255 12.893 7.06266 13.1627 7.01355 13.4464C6.96444 13.73 6.69471 13.9201 6.41109 13.871C3.49942 13.3668 0.86084 10.9127 0.86084 7.29677C0.860839 5.76009 1.55996 4.55245 2.37639 3.63377C2.96124 2.97568 3.63034 2.44135 4.16846 2.03202L2.53205 2.03202C2.25591 2.03202 2.03205 1.80816 2.03205 1.53202C2.03205 1.25588 2.25591 1.03202 2.53205 1.03202L5.53205 1.03202C5.80819 1.03202 6.03205 1.25588 6.03205 1.53202L6.03205 4.53202C6.03205 4.80816 5.80819 5.03202 5.53205 5.03202C5.25591 5.03202 5.03205 4.80816 5.03205 4.53202L5.03205 2.68645L5.03054 2.68759L5.03045 2.68766L5.03044 2.68767L5.03043 2.68767C4.45896 3.11868 3.76059 3.64538 3.15554 4.3262C2.44102 5.13021 1.90321 6.10154 1.90321 7.29677ZM13.0109 7.70321C13.0109 4.69115 10.8505 2.6296 8.40384 2.17029C8.12093 2.11718 7.93465 1.84479 7.98776 1.56188C8.04087 1.27898 8.31326 1.0927 8.59616 1.14581C11.4704 1.68541 14.0532 4.12605 14.0532 7.70321C14.0532 9.23988 13.3541 10.4475 12.5377 11.3662C11.9528 12.0243 11.2837 12.5586 10.7456 12.968L12.3821 12.968C12.6582 12.968 12.8821 13.1918 12.8821 13.468C12.8821 13.7441 12.6582 13.968 12.3821 13.968L9.38205 13.968C9.10591 13.968 8.88205 13.7441 8.88205 13.468L8.88205 10.468C8.88205 10.1918 9.10591 9.96796 9.38205 9.96796C9.65819 9.96796 9.88205 10.1918 9.88205 10.468L9.88205 12.3135L9.88362 12.3123C10.4551 11.8813 11.1535 11.3546 11.7585 10.6738C12.4731 9.86976 13.0109 8.89844 13.0109 7.70321Z"
                                            fill="currentColor">
                                        </path>
                                    </svg>
                                </button>
                                <button class="delete-card cards-btn" data-id="{$model->getId()}"
                                    data-name="{$model->getName()}">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512"
                                        class="update-rm-btn" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        {/if}
                   {/if}
                </div>
            </article>
            {/foreach}
        </div>
        {else}
        <p>Il n'y a aucun résultat</p>
        {/if}
    </section>
    {if isset($connected)}

    <section class="model-add-form">
        <h2>Ajouter un nouveau modèle</h2>
        <p class="model-warning">Avant d'ajouter un modèle, vérifiez avec la référence qu'il n'existe pas.</p>
        <p class="model-warning">Vérifiez bien votre saisie avant envoi <span class="warn">Attention, pas de fichier image avif</span>.</p>
        <form action="parametres_models" class="form-add-model" method="post" enctype="multipart/form-data"
            id="form-add">
            <div class="form-add-model-inputs-container">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="token" value="{$token}">
                <label for="new-name">Nom du nouvel élément :
                    <input type="text" name="name" id="new-name" class="add-model-form-input" placeholder="Nom"
                        autocomplete="off">
                </label>
                <label for="new-reference">Référence :
                    <input 
                    placeholder="référence" 
                    id="new-reference" 
                    class='add-model-form-input' 
                    autoComplete="off"
                    name="reference"
                        required>
                </label>
                <label for="new-brand">Marque du kit :
                    {if isset($brands)}
                    <select name="new-brand" id="new-brand" class="select-filter new">
                        <option value="0">--</option>
                        {foreach from=$brands item=brand}
                        <option value="{$brand->getId()}">{$brand->getName()}</option>
                        {/foreach}
                    </select>
                    {/if}
                </label>
                <label for="new-builder">Constructeur :
                    {if isset($builders)}
                    <select name="new-builder" id="new-builder" class="select-filter new">
                        <option value="0">--</option>
                        {foreach from=$builders item=builder}
                        <option value="{$builder->getId()}">{$builder->getName()}</option>
                        {/foreach}
                    </select>
                    {/if}
                </label>
            </div>
            <div class="form-add-model-inputs-container">
                <label for="new-scale">Echelle :
                    {if isset($scales)}
                    <select name="new-scale" id="new-scale" class="select-filter new">
                        <option value="0">--</option>
                        {foreach from=$scales item=scale}
                        <option value="{$scale->getId()}">{$scale->getName()}</option>
                        {/foreach}
                    </select>
                    {/if}
                </label>
                <label for="new-category">Catégorie :
                    {if isset($categories)}
                    <select name="new-category" id="new-category" class="select-filter new">
                        <option value="0">--</option>
                        {foreach from=$categories item=category}
                        <option value="{$category->getId()}">{$category->getName()}</option>
                        {/foreach}
                    </select>
                    {/if}
                </label>
                <label for="new-period">Période :
                    {if isset($periods)}
                    <select name="new-period" id="new-period" class="select-filter new">
                        <option value="0">--</option>
                        {foreach from=$periods item=period}
                        <option value="{$period->getId()}">{$period->getName()}</option>
                        {/foreach}
                    </select>
                    {/if}
                </label>
                <label for="new-scalemates">Lien scalemates :
                    <input placeholder="Scalemates" id="new-scalemates" class='add-model-form-input' autoComplete="off"
                        name="new-scalemates">
                </label>
            </div>
            <div class="form-add-model-bottom">

                <div class="box-input" id="file-drop">
                    <div class="box-inner" id="box-inner">
                        <input 
                        type="file" 
                        name="new-picture" 
                        id="new-picture" 
                        class="input-file-add"
                        accept="image/jpeg,image/png"
                        >
                        <label for="new-picture"><span class="box-dragndrop">Glisser la photo</span></label>
                        <img src="" alt="picture display" class="new-picture-display" id="new-picture-display">
                    </div>

                </div>
                <button type="submit" class="form-add-model-btn">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                        class="icon-add-model" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
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
                    </svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </section>

    {/if}
</div>
{/block}