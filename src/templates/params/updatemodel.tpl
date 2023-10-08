{extends file="../_params_template.tpl"}
{block name=title}Paramètres - Marques{/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/params/modelupdate.css">
{/block}
{block name=script}
{if isset($connected) &&  isset(isAdmin)}  
    <script src="assets/scripts/updateModel.js" defer></script>
{/if}
{/block}
{block name=innerMenu}
<div class="params-container">
    {if isset($model)}
        {if isset($connected) &&  isset(isAdmin)}
            <section class="update-model-container">
                <h2 class="update-model-container-title">Modification du modèle</h2>
                {* parametre_models *}
                <form action="parametres_models" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="{$model->getId()}">
                    <input type="hidden" name="oldPicture" value="{$model->getImage()}">
                    <label for="name" class="label-update">Nom du modèle :
                        <input 
                        class="add-model-form-input"
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{$model->getName()}"
                        >
                    </label>
                    <label for="ref" class="label-update">Référence :
                        <input 
                        class="add-model-form-input"
                        type="text" 
                        name="reference" 
                        id="ref" 
                        value="{$model->getRef()}">
                    </label>
                    <label for="scalemates" class="label-update">Lien scalemates :
                        <input 
                        class="add-model-form-input"
                        type="text" 
                        name="new-scalemates" 
                        id="scalemates" 
                        value="{$model->getScalemates()}">
                    </label>
                    <label for="brand-select" class="label-update">Marque :
                        {if isset($brands)}
                        <select name="new-brand" id="brand-select" class="select-filter">
                            <option value="0">--</option>
                            {foreach from=$brands item=brand}
                            <option value="{$brand->getId()}"{if $model->getBrandId()==$brand->getId()}selected{/if}>{$brand->getName()}</option>
                            {/foreach}
                        </select>
                        {/if}
                    </label>
                    <label for="builder-select" class="label-update">Constructeur :
                        {if isset($builders)}
                        <select name="new-builder" id="builder-select" class="select-filter">
                            <option value="0">--</option>
                            {foreach from=$builders item=builder}
                            <option value="{$builder->getId()}" {if $model->getBuilderId()==$builder->getId()}selected{/if}>{$builder->getName()}</option>
                            {/foreach}
                        </select>
                        {/if}
                    </label>
                    <label for="scale-select" class="label-update">Echelle :
                        {if isset($scales)}
                        <select name="new-scale" id="scale-select" class="select-filter">
                            <option value="0">--</option>
                            {foreach from=$scales item=scale}
                            <option value="{$scale->getId()}" {if $model->getScaleId()==$scale->getId()}selected{/if}>{$scale->getName()}</option>
                            {/foreach}
                        </select>
                        {/if}
                    </label>
                    <label for="category-select" class="label-update">Catégorie :
                        {if isset($categories)}
                        <select name="new-category" id="category-select" class="select-filter">
                            <option value="0">--</option>
                            {foreach from=$categories item=category}
                            <option value="{$category->getId()}" {if $model->getCategoryId()==$category->getId()}selected{/if}>{$category->getName()}</option>
                            {/foreach}
                        </select>
                        {/if}</label>
                    <label for="period-select" class="label-update">Période :
                        {if isset($periods)}
                            <select name="new-period" id="period-select" class="select-filter">
                                <option value="0">--</option>
                                {foreach from=$periods item=period}
                                <option value="{$period->getId()}"{if $model->getPeriodId()==$period->getId()}selected {/if}>{$period->getName()}</option>
                                {/foreach}
                            </select>
                            {/if}
                    </label>
                    <div class="picture-model">
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
                                {if $model->getImage()=='' or $model->getImage()==null}
                                <img src="" alt="picture display" class="new-picture-display" id="new-picture-display">
                                {else}
                                <img src="{$model->getImage()}" alt="picture display" class="new-picture-display display-image" id="new-picture-display">
                                {/if}
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="form-add-model-btn">Modifier</button>
                    <button type="reset" class="form-add-model-btn">Annuler</button>
                </form>
            </section>
        {else}
            <p>Erreur, cette page n'est pas disponible pour un utilisateur</p> 
        {/if}
    {else}
        <p>Il n'y a pas de modèle selectionné</p> 
    {/if}
    </div>
{/block}


