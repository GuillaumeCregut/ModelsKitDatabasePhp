{extends file="../_kit_template.tpl"}
{block name=title}Models Kit Database - Gestion{/block}
{block name=styles}
    <link rel="stylesheet" href="assets/styles/kit_general.css">
    <link rel="stylesheet" href="assets/styles/kit/management.css">
{/block}
{block name=script}
<script src="assets/scripts/management.js"></script>
{/block}
{block name=innerMenu}
    <div class="main-kit-container">
        <h2>Gestion de mes kits</h2>
        <div class="kits-management-container">
            <section class="kits-container">
                <h3>Modèles likés</h3>
                <div class="dropzone" id="liked-kits">

                </div>
            </section>
            <section class="kits-container">
                <h3>Modèles commandés</h3>
                <div class="dropzone" id="ordered">
                    
                </div>
            </section>
            <section class="kits-container">
                <h3>Modèles en stock</h3>
                <div class="dropzone" id="stock">
                    
                </div>
            </section>
            <section class="kits-container">
                <h3>Modèles en cours</h3>
                <div class="dropzone" id="wip">
                    
                </div>
            </section>
            <section class="kits-container">
                <h3>Modèles terminés</h3>
                <div class="dropzone" id="finished">
                    
                </div>
            </section>
        </div>
    </div>
{/block}