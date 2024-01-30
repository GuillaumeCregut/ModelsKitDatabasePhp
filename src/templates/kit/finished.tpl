{extends file="../_kit_template.tpl"}
{block name=title}Models Kit Database - Kits finis{/block}
{block name=styles}
    <link rel="stylesheet" href="assets/styles/kit_general.css">
    <link rel="stylesheet" href="assets/styles/kit/kitfinished.css">
{/block}
{block name=script}
{/block}
{block name=innerMenu}
    <div class="main-kit-container">
        <h2>Mes Kits finis</h2>
       <p>Nombre : {$countKit}</p>
        <div class="tableContainer">
            {if isset($dataList)} 
            <table class="list-table">
                <thead>
                    <tr>
                        <th class="table-cell head-table">Nom
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
                        </th>
                        <th class="table-cell head-table">Constructeur
                            {if $sortBy=='builderName' }
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
                        </th>
                        <th class="table-cell head-table">Marque
                            {if $sortBy=='brandName' }
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
                        </th>
                        <th class="table-cell head-table">Echelle
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
                        </th>
                        <th class="table-cell head-table">Photos
                            {if $sortBy=='pictures' }
                            <a href="?sort=pictures&by={if $orderBy=='asc'}desc{else}asc{/if}">
                            {else}
                            <a href="?sort=pictures&by=asc">
                            {/if}
                                <svg width="30" height="30" viewBox="0 0 264.58332 264.58334" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"
                                class="sort-by {if $sortBy=='pictures' && $orderBy=='desc'}sorted{/if}"
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
                        </th>
                        <th class="table-cell head-table">Messages
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$dataList item=data}
                    <tr>
                        <td class="table-cell"><span ><a href="kit_finishedDetails?id={$data->id}" class="name-details">{$data->modelName}</a></td>
                        <td class="table-cell"> {$data->builderName}</td>
                        <td class="table-cell">{$data->brandName}</td>
                        <td class="table-cell">{$data->scaleName}</td>
                        <td class="table-cell">
                            {if $data->pictures!=null}
                            <svg 
                            stroke="currentColor" 
                            fill="currentColor" 
                            stroke-width="0" 
                            viewBox="0 0 24 24" 
                            class="icons-finished" 
                            height="1em" 
                            width="1em" 
                            xmlns="http://www.w3.org/2000/svg">
                                <path fill="none" d="M0 0h24v24H0z"></path>
                                <circle cx="12" cy="12" r="3.2"></circle>
                                <path d="M9 2L7.17 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-3.17L15 2H9zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z"></path>
                            </svg>
                            {/if}
                        </td>
                        <td class="table-cell">
                            {if isset ($data->nbMessages)}
                            <div class="messagebox">
                                <svg 
                                stroke="currentColor" 
                                fill="currentColor" 
                                stroke-width="0" 
                                viewBox="0 0 24 24" 
                                class="message-in-build" 
                                height="1em" 
                                width="1em" 
                                xmlns="http://www.w3.org/2000/svg">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"></path>
                                </svg>
                                <span class="num-message">{$data->nbMessages}</span>
                            </div>
                            {else}
                                &nbsp;
                            {/if}
                        </td>
                    </tr>
                    {foreachelse}
                    <tr>
                        <td colspan="5">Il n'y a aucun résultat</td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
        {else}
            <p>Il n'y a aucun résultat</p>
        {/if} 
       </div>
    </div>
{/block}