{extends file="../_admin_template.tpl"}
{block name=title}Models Kit Database - Admin - Logs{/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/admin/bdMgmt.css">
{/block}
{block name=script}{/block}
{block name=innerMenu}
<div class="db-admin">
    <h1 class="db-title">Gestion des données</h1>
    <p>Version de l'application : {$appVersion}</p>
    <p>Version de la base de données : <span class="{if $appVersion != $dbVersion}bad-version{/if}">{$dbVersion}</span>
    </p>
    <form action="admin_database" method="post">
        <input type="hidden" name="action" value="show">
        <!--Faire la vérification du select =/= 0 avant-->
        <label for="version_select">
            Version à utiliser :
            <select name="version" id="version_select">
                <option value="0">--</option>
                {foreach from=$listUpdate item=name}
                <option value="{$name}">{$name}</option>
                {/foreach}
            </select>
            <button type="submit">Voir les changements</button>
        </label>
    </form>

    {if ($arrayResult|@count)!=0}
    <div class="result">
        <p>Résultat de la mise à jour</p>
        <ul>
            {foreach from=$arrayResult item=result}
            {if $result.status=='OK'}
            <li class="result-line">
                
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve" class="checkmark">

                        <defs>
                        </defs>
                        <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
                            <path d="M 33 78 c -2.303 0 -4.606 -0.879 -6.364 -2.636 l -24 -24 c -3.515 -3.515 -3.515 -9.213 0 -12.728 c 3.515 -3.515 9.213 -3.515 12.728 0 L 33 56.272 l 41.636 -41.636 c 3.516 -3.515 9.213 -3.515 12.729 0 c 3.515 3.515 3.515 9.213 0 12.728 l -48 48 C 37.606 77.121 35.303 78 33 78 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(54,206,61); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        </g>
                        </svg>
                {$result.desc}
            </li>
            {else}
            <li class="result-line">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve" class="wrong">

                    <defs>
                    </defs>
                    <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
                        <path d="M 13.4 88.492 L 1.508 76.6 c -2.011 -2.011 -2.011 -5.271 0 -7.282 L 69.318 1.508 c 2.011 -2.011 5.271 -2.011 7.282 0 L 88.492 13.4 c 2.011 2.011 2.011 5.271 0 7.282 L 20.682 88.492 C 18.671 90.503 15.411 90.503 13.4 88.492 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(236,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        <path d="M 69.318 88.492 L 1.508 20.682 c -2.011 -2.011 -2.011 -5.271 0 -7.282 L 13.4 1.508 c 2.011 -2.011 5.271 -2.011 7.282 0 l 67.809 67.809 c 2.011 2.011 2.011 5.271 0 7.282 L 76.6 88.492 C 74.589 90.503 71.329 90.503 69.318 88.492 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(236,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                    </g>
                    </svg>
            {$result.desc} : {$result.status}</li>
            {/if}
            {/foreach}
        </ul>
    </div>
    {/if}
    {if isset($versionFile)}
    <div class="version-spe">
        <p>version du fichier : {$versionFile}</p>
        <p>Description : {$descVersion}</p>
        <p>Liste des modifications</p>
        <ul>
            {foreach from=$stepSQL item=sqlLine}
            <li>{$sqlLine->description}</li>
            {/foreach}
        </ul>
        <form action="admin_database" method="post">
            <input type="hidden" name="action" value="update">
            <button type="submit">Mettre à jour</button>
        </form>
    </div>
    {/if}
</div>
{/block}