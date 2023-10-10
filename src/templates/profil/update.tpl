{extends file="../_profil_template.tpl"}
{block name=title} {/block}
{block name=styles}
    <link rel="stylesheet" href="assets/styles/profil_general.css">
    <link rel="stylesheet" href="assets/styles/profil/update.css">
{/block}
{block name=script}
    <script src="assets/scripts/updateuser.js" defer></script>
{/block}
{block name=innerMenu}
    {if isset($user)}
        <div class="main-profil-container">
            <form action="profil_info" method="post" enctype="multipart/form-data">
                <h2>Mon profil - Update</h2>
                <label for="firstname" class="user-data">
                    <span class="entry">Prénom : </span>
                    <input 
                        autocomplete="off"
                        class="user-data-field"
                        type="text" 
                        name="firstname" 
                        id="firstname" 
                        value="{$user->getFirstname()|capitalize}">
                </label>
                <label for="lastname" class="user-data">
                    <span class="entry">Nom : </span>
                    <input 
                        autocomplete="off"
                        class="user-data-field"
                        type="text" 
                        name="lastname" 
                        id="lastname" 
                        value="{$user->getLastname()|capitalize}">
                </label>
                <label for="login" class="user-data">
                    <span class="entry">Login : </span>
                    <input 
                    class="user-data-field"
                    autocomplete="off"
                    type="text" 
                    name="login" 
                    id="login" 
                    value="{$user->getLogin()}">
                    <span class="login-valid">
                        <svg 
                        stroke="currentColor" 
                        fill="currentColor" 
                        stroke-width="0" 
                        viewBox="0 0 512 512" 
                        class="signup-valid" 
                        height="1em" 
                        width="1em" 
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path>
                        </svg>
                    </span>
                    <span class="login-invalid hide">
                        <svg 
                        stroke="currentColor" 
                        fill="currentColor" 
                        stroke-width="0" 
                        viewBox="0 0 352 512" 
                        class="signup-invalid" 
                        height="1em" 
                        width="1em" 
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path>
                        </svg>
                    </span>
                    <span class="info-login info hide">Doit être de 4 à 24 caractères, doit commencer par une lettre</span>
                </label>
                <label for="email" class="user-data">
                    <span class="entry">Email : </span>
                    <input 
                        class="user-data-field"
                        type="text" 
                        name="email" 
                        id="email" 
                        value="{$user->getEmail()}">
                </label>
                <div class="user-info-avatar-container">
                    Avatar : 
                    <div class="avatar-container">
                        <input type="file" name="avatar" id="avatar-file" class="avatar-file" accept="image/png, image/jpeg">
                        <div class="avatar-image-container">
                            {if $baseUrl==''}
                                {$user->getFirstname()|truncate:1:""|upper}{$user->getLastname()|truncate:1:""|upper}
                            {else}
                                <img src="{$baseUrl}" alt="{$user->getAvatar()}" class="avatar-img">
                            {/if}
                        </div> 
                    </div>
                </div>
                <div>
                    <p>
                        <label for="change-pass">Modifier le mot de passe : 
                             <input type="checkbox" name="change-pass" id="change-pass">
                        </label>
                        <div class="password-container hide">
                            <label for="pass1" class="user-data">
                                <span class="entry">Nouveau mot de passe : </span>
                                <input 
                                    class="user-data-field container-label"
                                    autocomplete="off"
                                    type="password" 
                                    name="password" 
                                    id="pass1">
                                <span class="pass-valid hide" id="pass1-valid">
                                    <svg 
                                    stroke="currentColor" 
                                    fill="currentColor" 
                                    stroke-width="0" 
                                    viewBox="0 0 512 512" 
                                    class="signup-valid" 
                                    height="1em" 
                                    width="1em" 
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path>
                                    </svg>
                                </span>
                                <span class="pass-invalid hide"  id="pass1-invalid">
                                    <svg 
                                    stroke="currentColor" 
                                    fill="currentColor" 
                                    stroke-width="0" 
                                    viewBox="0 0 352 512" 
                                    class="signup-invalid" 
                                    height="1em" 
                                    width="1em" 
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path>
                                    </svg>
                                </span>
                                <span class="info-pass info hide">Doit être de 8 à 24 caractères, Doit inclure une majuscule, un chiffre et un caractère spécial : ! @ # $ % </span>
                            </label>
                            <label for="pass2" class="user-data">
                                <span class="entry">Confirmer : </span>
                                <input 
                                class="user-data-field"
                                autocomplete="off"
                                type="password" 
                                id="pass2">
                                <span class="pass-valid hide"  id="pass2-valid">
                                    <svg 
                                    stroke="currentColor" 
                                    fill="currentColor" 
                                    stroke-width="0" 
                                    viewBox="0 0 512 512" 
                                    class="signup-valid" 
                                    height="1em" 
                                    width="1em" 
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path>
                                    </svg>
                                </span>
                                <span class="pass-invalid hide"  id="pass2-invalid">
                                    <svg 
                                    stroke="currentColor" 
                                    fill="currentColor" 
                                    stroke-width="0" 
                                    viewBox="0 0 352 512" 
                                    class="signup-invalid" 
                                    height="1em" 
                                    width="1em" 
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path>
                                    </svg>
                                </span>
                            </label>
                        </div>
                    </p>
                </div>
                <div class="user-infos-system">
                    <h3>Mes paramètres</h3>
                    <label for="isvisible" class="user-data">
                        <input 
                        class="cb-user"
                        type="checkbox" 
                        name="isvisible" 
                        id="isvisible" 
                        {if $user->getVisible()==1}checked{/if}>
                        <span class="entry">Les autres utilisateurs peuvent me contacter</span>
                    </label>
                    <label for="allow" class="user-data">
                        <input 
                        class="cb-user"
                        type="checkbox"
                        name="allow" 
                        id="allow" 
                        {if $user->getAllow()==1}checked{/if}>
                        <span class="entry">Autoriser la visibilité des commentaires</span>
                        
                    </label>
                </div>
                <input type="hidden" name="action" value="update">
                <button class="user-modif-btn" type="submit">
                    Modifier les valeurs
                </button>
            </form>
        </div>
    {else}
        <p>Il y a eu un souci</p>
    {/if}
{/block}
