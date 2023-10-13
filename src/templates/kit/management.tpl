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
        <div class="kits-management-container">
            <section class="kits-container">
                <h3>Modèles likés</h3>
                <div class="dropzone" id="liked-kits" data-id="{$zoneLike}">

                </div>
            </section>
            <section class="kits-container">
                <h3>Modèles commandés</h3>
                <div class="dropzone" id="ordered" data-id="{$zoneBuy}">
                    
                </div>
            </section>
            <section class="kits-container">
                <h3>Modèles en stock</h3>
                <div class="dropzone" id="stock" data-id="{$zoneStock}">
                    <article class="kit-card draggable" id="model_2" draggable="true" data-id="2">
                        <h4>Nom2 - Builder</h4>
                        <p>Marque - Echelle</p>
                        <p>Référence</p>
                    </article>
                </div>
            </section>
            <section class="kits-container">
                <h3>Modèles en cours</h3>
                <div class="dropzone" id="wip" data-id="{$zoneWip}">
                    {* Pour article, mettre le Id en dynamique avec Id du modele*}
                    <article class="kit-card draggable" id="model_1" draggable="true" data-id="1">
                        <h4>Nom - Builder</h4>
                        <p>Marque - Echelle</p>
                        <p>Référence</p>
                    </article>
                </div>
            </section>
            <section class="kits-container">
                <h3>Modèles terminés</h3>
                <div class="dropzone" id="finished" data-id="{$zoneFinished}">
                    
                </div>
            </section>
        </div>
    </div>
{/block}