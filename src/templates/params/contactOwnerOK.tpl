{extends file="../_params_template.tpl"}
{block name=title}Models Kit Database - Paramètres{/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/contactOwner.css">
{/block}
{block name=script}{/block}
{block name=innerMenu}
<div class="params-container">
    <h1>Contacter les propiétaires de ce kit</h1>
    {foreach from=$errors item=error}
    <p class="error-contact">{$error}</p>
    {/foreach}
    <p>Votre message à été envoyé aux propriétaires de ce kit. Ils vous répondront directement par mail.</p>
</div>
{/block}
