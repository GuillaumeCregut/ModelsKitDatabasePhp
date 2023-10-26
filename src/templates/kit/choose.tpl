{extends file="../_kit_template.tpl"}
{block name=title}Models Kit Database - Choisir un kit{/block}
{block name=styles}
    <link rel="stylesheet" href="assets/styles/kit_general.css">
    <link rel="stylesheet" href="assets/styles/kit/choose.css">
{/block}
{block name=script}{/block}
{block name=innerMenu}
    <div class="main-kit-container">
        <h2>Selection aléatoire</h2>
        <p class="random-desc">Vous ne savez pas quel kit de votre stock vous souhaitez mettre sur l'établi ?<br>
            Laisser le hasard vous proposer un kit</p>
        <form action="kit_choose" method="post">
            <input type="hidden" name="action" value="random">
            <button class="button-search">
                <svg 
                stroke="currentColor" 
                fill="currentColor" 
                stroke-width="0" 
                viewBox="0 0 24 24" 
                height="1em" 
                width="1em" 
                xmlns="http://www.w3.org/2000/svg">
                <path fill="none" d="M0 0h24v24H0V0z"></path>
                <path d="M7 9H2V7h5v2zm0 3H2v2h5v-2zm13.59 7l-3.83-3.83c-.8.52-1.74.83-2.76.83-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5c0 1.02-.31 1.96-.83 2.75L22 17.59 20.59 19zM17 11c0-1.65-1.35-3-3-3s-3 1.35-3 3 1.35 3 3 3 3-1.35 3-3zM2 19h10v-2H2v2z"></path>
                </svg>
                Rechercher</button>
        </form>
        {if isset($kitSelected)} 
            <div class="random-model-container">
                <p>Vous pouvez monter ce kit</p>
                <div>
                    <p>{$kitSelected->brandName} -{$kitSelected->builderName}  {$kitSelected->modelName}</p>
                    <img src="{$kitSelected->boxPicture}" alt="{$kitSelected->modelName}" class="image-random">
                    <p>{$kitSelected->scaleName}- {$kitSelected->reference}</p>
                    <form action="kit_choose" method="post">
                        <input type="hidden" name="action" value="add-wip">
                        <input type="hidden" name="id" value="{$kitSelected->id}">
                        <button class="button-search add-btn">
                            <svg 
                            stroke="currentColor"
                            class="icon-add" 
                            fill="currentColor" 
                            stroke-width="0" 
                            viewBox="0 0 16 16" 
                            height="1em" 
                            width="1em" 
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5Z"></path>
                            <path d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585c.055.156.085.325.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5c0-.175.03-.344.085-.5ZM8.5 6.5V8H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V9H6a.5.5 0 0 1 0-1h1.5V6.5a.5.5 0 0 1 1 0Z"></path>
                            </svg>
                            Mettre sur l'établi
                        </button>
                    </form>
                </div>
            </div>
        {/if}  
    </div>
{/block}