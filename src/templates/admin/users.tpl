{extends file="../_admin_template.tpl"}
{block name=title}Administration - Utilisateurs {/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/admin/users.css">
{/block}
{block name=script}
<script src="assets/scripts/admin_user.js" defer></script>
{/block}
{block name=innerMenu}
<section class="admin-user">
    <h2>Gestion des utilisateurs</h2>
    <table>
        <thead>
            <tr>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Rang</th>
                <th>Etat</th>
            </tr>
        </thead>
        <tbody>
            {if isset($users)}
            {foreach from=$users item=user}
                <tr>
                    <td>{$user->id}->{$user->firstname}</td>
                    <td>{$user->lastname}</td>
                    
                    <td><select 
                        data-id="{$user->id}" 
                        data-role="{$user->rankUser}"
                        class="select_user_role"
                        {if $user->id==$defaultUser}disabled{/if}>
                        <option value="1" {if $user->rankUser==1}selected{/if}>Utilisateur</option>
                        <option value="2" {if $user->rankUser==2}selected{/if}>Modérateur</option>
                        <option value="5" {if $user->rankUser==5}selected{/if}>Administrateur</option>
                    </select>
                        {$user->rankUser}</td>
                    <td><input type="checkbox" class="cb_user_valid" data-id="{$user->id}"  {if $user->isvalid==1}checked{/if}></td>
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