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
        <section className='pdf-container'>
            {if isset($filepath)}
            <div class="pdf-object-container">
                <object data={$filepath} type="application/pdf" class='pdf-object'>
                    <a href={$filepath} target='_blank'>PDF</a>
                </object>
            </div>
            {else}
                <p>Une erreur est survenue</p>
            {/if}
        </section>
    </div>
{/block}
