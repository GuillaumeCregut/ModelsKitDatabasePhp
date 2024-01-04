{extends file="../_kit_template.tpl"}
{block name=title}Models Kit Database - Gestion{/block}
{block name=styles}
    <link rel="stylesheet" href="assets/styles/kit_general.css">
    <link rel="stylesheet" href="assets/styles/kit/management.css">
{/block}
{block name=script}
<script src="assets/scripts/management.js" defer></script>
{/block}
{block name=innerMenu}
    <div class="main-kit-container">
        <h2>Gestion de mes kits</h2>
        <input type="hidden" name="token" value="{$token}" id="token">
        <div class="kits-management-container">
            <section class="kits-container">
                <h3>Modèles likés</h3>
                <div class="dropzone" id="liked-kits" data-id="{$zoneLike}">
                    {if isset($likeModels)}
                        {foreach from=$likeModels item=likedModel}
                            <article class="kit-card draggable" id="model_{$likedModel->id}" draggable="true" data-id="{$likedModel->id}">
                                <h4>{$likedModel->modelName} - {$likedModel->builderName}</h4>
                                <p>{$likedModel->brandName} - {$likedModel->scaleName}</p>
                                <p>{$likedModel->reference}</p>
                            </article>
                        {/foreach}
                    {/if}
                </div>
            </section>
            <section class="kits-container">
                <h3>Modèles commandés</h3>
                <div class="dropzone" id="ordered" data-id="{$zoneBuy}">
                    {if isset($buyModels)}
                        {foreach from=$buyModels item=buydModel}
                            <article class="kit-card draggable" id="model_{$buydModel->id}" draggable="true" data-id="{$buydModel->id}">
                                <h4>{$buydModel->modelName} - {$buydModel->builderName}</h4>
                                <p>{$buydModel->brandName} -{$buydModel->scaleName}</p>
                                <p>{$buydModel->reference}</p>
                            </article>
                        {/foreach}
                    {/if}
                </div>
            </section>
             <section class="kits-container">
                
                <h3>Modèles en stock</h3>
                <div class="dropzone" id="stock" data-id="{$zoneStock}">
                    {if isset($stockedModels)}
                        {foreach from=$stockedModels item=stockModelElmt}
                          <article class="kit-card draggable" id="model_{$stockModelElmt->id}" draggable="true" data-id="{$stockModelElmt->id}">
                                <h4>{$stockModelElmt->modelName} - {$stockModelElmt->builderName}</h4>
                                <p>{$stockModelElmt->brandName} - {$stockModelElmt->scaleName}</p>
                                <p>{$stockModelElmt->reference}</p>
                            </article>
                        {/foreach}
                    {/if}
                </div>
            </section>
            <section class="kits-container">
                <h3>Modèles en cours</h3>
                <div class="dropzone" id="wip" data-id="{$zoneWip}">
                    {if isset($wipModels)}
                        {foreach from=$wipModels item=wipModel}
                            <article class="kit-card draggable" id="model_{$wipModel->id}" draggable="true" data-id="{$wipModel->id}">
                                <h4>{$wipModel->modelName} - {$wipModel->builderName}</h4>
                                <p>{$wipModel->brandName} - {$wipModel->scaleName}</p>
                                <p>{$wipModel->reference}</p>
                            </article>
                        {/foreach}
                    {/if}
                </div>
            </section>
            <section class="kits-container">
                <h3>Modèles terminés</h3>
                <div class="dropzone" id="finished" data-id="{$zoneFinished}">
                    {if isset($finishedModels)}
                    {foreach from=$finishedModels item=finishedModel}
                        <article class="kit-card draggable" id="model_{$finishedModel->id}" draggable="true" data-id="{$finishedModel->id}">
                            <h4>{$finishedModel->modelName} - {$finishedModel->builderName}</h4>
                            <p>{$finishedModel->brandName} - {$finishedModel->scaleName}</p>
                            <p>{$finishedModel->reference}</p>
                        </article>
                    {/foreach}
                {/if}
                </div>
            </section>
        </div>
    </div>
{/block}