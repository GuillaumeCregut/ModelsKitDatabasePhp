{extends file="../_admin_template.tpl"}
{block name=title}Models Kit Database - Admin - Logs{/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/admin/bdMgmt.css">
{/block}
{block name=script}{/block}
{block name=innerMenu}
<div class="db-admin">
    <h1 class="db-title">Gestion des données</h1>
    <p>Version  de l'application : {$appVersion}</p>
    <p>Version de la base de données : <span class="{if $appVersion != $dbVersion}bad-version{/if}">{$dbVersion}</span></p>
</div>
{/block}