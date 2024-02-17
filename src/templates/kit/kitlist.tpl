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
                    <th class="table-cell head-table">
                        {if $sortBy=='modelName' }
                        <a href="?sort=name&by={if $orderBy=='asc'}desc{else}asc{/if}">
                        {else}
                        <a href="?sort=name&by=asc">
                        {/if}
                        <svg width="30" height="30" viewBox="0 0 264.58332 264.58334" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"
                            class="sort-by {if $sortBy=='modelName' && $orderBy=='desc'}sorted{/if}"
                            xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                            xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/">
                            <defs />
                            <rect
                                style="fill:#f7f7f7;fill-opacity:1;stroke:none;stroke-width:10.5833;stroke-linecap:square;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:stroke markers fill"
                                 width="264.58334" height="264.58334" x="-1.350586e-05"
                                y="-1.4210855e-14" />
                            <g  transform="translate(50.262283,10.171626)">
                                <path
                                    style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                    d="M 65.517103,79.786786 H 144.89211" id="path7857" />
                                <path
                                    style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                    d="M 65.517103,107.56579 H 131.66294" id="path7859" />
                                <path
                                    style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                    d="M 65.517103,135.34479 H 118.43377" id="path7861" />
                                <path
                                    style="fill:none;stroke:#4d4d4d;stroke-width:7.93747;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                    d="M 65.517103,163.12379 H 105.2046" id="path7863" />
                            </g>
                            <g  transform="translate(-87.32106,9.411583)"
                                style="stroke:#0573e1;stroke-opacity:1">
                                <path
                                    style="fill:none;stroke:#0573e1;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                    d="M 171.36926,80.546827 V 159.92184" id="path7867" />
                                <path 
                                    style="fill:none;fill-opacity:1;stroke:#0573e1;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:fill markers stroke"
                                    d="m 185.98853,150.59424 -14.61927,14.61927 -14.61927,-14.61927" />
                            </g>
                        </svg>
                    </a>
                        Nom
                    </th>
                    <th class="table-cell head-table">
                        {if $sortBy=='builderName'}
                        <a href="?sort=builder&by={if $orderBy=='asc'}desc{else}asc{/if}">
                        {else}
                        <a href="?sort=builder&by=asc">
                        {/if}
                        <svg width="30" height="30" viewBox="0 0 264.58332 264.58334" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"
                            class="sort-by {if $sortBy=='builderName' && $orderBy=='desc'}sorted{/if}"
                            xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                            xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/">
                            <defs />
                            <rect
                                style="fill:#f7f7f7;fill-opacity:1;stroke:none;stroke-width:10.5833;stroke-linecap:square;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:stroke markers fill"
                                 width="264.58334" height="264.58334" x="-1.350586e-05"
                                y="-1.4210855e-14" />
                            <g  transform="translate(50.262283,10.171626)">
                                <path
                                    style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                    d="M 65.517103,79.786786 H 144.89211" id="path7857" />
                                <path
                                    style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                    d="M 65.517103,107.56579 H 131.66294" id="path7859" />
                                <path
                                    style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                    d="M 65.517103,135.34479 H 118.43377" id="path7861" />
                                <path
                                    style="fill:none;stroke:#4d4d4d;stroke-width:7.93747;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                    d="M 65.517103,163.12379 H 105.2046" id="path7863" />
                            </g>
                            <g  transform="translate(-87.32106,9.411583)"
                                style="stroke:#0573e1;stroke-opacity:1">
                                <path
                                    style="fill:none;stroke:#0573e1;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                    d="M 171.36926,80.546827 V 159.92184" id="path7867" />
                                <path 
                                    style="fill:none;fill-opacity:1;stroke:#0573e1;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:fill markers stroke"
                                    d="m 185.98853,150.59424 -14.61927,14.61927 -14.61927,-14.61927" />
                            </g>
                        </svg>
                        </a>
                        Constructeur</th>
                    <th class="table-cell head-table">
                        {if $sortBy=='brandName'}
                        <a href="?sort=brand&by={if $orderBy=='asc'}desc{else}asc{/if}">
                        {else}
                        <a href="?sort=brand&by=asc">
                        {/if}
                        <svg width="30" height="30" viewBox="0 0 264.58332 264.58334" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"
                            class="sort-by {if $sortBy=='brandName' && $orderBy=='desc'}sorted{/if}"
                            xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                            xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/">
                            <defs />
                            <rect
                                style="fill:#f7f7f7;fill-opacity:1;stroke:none;stroke-width:10.5833;stroke-linecap:square;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:stroke markers fill"
                                 width="264.58334" height="264.58334" x="-1.350586e-05"
                                y="-1.4210855e-14" />
                            <g  transform="translate(50.262283,10.171626)">
                                <path
                                    style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                    d="M 65.517103,79.786786 H 144.89211" id="path7857" />
                                <path
                                    style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                    d="M 65.517103,107.56579 H 131.66294" id="path7859" />
                                <path
                                    style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                    d="M 65.517103,135.34479 H 118.43377" id="path7861" />
                                <path
                                    style="fill:none;stroke:#4d4d4d;stroke-width:7.93747;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                    d="M 65.517103,163.12379 H 105.2046" id="path7863" />
                            </g>
                            <g  transform="translate(-87.32106,9.411583)"
                                style="stroke:#0573e1;stroke-opacity:1">
                                <path
                                    style="fill:none;stroke:#0573e1;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                    d="M 171.36926,80.546827 V 159.92184" id="path7867" />
                                <path 
                                    style="fill:none;fill-opacity:1;stroke:#0573e1;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:fill markers stroke"
                                    d="m 185.98853,150.59424 -14.61927,14.61927 -14.61927,-14.61927" />
                            </g>
                        </svg>
                    </a>
                        Marque</th>
                    <th class="table-cell head-table">
                        {if $sortBy=='scaleName' }
                        <a href="?sort=scale&by={if $orderBy=='asc'}desc{else}asc{/if}">
                            {else}
                            <a href="?sort=scale&by=asc">
                            {/if}
                        <svg width="30" height="30" viewBox="0 0 264.58332 264.58334" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"
                            class="sort-by {if $sortBy=='scaleName' && $orderBy=='desc'}sorted{/if}"
                            xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                            xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/">
                            <defs />
                            <rect
                                style="fill:#f7f7f7;fill-opacity:1;stroke:none;stroke-width:10.5833;stroke-linecap:square;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:stroke markers fill"
                                 width="264.58334" height="264.58334" x="-1.350586e-05"
                                y="-1.4210855e-14" />
                            <g  transform="translate(50.262283,10.171626)">
                                <path
                                    style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                    d="M 65.517103,79.786786 H 144.89211" id="path7857" />
                                <path
                                    style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                    d="M 65.517103,107.56579 H 131.66294" id="path7859" />
                                <path
                                    style="fill:none;stroke:#4d4d4d;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                    d="M 65.517103,135.34479 H 118.43377" id="path7861" />
                                <path
                                    style="fill:none;stroke:#4d4d4d;stroke-width:7.93747;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                    d="M 65.517103,163.12379 H 105.2046" id="path7863" />
                            </g>
                            <g  transform="translate(-87.32106,9.411583)"
                                style="stroke:#0573e1;stroke-opacity:1">
                                <path
                                    style="fill:none;stroke:#0573e1;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                                    d="M 171.36926,80.546827 V 159.92184" id="path7867" />
                                <path 
                                    style="fill:none;fill-opacity:1;stroke:#0573e1;stroke-width:7.9375;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1;paint-order:fill markers stroke"
                                    d="m 185.98853,150.59424 -14.61927,14.61927 -14.61927,-14.61927" />
                            </g>
                        </svg>
                        </a>
                        Echelle</th>
                    <th class="table-cell head-table">Référence</th>
                    <th class="table-cell head-table">Photo</th>
                    <th class="table-cell head-table">Action</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$dataList item=data}
                <tr>
                    <td class="table-cell">
                        <span><a href="kit_details?id={$data->id}" class="name-details">{$data->modelName}</a>
                    </td>
                    <td class="table-cell">{$data->builderName}</td>
                    <td class="table-cell">{$data->brandName}</td>
                    <td class="table-cell">{$data->scaleName}</td>
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
            <input type="hidden" name="token" value="{$token}">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="search" value="{$searchValue}">
        </form>
        <form action="{$actionPage}" method="post" id="form-move">
            <input type="hidden" name="action" value="move">
            <input type="hidden" name="token" value="{$token}">
            <input type="hidden" name="id" id="id-move">
            <input type="hidden" name="newStock" value="0" id="new-stock">
        </form>
        {else}
        <p>Il n'y a aucun résultat</p>
        {/if}
    </div>
</div>
{/block}