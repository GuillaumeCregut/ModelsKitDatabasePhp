{extends file="_base.tpl"}
{block name=styles}
<link rel="stylesheet" href="assets/styles/forgot.css">
{/block}
{block name=body}
{include file='partials/_navbar.tpl'}
  <div class='home-container'>
    <h1>Récupération du mot de passe</h1>
    <p>Veuillez saisir votre adresse mail, un lien de réinitialisation du mot de passe vous sera envoyé.</p>
    <form action="forgot" method="post">
      <input type="hidden" name="action" value="sendmail">
      <label for="email">Entrer votre adresse mail : 
        <input type="email" name="email" id="email" required autoComplete='off'>
      </label>
      <button class="btn">
        <svg 
        stroke="currentColor" 
        fill="currentColor" 
        stroke-width="0" 
        viewBox="0 0 24 24" 
        class="mail-icon" 
        height="1em" 
        width="1em" 
        xmlns="http://www.w3.org/2000/svg">
          <path fill="none" d="M0 0h24v24H0V0z"></path>
          <path d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6zm-2 0l-8 5-8-5h16zm0 12H4V8l8 5 8-5v10z"></path>
        </svg>
        Envoyer</button>
    </form>
  </div>
{/block}