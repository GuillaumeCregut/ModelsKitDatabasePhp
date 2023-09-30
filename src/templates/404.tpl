{extends file="_base.tpl"}
{block name=styles}
    <link rel="stylesheet" href="assets/styles/homepage.css">
    <link rel="stylesheet" href="error.css">
{/block}
{block name=body}
    {include file='partials/_navbar.tpl'}
    <h1 class="not_found">Page non trouvée.</h1>
{/block}