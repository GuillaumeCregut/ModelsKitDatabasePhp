{extends file="../_params_template.tpl"}
{block name=title}Models Kit Database - Paramètres{/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/contactOwner.css">
{/block}
{block name=script}{/block}
{block name=innerMenu}
<div class="params-container">
    <h1>Contacter les propiétaires de ce kit</h1>
    <form action="?id={$modelId}" method="post">
        <button type="submit">Envoyer le message</button>
    </form>
</div>
{/block}
