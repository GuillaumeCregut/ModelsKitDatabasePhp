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
    <form action="?id={$modelId}" method="post">
        <label for="message">
            Votre message :
            <textarea name="message" id="message" cols="30" rows="10" class="message-to-owners"></textarea>
        </label>
        <button type="submit" class="send-btn"> <svg 
            stroke="currentColor" 
            fill="currentColor" 
            stroke-width="0" 
            viewBox="0 0 24 24" 
            class="send-icon" 
            height="1em" 
            width="1em" 
            xmlns="http://www.w3.org/2000/svg">
                <path fill="none" d="M0 0h24v24H0V0z"></path>
                <path d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6zm-2 0l-8 5-8-5h16zm0 12H4V8l8 5 8-5v10z"></path>
            </svg>
        </button>
    </form>
</div>
{/block}
