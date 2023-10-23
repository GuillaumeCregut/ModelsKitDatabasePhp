{extends file="../_profil_template.tpl"}
{block name=title}Models Kit Database - Profil{/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/profil_general.css">
<link rel="stylesheet" href="assets/styles/profil/friendhome.css">
{/block}
{block name=script}
<script src="assets/scripts/friendhome.js" defer></script>
{/block}
{block name=innerMenu}
<div class="main-profil-container">
    <h2>Vous trouverez ci dessous les kits terminés par votre ami.</h2>
    <div class="friend-models-container">
        <form action="profil_montage" method="post" id="form-go">
            <input type="hidden" name="id" value="0" id="id_build">
            <input type="hidden" name="action" value="go">
            <input type="hidden" name="friend" value="{$friend}">
        </form>
        {if isset($models)}
            {foreach from=$models item=model}
                <article class="friend-model-card" data-id="{$model->id}">
                    <h4>{$model->modelName} - {$model->builderName}</h4>
                    <img src="{if $model->boxPicture==null && $model->boxPicture==''}assets/uploads/models/no_image.jpg{else}{$model->boxPicture}{/if}" alt="" class="friend-model-box">
                    <p>{$model->brandName} - {$model->scaleName}</p>
                    <p>Référence : {$model->reference}</p>
                    {if $model->pictures==null || $model->pictures==''}
                    {else}
                    <div>
                        <svg 
                        stroke="currentColor" 
                        fill="currentColor" 
                        stroke-width="0" 
                        viewBox="0 0 24 24" 
                        class="icon-photo-finished" 
                        height="1em" 
                        width="1em" 
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <circle cx="12" cy="12" r="3.2"></circle>
                        <path d="M9 2L7.17 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-3.17L15 2H9zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z"></path>
                        </svg>
                    </div>
                    {/if}
                </article>
            {/foreach}
        {else}
            <p>Il n'y a pas de kit.</p>
        {/if}
    </div>
</div>
{/block}