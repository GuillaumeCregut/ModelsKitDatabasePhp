{extends file="../_profil_template.tpl"}
{block name=title}Mes informations{/block}
{block name=styles}
    <link rel="stylesheet" href="assets/styles/profil_general.css">
    <link rel="stylesheet" href="assets/styles/profil/info.css">
{/block}
{block name=script}{/block}
{block name=innerMenu}
    {if isset($user)}
        <div>
            <h2>Mon profil</h2>
            <p class="user-data"><span class="entry">Prénom : </span>{$user->getFirstname()|capitalize}</p>
            <p class="user-data"><span class="entry">Nom : </span>{$user->getLastname()|capitalize}</p>
            <p class="user-data"><span class="entry">Login : </span>{$user->getLogin()} </p>
            <p class="user-data"><span class="entry">Email : </span>{$user->getEmail()}</p>
            <div class="user-info-avatar-container">
                Avatar : 
                <div class="avatar-container">
                {if $baseUrl==''}
                    {$user->getFirstname()|truncate:1:""|upper}{$user->getLastname()|truncate:1:""|upper}
                {else}
                    <img src="{$baseUrl}" alt="{$user->getAvatar()}" class="avatar-img">
                {/if}
                </div>
            </div>
            <div class="user-infos-system">
                <h3>Mes paramètres</h3>
                <p class="user-data"><span class="entry">Visibilité : </span>{if $user->getVisible()==1}Oui{else}Non{/if}</p>
                <p class="user-data"><span class="entry">Les commentaires sont visible par tout le monde : </span>{if $user->getAllow()==1}Oui{else}Non{/if} </p>
            </div>
            <form action="profil_info" method="post">
                <input type="hidden" name="action" value="start-update">
                <button class="user-modif-btn" type="submit">
                    Modifier les valeurs
                </button>
            </form>
        </div>
    {else}
        <p>Il y a eu un souci</p>
    {/if}
{/block}
