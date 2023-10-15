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
                        <th class="table-cell head-table">Nom</th>
                        <th class="table-cell head-table">Marque</th>
                        <th class="table-cell head-table">Echelle</th>
                        <th class="table-cell head-table">Photos</th>
                        <th class="table-cell head-table">Messages</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$dataList item=data}
                    <tr>
                        <td class="table-cell"><span ><a href="kit_finishedDetails?id={$data->id}" class="name-details">{$data->modelName} - {$data->builderName}</a></td>
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