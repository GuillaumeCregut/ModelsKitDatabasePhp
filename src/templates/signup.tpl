{extends file="_base.tpl"}
{block name=styles}
    <link rel="stylesheet" href="assets/styles/homepage.css">
    <link rel="stylesheet" href="assets/styles/signup.css">
{/block}
{block name=script}
<script src="assets/scripts/signup.js" defer></script>
{/block}
{block name=body}
    {include file='partials/_navbar.tpl'}
    {if isset($success)}
    <section>
        <p>Votre compte à bien été créé, Il est en attente de validation.<br :>
        Un mail vous parviendra quand votre compte sera accepté par un administrateur</p>
    </section>
    {/if}
    <section class="signup-container">
        <h2 class="signup-title">Enregistrez vous</h2>
        {if isset ($errMsg)}
        <p  class="signup-err" aria-live="assertive">{$errMsg}</p>
        {/if}
        <form class='form-signup' method="post" action="/signup">
            <label htmlFor="firstname" class='form-signup-label'>Prénom :
                <input
                    type="text"
                    class='form-signup-input'
                    id="firstname"
                    name="firstname"
                    autoComplete="off"
                    placeholder="prénom"
                    required />
            </label>
            <label htmlFor="lastname" class='form-signup-label'>Nom :
                <input
                    type="text"
                    class='form-signup-input'
                    id="lastanme"
                    name="lastname"
                    autoComplete='off'
                    placeholder="nom"
                    required />
            </label>
            <label htmlFor="email" class='form-signup-label'>Adresse mail :
                <input
                    type="text"
                    class='form-signup-input'
                    id="email"
                    name="email"
                    autoComplete='off'
                    placeholder="email"
                    required />
            </label>
            <label htmlFor="login" class='form-signup-label'>
                <span>Login :
                    <svg id="badLogin" class="signup-hide" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 352 512"  height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path>
                    </svg> 
                    <svg id="checkLogin" class="signup-hide" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"  height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path>
                    </svg>
                </span>
                <input
                    type="text"
                    class='form-signup-input'
                    id="login"
                    name="login"
                    autoComplete='off'
                    placeholder="login"
                    aria-describedby="uidnote">
            </label>
            <p id="uidnote" class="signup-err-off">
            <FaInfoCircle/> Doit être de 4 à 24 caractères, doit commencer par une lettre.<br />
                Lettres, nombres underscore et tirets sont autorisés.
            </p>
            <label htmlFor="password1" class='form-signup-label'><span>Mot de passe
                <svg id="badPass1" stroke="currentColor" class="signup-hide" fill="currentColor" stroke-width="0" viewBox="0 0 352 512"  height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path>
                </svg> 
                <svg id="checkPass1"  class="signup-hide" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path>
                </svg>
                <input
                    type="password"
                    class='form-signup-input'
                    placeholder='Mot de passe'
                    id="password1"
                    name="password"
                    required />
            </label>
            <p id="pwdnote" class="signup-err-off">
                Doit être de 8 à 24 caractères, Doit inclure une majuscule, un chiffre et un caractère spécial.<br />
                Sont autorisés : <span aria-label="exclamation mark">!</span> <span aria-label="at symbol">@</span> <span aria-label="hashtag">#</span> <span aria-label="dollar sign">$</span><span aria-label="percent">%</span>
            </p>
            <label htmlFor="password2" class='form-signup-label'><span>Mot de passe (vérification) :
                <svg id="checkPass2" class="signup-hide" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"  height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path>
                </svg>
                <svg id="badPass2" class="signup-hide" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 352 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path>
                </svg> 
                <input
                    type="password"
                    class='form-signup-input'
                    placeholder='Vérification'
                    id="password2"
                    required />
            </label>
            <button id="submitButton" class="form-signup-btn" disabled>Valider</button>
        </form>
        <p class='signup-info'>Vous avez déjà un compte ? <a herf='/login'>Connectez vous !</a></p>
    </section>
{/block}