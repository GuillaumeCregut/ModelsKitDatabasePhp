{extends file="_base.tpl"}
{block name=styles}
<link rel="stylesheet" href="assets/styles/recover.css">
{/block}
{block name=script}
<script src="assets/scripts/recover.js" defer></script>
{/block}
{block name=body}
{include file='partials/_navbar.tpl'}
<div class='home-container'>
<h2>Changer de mot de passe</h2>
<form action="recover" method="post" class='form-signup'>
    <input type="hidden" name="action" value="change">
    <label for="email">Email : 
        <input type="text" name="email" id="email" placeholder="email" class="form-signup-input" autocomplete="off" required>
    </label>
    <label for="password1" class='form-signup-label'><span>Nouveau mot de passe
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
    <label for="password2" class='form-signup-label'><span>Mot de passe (vérification) :
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
    <label for="code">Code de vérification : 
        <input type="text" name="code" id="code" placeholder="Code reçu" class="form-signup-input" autocomplete="off" required>
    </label>

    <button id="submitButton" class="form-signup-btn" disabled>Valider</button>
</form>
</div>
{/block}