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
                <th  class="user_table_cell header_cell">Nom</th>
                <th  class="user_table_cell header_cell">Rang</th>
                <th  class="user_table_cell header_cell">Valide</th>
            </tr>
        </thead>
        <tbody>
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
                    <td  class="user_table_cell"><input type="checkbox" class="cb_user_valid" data-id="{$user->id}"  {if $user->isvalid==1}checked{/if}></td>
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