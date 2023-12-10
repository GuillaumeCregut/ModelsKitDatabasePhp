{extends file="../_kit_template.tpl"}
{block name=title}Models Kit Database - {$title}{/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/kit_general.css">
<link rel="stylesheet" href="assets/styles/kit/kitlist.css">
{/block}
{block name=script}
<script src="assets/scripts/kitlist.js" defer></script>
{/block}
{block name=innerMenu}
<div class="main-kit-container">
    <h2>Mes Kits {$titleDisplay}</h2>
    <p>Kits {$titleDisplay} : {$countKit}</p>
    <form action="{$actionPage}" method="get" class="form-search">
        <label for="search-name">Recherche par nom :
            <input type="text" name="name" id="search-name" class="search-input" value="{$searchValue}">
        </label>
        <button class="btn-search">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                class="search-model-icon" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z">
                </path>
                <path
                    d="M11.412 8.586c.379.38.588.882.588 1.414h2a3.977 3.977 0 0 0-1.174-2.828c-1.514-1.512-4.139-1.512-5.652 0l1.412 1.416c.76-.758 2.07-.756 2.826-.002z">
                </path>
            </svg>
        </button>
    </form>
    <div class="tableContainer">
        {if isset($dataList)}
        <table class="list-table">
            <thead>
                <tr>
                    <th class="table-cell head-table">Nom</th>
                    <th class="table-cell head-table">Marque - Echelle</th>
                    <th class="table-cell head-table">Référence</th>
                    <th class="table-cell head-table">Photo</th>
                    <th class="table-cell head-table">Action</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$dataList item=data}
                <tr>
                    <td class="table-cell"><span><a href="kit_details?id={$data->id}"
                                class="name-details">{$data->modelName} - {$data->builderName}</a></td>
                    <td class="table-cell">{$data->brandName} - {$data->scaleName}</td>
                    <td class="table-cell">{$data->reference}</td>
                    <td class="table-cell">
                        <img src="{if $data->boxPicture==null||$data->boxPicture==''}assets/uploads/models/no_image.jpg{else}{$data->boxPicture}{/if}"
                            alt="{$data->modelName}" class="box-picture">
                    </td>
                    <td class="table-cell">
                        <div class="cell-action">
                        <button class="delete-btn" data-id="{$data->id}">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512"
                                class="icon-delete-kit" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z">
                                </path>
                            </svg>
                        </button>
                        <label for="newStock{$data->id}" class="action-move">Déplacer
                            <select name="newStock" id="newStock{$data->id}">
                                <option value="0">--</option>
                                {if isset($listStock) }
                                    {foreach from=$listStock key=k item=newStock}
                                        <option value="{$k}">{$newStock}</option>
                                    {/foreach}
                                {/if}
                            </select>
                            <button class="btn-move" data-id="{$data->id}">Go</button>
                        </label>
                    </div>
                    </td>
                </tr>
                {foreachelse}
                <tr>
                    <td colspan="5">Il n'y a aucun résultat</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        <form action="{$actionPage}" method="post" id="form-delete">
            <input type="hidden" name="id" id="id-delete">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="search" value="{$searchValue}">
        </form>
        <form action="{$actionPage}" method="post" id="form-move">
            <input type="hidden" name="action" value="move">
            <input type="hidden" name="id" id="id-move">
            <input type="hidden" name="newStock" value="0" id="new-stock">
        </form>
        {else}
        <p>Il n'y a aucun résultat</p>
        {/if}
    </div>
</div>
{/block}