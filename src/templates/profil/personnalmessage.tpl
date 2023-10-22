{extends file="../_profil_template.tpl"}
{block name=title}Models Kit Database - Profil{/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/profil_general.css">
<link rel="stylesheet" href="assets/styles/profil/personnalMessage.css">
{/block}
{block name=script}

{/block}
{block name=innerMenu}
<div class="main-profil-container">
    <h2>Messagerie</h2>
  <div class="header-messenger">
    <p>Mes communications avec </p>
   <div class="identity-friend">
    <div class="avatar-container">
        {if $friend->avatar=='' || $friend->avatar==null}
            {$friend->firstname|truncate:1:""|upper}{$friend->lastname|truncate:1:""|upper}
        {else}
            <img src="assets/uploads/users/{$friend->id}/{$friend->avatar}" alt="{$friend->avatar}" class="avatar-img">
        {/if}
    </div>
    <p> {$friend->firstname} {$friend->lastname}</p>
   </div>
  </div>
  <div class="write-private-message">

  </div>
  <div class="all-messages">
    {if isset($messages)}
    {foreach from=$messages item=message}
    <div class="message {if $message->exp===$friend->id}lui{else}moi{/if}">
        <div class="message-header">
            {if  $message->exp===$friend->id}
            <div class="avatar-container">
                {if $friend->avatar=='' || $friend->avatar==null}
                    {$friend->firstname|truncate:1:""|upper}{$friend->lastname|truncate:1:""|upper}
                {else}
                    <img src="assets/uploads/users/{$friend->id}/{$friend->avatar}" alt="{$friend->avatar}" class="avatar-img">
                {/if}
            </div>
            {else}
            <div class="avatar-container">
                {if $userAvatar==null}
                    {$user->getFirstname()|truncate:1:""|upper}{$user->getLastname()|truncate:1:""|upper}
                {else}
                    <img src="{$userAvatar}" alt=" {$user->getFirstname()}" class="avatar-img">
                {/if}
            </div>
            {/if}
            <p class="message-header-text">Le : {$message->date_message} à {$message->hour_message}</p>
        </div>
        <article class="message-text">
            {$message->message|nl2br}
        </article>
    </div>
    {/foreach}
    {else}
    <p>Il n'y a pas de messages</p>
    {/if}
  </div>
</div>
{/block}