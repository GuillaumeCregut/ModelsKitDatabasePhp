{extends file="../_profil_template.tpl"}
{block name=title}Models Kit Database - Statistiques{/block}
{block name=styles}
    <link rel="stylesheet" href="assets/styles/profil_general.css">
    <link rel="stylesheet" href="assets/styles/profil/stats.css">
{/block}
{block name=script}{/block}
{block name=innerMenu}
    <div class="main-profil-container">
        <h2>Statistiques</h2>
        <div class="stat-container">
            {if isset($stateGraph)}
                <div class="picture-constainer">
                    <img src="{$stateGraph}" alt="graphe statistiques état" class="img-stat">
                </div>
            {/if}
            {if isset($brandGraph)}
                <div class="picture-constainer">
                    <img src="{$brandGraph}" alt="graphe statistiques marques" class="img-stat">
                </div>
            {/if}
            {if isset($periodGraph)}
                <div class="picture-constainer">
                    <img src="{$periodGraph}" alt="graphe statistiques périodes" class="img-stat">
                </div>
            {/if}
            {if isset($categoryGraph)}
                <div class="picture-constainer">
                    <img src="{$categoryGraph}" alt="graphe statistiques catégories" class="img-stat">
                </div>
            {/if}
            {if isset($providerGraph)}
                <div class="picture-constainer">
                    <img src="{$providerGraph}" alt="graphe statistiques fournisseurs" class="img-stat">
                </div>
            {/if}
            {if isset($scaleGraph)}
                <div class="picture-constainer">
                    <img src="{$scaleGraph}" alt="graphe statistiques échelles" class="img-stat">
                </div>
            {/if}
        </div>
    </div>
{/block}
