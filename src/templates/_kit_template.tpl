{extends file="_base.tpl"}
{block name=title}Models Kit Database - paramètres {/block}
{block name=styles}{/block}
{block name=script}
   
{/block}
{block name=body}
    {include file='partials/_navbar.tpl'}
    <div class="kits">
        {include file='partials/_left_menu_kit.tpl'}
        {block name=innerMenu}
        {/block}
    </div>
{/block}