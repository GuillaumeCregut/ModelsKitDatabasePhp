{extends file="../_kit_template.tpl"}
{block name=title}Models Kit Database - Détails{/block}
{block name=styles}
    <link rel="stylesheet" href="assets/styles/kit_general.css">
    <link rel="stylesheet" href="assets/styles/kit/details.css">
{/block}
{block name=script}{/block}
{block name=innerMenu}
    <div class="main-kit-container">
        {if isset($model)}
            <h2>Détails du modèle :"{$model->modelName}"</h2>
            <div class="img-kit">
                <img src="{$model->picture}" alt="{$model->modelName}" class="kit-detail-picture">
            </div>
            <ul class="list-details">
                <li class="line-detail">
                    <svg 
                    class="detail-icon"
                    stroke="currentColor" 
                    fill="currentColor" 
                    stroke-width="0" 
                    viewBox="0 0 24 24" 
                    height="1em" 
                    width="1em" 
                    xmlns="http://www.w3.org/2000/svg">
                        <path fill="none" d="M0 0h24v24H0z" clip-rule="evenodd"></path>
                        <path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z"></path>
                    </svg>
                    <span class="data-title">Constructeur : </span><span>{$model->builderName}</span>
                </li>
                <li class="line-detail">
                    <svg 
                    class="detail-icon"
                    stroke="currentColor" 
                    fill="currentColor" 
                    stroke-width="0" 
                    viewBox="0 0 24 24" 
                    height="1em" 
                    width="1em" 
                    xmlns="http://www.w3.org/2000/svg">
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path d="M14.4 6L14 4H5v17h2v-7h5.6l.4 2h7V6z"></path>
                    </svg>
                    <span class="data-title">Pays : </span><span>{$model->countryName}</span>
                </li>
                <li class="line-detail">
                    <svg 
                    class="detail-icon"
                    stroke="currentColor" 
                    fill="currentColor" 
                    stroke-width="0" 
                    viewBox="0 0 24 24" 
                    height="1em" 
                    width="1em" 
                    xmlns="http://www.w3.org/2000/svg">
                        <path fill="none" d="M0 0h24v24H0V0z"></path>
                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"></path>
                    </svg>
                    <span class="data-title">Période : </span><span>{$model->periodName}</span>
                </li>
                <li class="line-detail">
                    <svg 
                    class="detail-icon"
                    stroke="currentColor" 
                    fill="currentColor" 
                    stroke-width="0" 
                    viewBox="0 0 24 24" 
                    height="1em" 
                    width="1em" 
                    xmlns="http://www.w3.org/2000/svg">
                        <path fill="none" d="M0 0h24v24H0V0z"></path>
                        <path d="M18.92 5.01C18.72 4.42 18.16 4 17.5 4h-11c-.66 0-1.21.42-1.42 1.01L3 11v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.85 6h10.29l1.04 3H5.81l1.04-3zM19 16H5v-4.66l.12-.34h13.77l.11.34V16z"></path>
                        <circle cx="7.5" cy="13.5" r="1.5"></circle><circle cx="16.5" cy="13.5" r="1.5"></circle>
                    </svg>
                    <span class="data-title">Catégorie : </span><span>{$model->categoryName}</span>
                </li>
                <li class="line-detail">
                    <svg 
                    class="detail-icon"
                    stroke="currentColor" 
                    fill="currentColor" 
                    stroke-width="0" 
                    viewBox="0 0 24 24" 
                    height="1em" 
                    width="1em" 
                    xmlns="http://www.w3.org/2000/svg">
                        <path fill="none" d="M0 0h24v24H0V0z"></path>
                        <path d="M21 3H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H3V5h18v14zm-10-7h9v6h-9z"></path>
                    </svg>
                    <span class="data-title">Marque : </span> <span>{$model->brandName}</span>
                </li>
                <li class="line-detail"><span class="data-title">Référence : </span><span>{$model->reference}</span></li>
                <li class="line-detail">
                    <svg
                    class="detail-icon" 
                    stroke="currentColor" 
                    fill="currentColor" 
                    stroke-width="0" 
                    viewBox="0 0 24 24" 
                    height="1em" 
                    width="1em" 
                    xmlns="http://www.w3.org/2000/svg">
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path d="M14 11V8c4.56-.58 8-3.1 8-6H2c0 2.9 3.44 5.42 8 6v3c-3.68.73-8 3.61-8 11h6v-2H4.13c.93-6.83 6.65-7.2 7.87-7.2s6.94.37 7.87 7.2H16v2h6c0-7.39-4.32-10.27-8-11zm-2 11c-1.1 0-2-.9-2-2 0-.55.22-1.05.59-1.41C11.39 17.79 16 16 16 16s-1.79 4.61-2.59 5.41c-.36.37-.86.59-1.41.59z"></path>
                    </svg>
                    <span class="data-title">Echelle : </span><span>{$model->scaleName}</span>
                </li>
                <li class="line-detail">
                    <span class="data-title">Statut : </span><span>{$model->stateName}</span>
                </li>
                {if $model->providerName!=null}
                    <li class="line-detail">
                        <span class="data-title">Fournisseur : </span><span>{$model->providerName}</span>
                    </li>
                {/if}
                {if $model->price!=null}
                    <li class="line-detail">
                        <svg
                        class="detail-icon" 
                        stroke="currentColor" 
                        fill="currentColor" 
                        stroke-width="0" 
                        viewBox="0 0 16 16" 
                        height="1em" 
                        width="1em" 
                        xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 9.42h1.063C5.4 12.323 7.317 14 10.34 14c.622 0 1.167-.068 1.659-.185v-1.3c-.484.119-1.045.17-1.659.17-2.1 0-3.455-1.198-3.775-3.264h4.017v-.928H6.497v-.936c0-.11 0-.219.008-.329h4.078v-.927H6.618c.388-1.898 1.719-2.985 3.723-2.985.614 0 1.175.05 1.659.177V2.194A6.617 6.617 0 0 0 10.341 2c-2.928 0-4.82 1.569-5.244 4.3H4v.928h1.01v1.265H4v.928z"></path>
                        </svg>
                        <span class="data-title">Prix : </span><span>{$model->price} euros</span>
                    </li>
                {/if}
            </ul>
            {if $model->pictures!=null}
                <p><a href="kit_finisheddetails?id={$model->id}">Voir les photos</a></p>
            {/if}
       {else}
            <p>Il n'y a pas de modèle sélectionné</p>
       {/if}
    </div>
{/block}