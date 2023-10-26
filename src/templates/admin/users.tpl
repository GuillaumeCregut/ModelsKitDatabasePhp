{extends file="../_admin_template.tpl"}
{block name=title}Models Kit Database - Admin - Utilisateurs {/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/admin/users.css">
{/block}
{block name=script}
<script src="assets/scripts/admin_user.js" defer></script>
{/block}
{block name=innerMenu}
<section class="admin-user">
    <h2>Gestion des utilisateurs</h2>
    <table class="user_table">
        <thead>
            <tr>
                <th class="user_table_cell header_cell">Prénom</th>
                <th class="user_table_cell header_cell">Nom</th>
                <th class="user_table_cell header_cell">Rang</th>
                <th class="user_table_cell header_cell">Action</th>
                <th class="user_table_cell header_cell">Valide</th>
            </tr>
        </thead>
        <tbody>
            <form action="admin_users" method="post" id="form-delete">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="0" id="id-user">
            </form>
            {if isset($users)}
            {foreach from=$users item=user}
                <tr>
                    <td  class="user_table_cell">{$user->firstname}</td>
                    <td  class="user_table_cell">{$user->lastname}</td>
                    
                    <td  class="user_table_cell">
                        <select 
                            data-id="{$user->id}" 
                            data-role="{$user->rankUser}"
                            class="select_user_role"
                            {if $user->id==$defaultUser}disabled{/if}>
                                <option value="1" {if $user->rankUser==1}selected{/if}>Utilisateur</option>
                                <option value="5" {if $user->rankUser==5}selected{/if}>Administrateur</option>
                                <option value="2" {if $user->rankUser==2}selected{/if}>Modérateur</option>
                        </select>
                    </td>
                    <td  class="user_table_cell">
                        {if $user->id!=$defaultUser}
                        <button data-id="{$user->id}" class="delete-btn">
                            <svg 
                            stroke="currentColor" 
                            fill="currentColor" 
                            stroke-width="0" 
                            viewBox="0 0 448 512" 
                            class="icon-delete-user" 
                            height="1em" 
                            width="1em" 
                            xmlns="http://www.w3.org/2000/svg">
                                <path d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path>
                                </svg>
                        </button>
                        {else}
                        &nbsp;
                        {/if}
                    </td>
                    <td  class="user_table_cell">
                        {if $user->id!=$defaultUser}
                        <input type="checkbox" class="cb_user_valid" data-id="{$user->id}"  {if $user->isvalid==1}checked{/if}>
                        {else}
                        &nbsp;
                        {/if}
                    </td>
                </tr>
            {/foreach}
            {else}
                <tr>
                    <td colspan="4">Il n'y a aucun utilisateur</td>
                </tr>
            {/if}
        </tbody>
    </table>
</section>
{/block}