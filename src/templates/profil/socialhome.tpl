{extends file="../_profil_template.tpl"}
{block name=title}Models Kit Database - Profil{/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/profil_general.css">
<link rel="stylesheet" href="assets/styles/profil/socialhome.css">
{/block}
{block name=script}
<script src="assets/scripts/social.js" defer></script>
{/block}
{block name=innerMenu}
<div class="main-profil-container">
    <h2>Mon réseau social</h2>
    <section class="social-container">
        <div class="new-social social-block  container-boxes">
            <h3 class="demand-title">Demandes d'amis reçues</h3>
            <div class="friend-demand-card-container">
                {if isset($demandList)}
                {foreach from=$demandList item=demand }
                <form action="profil_social" method="post">
                    <input type="hidden" name="action" value="accept">
                    <input type="hidden" name="user" value="{$demand->id}">
                    <div class="demand-container">
                        <div class="avatar-demand-container">
                            <div class="avatar-container">
                                {if $demand->avatar=='' || $demand->avatar==null}
                                    {$demand->firstname|truncate:1:""|upper}{$demand->lastname|truncate:1:""|upper}
                                {else}
                                    <img src="assets/uploads/users/{$demand->id}/{$demand->avatar}" alt="{$demand->avatar}" class="avatar-img">
                                {/if}
                            </div>
                            <p class="name-user-demand">{$demand->firstname} {$demand->lastname}</p>
                        </div>
                        <div class="demand-choice">
                            <label for="radio-refuse-{$demand->id}" class="label-demand">
                                <input type="radio" name="choice" id="radio-refuse-{$demand->id}" value="1">
                                Refuser
                            </label>
                            <label for="radio-accept-{$demand->id}"  class="label-demand">
                                <input type="radio" name="choice" id="radio-accept-{$demand->id}" value="2">
                                Accepter
                            </label>
                        </div>
                        <div class="button-demand-container">
                            <button class="demand-card-btn">Valider</button>
                        </div>
                    </div>
                </form>
                {/foreach}
                {else}
                    <p>Il n'y a aucune demande.</p>
                {/if}
            </div>
        </div>
        <div class="list social-block container-boxes">
            <div class="list-users-container social-block">
                <div class="all-users-table-container">
                    <h2 class="all-users-title">Listes des utilisteurs inscrits</h2>
                    {if isset($allUsers)}
                    <table class="all-users-table">
                        {foreach from=$allUsers item=user}
                        <tr>
                            <td class="all-user-row">
                                <div class="avatar-container">
                                    {if $user->avatar=='' || $user->avatar==null}
                                        {$user->firstname|truncate:1:""|upper}{$user->lastname|truncate:1:""|upper}
                                    {else}
                                        <img src="assets/uploads/users/{$user->id}/{$user->avatar}" alt="{$user->avatar}" class="avatar-img">
                                    {/if}
                                </div>
                            </td>
                            <td class="all-user-row">{$user->firstname} {$user->lastname}</td>
                            <td class="all-user-row">
                                <button data-id="{$user->id}" class="btn-friend-state" data-status="{$user->is_ok}">
                                    <svg 
                                    stroke="currentColor" 
                                    fill="currentColor" 
                                    stroke-width="0"
                                    viewBox="0 0 1024 1024" 
                                    class="action-user {$user->className}" 
                                    height="1em"
                                    width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M923 283.6a260.04 260.04 0 0 0-56.9-82.8 264.4 264.4 0 0 0-84-55.5A265.34 265.34 0 0 0 679.7 125c-49.3 0-97.4 13.5-139.2 39-10 6.1-19.5 12.8-28.5 20.1-9-7.3-18.5-14-28.5-20.1-41.8-25.5-89.9-39-139.2-39-35.5 0-69.9 6.8-102.4 20.3-31.4 13-59.7 31.7-84 55.5a258.44 258.44 0 0 0-56.9 82.8c-13.9 32.3-21 66.6-21 101.9 0 33.3 6.8 68 20.3 103.3 11.3 29.5 27.5 60.1 48.2 91 32.8 48.9 77.9 99.9 133.9 151.6 92.8 85.7 184.7 144.9 188.6 147.3l23.7 15.2c10.5 6.7 24 6.7 34.5 0l23.7-15.2c3.9-2.5 95.7-61.6 188.6-147.3 56-51.7 101.1-102.7 133.9-151.6 20.7-30.9 37-61.5 48.2-91 13.5-35.3 20.3-70 20.3-103.3.1-35.3-7-69.6-20.9-101.9z">
                                        </path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        {/foreach}
                    </table>
                    {else}
                    <p>Il n'y a pas d'utilisateurs</p>
                    {/if}
                </div>
            </div>
        </div>
        <div class="my-friends container-boxes">
            <h3>Liste de mes amis</h3>
            <div class="my-friends-container">
                <form action="profil_social" method="post">
                    <input type="hidden" name="action" value="remove-friend">
                </form>
                {if isset($allFriends)}
                    {foreach from=$allFriends item=friend}
                        <div class="friend-card">
                            <div class="avatar-container">
                                {if $friend->avatar=='' || $friend->avatar==null}
                                    {$friend->firstname|truncate:1:""|upper}{$friend->lastname|truncate:1:""|upper}
                                {else}
                                    <img src="assets/uploads/users/{$friend->id}/{$friend->avatar}" alt="{$friend->avatar}" class="avatar-img">
                                {/if}
                            </div>
                            <div class="friend-name-container">
                                <p>{$friend->firstname}</p>
                                <p>{$friend->lastname}</p>
                            </div>
                            <div class="friend-social-container">
                                <button class="heart-container" data-id="{$friend->id}">
                                    <svg 
                                    stroke="currentColor" 
                                    fill="currentColor" 
                                    stroke-width="0" 
                                    viewBox="0 0 1024 1024" 
                                    class="friend-icon is-ok" 
                                    height="1em" 
                                    width="1em" 
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M923 283.6a260.04 260.04 0 0 0-56.9-82.8 264.4 264.4 0 0 0-84-55.5A265.34 265.34 0 0 0 679.7 125c-49.3 0-97.4 13.5-139.2 39-10 6.1-19.5 12.8-28.5 20.1-9-7.3-18.5-14-28.5-20.1-41.8-25.5-89.9-39-139.2-39-35.5 0-69.9 6.8-102.4 20.3-31.4 13-59.7 31.7-84 55.5a258.44 258.44 0 0 0-56.9 82.8c-13.9 32.3-21 66.6-21 101.9 0 33.3 6.8 68 20.3 103.3 11.3 29.5 27.5 60.1 48.2 91 32.8 48.9 77.9 99.9 133.9 151.6 92.8 85.7 184.7 144.9 188.6 147.3l23.7 15.2c10.5 6.7 24 6.7 34.5 0l23.7-15.2c3.9-2.5 95.7-61.6 188.6-147.3 56-51.7 101.1-102.7 133.9-151.6 20.7-30.9 37-61.5 48.2-91 13.5-35.3 20.3-70 20.3-103.3.1-35.3-7-69.6-20.9-101.9z"></path>
                                    </svg>
                                    <svg 
                                    stroke="currentColor" 
                                    fill="currentColor" 
                                    stroke-width="0" 
                                    viewBox="0 0 1024 1024" 
                                    class="friend-icon stop" 
                                    height="1em" 
                                    width="1em" 
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372 0-89 31.3-170.8 83.5-234.8l523.3 523.3C682.8 852.7 601 884 512 884zm288.5-137.2L277.2 223.5C341.2 171.3 423 140 512 140c205.4 0 372 166.6 372 372 0 89-31.3 170.8-83.5 234.8z"></path>
                                    </svg>
                                </button>
                                <p>
                                    <a href="profil_ami?id={$friend->id}">
                                        <svg 
                                        stroke="currentColor" 
                                        fill="currentColor" 
                                        stroke-width="0" 
                                        version="1" 
                                        viewBox="0 0 48 48" 
                                        enable-background="new 0 0 48 48" 
                                        class="friend-icon" 
                                        height="1em" 
                                        width="1em" 
                                        xmlns="http://www.w3.org/2000/svg">
                                            <g fill="#37474F">
                                                <circle cx="33" cy="16" r="6"></circle>
                                                <circle cx="15" cy="16" r="6"></circle>
                                                <path d="M46.7,25l-15.3,3H16.7L1.4,25l4.3-7.9c1.1-1.9,3.1-3.1,5.3-3.1h26.2c2.2,0,4.2,1.2,5.3,3.1L46.7,25z"></path>
                                                <circle cx="38" cy="30" r="10"></circle>
                                                <circle cx="10" cy="30" r="10"></circle>
                                                <circle cx="24" cy="28" r="5"></circle>
                                            </g>
                                            <circle fill="#546E7A" cx="24" cy="28" r="2"></circle>
                                            <g fill="#a0f"><circle cx="38" cy="30" r="7"></circle>
                                                <circle cx="10" cy="30" r="7"></circle>
                                            </g>
                                            <g fill="#CE93D8">
                                                <path d="M41.7,27.7c-1-1.1-2.3-1.7-3.7-1.7s-2.8,0.6-3.7,1.7c-0.4,0.4-0.3,1,0.1,1.4c0.4,0.4,1,0.3,1.4-0.1 c1.2-1.3,3.3-1.3,4.5,0c0.2,0.2,0.5,0.3,0.7,0.3c0.2,0,0.5-0.1,0.7-0.3C42.1,28.7,42.1,28.1,41.7,27.7z"></path>
                                            <path d="M10,26c-1.4,0-2.8,0.6-3.7,1.7c-0.4,0.4-0.3,1,0.1,1.4c0.4,0.4,1,0.3,1.4-0.1c1.2-1.3,3.3-1.3,4.5,0 c0.2,0.2,0.5,0.3,0.7,0.3c0.2,0,0.5-0.1,0.7-0.3c0.4-0.4,0.4-1,0.1-1.4C12.8,26.6,11.4,26,10,26z"></path>
                                            </g>
                                        </svg>
                                    </a>
                                </p>
                                <p  class="message-icon-friend">
                                    <a href="profil_messages?id={$friend->id}">
                                        <svg 
                                        stroke="currentColor" 
                                        fill="currentColor" 
                                        stroke-width="0" 
                                        viewBox="0 0 24 24" 
                                        class="friend-icon" 
                                        height="1em" 
                                        width="1em" 
                                        xmlns="http://www.w3.org/2000/svg">
                                            <path fill="none" d="M0 0h24v24H0V0z"></path>
                                            <path d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6zm-2 0l-8 5-8-5h16zm0 12H4V8l8 5 8-5v10z"></path>
                                        </svg>
                                        <span class="message-count-bubble">{$friend->nbMessage}</span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    {/foreach}
                {else}
                <p>Il n'y a personne dans cette liste.</p>
                {/if}
            </div>
        </div>
    </section>
</div>
{/block}