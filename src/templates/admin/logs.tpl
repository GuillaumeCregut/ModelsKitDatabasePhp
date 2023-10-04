{extends file="../_admin_template.tpl"}
{block name=title} {/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/admin/logs.css">
{/block}
{block name=script}{/block}
{block name=innerMenu}
<div class="logs">
    <h1 class='logs-title'>Logs serveur</h1>
    <div class="log-container">
        <div class='log-item-container'>
            <h2>Logs : Logs : Erreurs </h2>
            <div class="log-item-value">
                <ul>
                    {if isset($errorLogs)}
                        {foreach from=$errorLogs item=errlog}
                        <li>{$errlog}</li>
                        {/foreach}
                    {/if}
                </ul>
            </div>
        </div>
    </div>
    <div class="log-container">
        <div class='log-item-container'>
            <h2>Logs : Logs : Warning </h2>
            <div class="log-item-value">
                <ul>
                    {if isset($warnLogs)}
                        {foreach from=$warnLogs item=warnlog}
                            <li>{$warnlog}</li>
                        {/foreach}
                    {/if}
                </ul>
            </div>
        </div>
    </div>
    <div class="log-container">
        <div class='log-item-container'>
            <h2>Logs : Logs : Infos </h2>
            <div class="log-item-value">
                <ul>
                    {if isset($infoLogs)}
                        {foreach from=$infoLogs item=infolog}
                            <li>{$infolog}</li>
                        {/foreach}
                    {/if}
                </ul>
            </div>
        </div>
    </div>
</div>
{/block}