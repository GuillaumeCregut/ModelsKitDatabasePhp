{extends file="_base.tpl"}
{block name=styles}
    <link rel="stylesheet" href="assets/styles/homepage.css">
    <link rel="stylesheet" href="assets/styles/login.css">
{/block}
{block name=body}
    {include file='partials/_navbar.tpl'}
    <div class='home-container'>
        {* begin *}
        <section class='login-container'>
            <h2 class="login-title">Connexion</h2>
            {if isset($errMsg)}
            <p class="login-error-msg" aria-live="assertive">{$errMsg} </p>
            {/if}
            <form class='login-form' method="post" action="/login">
                <label htmlFor="login" class="login-label">
                    <input
                        type="text"
                        class="input-login-form"
                        placeholder='login'
                        id="login"
                        name="login"
                        required
                        autoComplete='off'
                    />
                </label>
                <label htmlFor="password" class="login-label">
                    <span class="login-pwd">
                        <input
                            type= "password"
                            name="password"
                            class="input-login-form"
                            placeholder='Mot de passe'
                            id="password"
                            required
                        />
                    </span>
                </label>
                <button type="submit" class="login-btn-container">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="login-btn" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0z"></path><path d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-8v2h8v14z"></path></svg>
                </button>
            </form>
            
            <p class="login-footer">
                Pas encore de compte ? <a href='/signup'>Inscrivez-vous</a>
            </p>
        </section>
        {* end *}
    </div>
{/block}