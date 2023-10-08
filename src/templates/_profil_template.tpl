{extends file="_base.tpl"}
{block name=title}Models Kit Database - profil{/block}
{block name=styles}{/block}
{block name=script}
   
{/block}
{block name=body}
    {include file='partials/_navbar.tpl'}
    <div class="profil">
        {include file='partials/_left_menu_profil.tpl'}
        {block name=innerMenu}
        {/block}
    </div>
{/block}