{extends file="_base.tpl"}
{block name=styles}
<link rel="stylesheet" href="assets/styles/homepage.css">
{/block}
{block name=body}
{include file='partials/_navbar.tpl'}
<div class='home-container'>
    <main class='home-section'>
      <h1 class="home-title">Models Kit Database</h1>
      <section class='hero-section'>
        <img src="assets/pictures/home-hero.png" alt="home hero" class='hero-picture'/>
        <p class="hero-text">
          Notre solution simple et intuitive vous facilitera la gestion de votre stock de maquettes.<br />
          Laissez votre création s'envoler, Models kit database vous permettra de connaitre à tout moment l'état de votre stock, planifier vos achats et vous garderez une trace de vos investissements.<br />
          Vous pourrez stocker les photos de vos montages terminés afin de les partager au sein de la communauté.<br />
          Rejoignez nous dès maintenant pour profiter de l'expérience.
        </p>
      </section>
    </main>
    <section class="screen-container">
        <article class="sreen-app">
          <section class="step-item">
            <div class="text-item">
              Notre système vous propose de gérer une liste de kits partagée, à partir de laquelle vous pouvez gérer votre propre stock.<br />
              Sur la page paramètre, vous pouvez visualiser et gérer les différents éléments nécessaire à la création d'un kit, par exemple les constructeurs
            </div>
            <div class="picture-item">
              <img src="assets/pictures/homepage/constructeurs.png" alt="paramètres" class="screen-picture" />
            </div>
          </section> 
          <section class="step-item">
            <div class="text-item">
              La liste des modèles proposés est créée par les utilisateurs. Un kit est manquant ? Rajouter le simplement !
            </div>
            <div class="picture-item">
              <img src="assets/pictures/homepage/modeles.png" alt="modèles" class="screen-picture" />
            </div>
          </section>
          <section class="step-item">
            <div class="text-item">
              Bien évidemment, vous pouvez modifier vos informations personnelles à tout moment. Sur la page mon profil, vous pouvez visualiser ces informations et les modifier à tout moment.
            </div>
            <div class="picture-item">
              <img src="assets/pictures/homepage/profil.png" alt="profil" class="screen-picture" />
            </div>
          </section>
          <section class="step-item">
            <div class="text-item">
              Vous pouvez gérer vos fournisseurs habituels, simplement. Ces informations vous permettrons de pouvoir gérer un suivi d'achat.
            </div>
            <div class="picture-item">
              <img src="assets/pictures/homepage/fournisseurs.png" alt="fournisseurs" class="screen-picture" />
            </div>
          </section>
          <section class="step-item">
            <div class="text-item">
              Vous achetez un nouveau kit, voir une liste de kits ? Saisissez la commande dans le logiciel, vous garderez une trace de l'achat.
            </div>
            <div class="picture-item">
              <img src="assets/pictures/homepage/commande.png" alt="commandes" class="screen-picture" />
            </div>
          </section>
          <section class="step-item">
            <div class="text-item">
              Vous pouvez consulter vos statistiques.
            </div>
            <div class="picture-item">
              <img src="assets/pictures/homepage/statistiques.png" alt="statistiques" class="screen-picture" />
            </div>
          </section>
          <section class="step-item">
            <div class="text-item">
              Ces statistiques et d'autres, comme l'état de votre stock, peuvent être regroupées dans un livet pdf généré automatiquement et en direct.
            </div>
            <div class="picture-item">
              <img src="assets/pictures/homepage/pdf.png" alt="pdf" class="screen-picture" />
            </div>
          </section>

          <section class="step-item">
            <div class="text-item">
              Nouveauté 1.2 : Les relations utilisateurs. Retrouver vos amis afin de pouvoir echanger des messages, consulter leurs montages...
            </div>
            <div class="picture-item">
              <img src="assets/pictures/homepage/social.png" alt="social" class="screen-picture" />
            </div>
          </section>
          <section class="step-item">
            <div class="text-item">
              Nouveauté 1.2 : Les relations utilisateurs. Maintenant, vous pouvez échanger des messages avec vos amis.
            </div>
            <div class="picture-item">
              <img src="assets/pictures/homepage/messages.png" alt="messages" class="screen-picture" />
            </div>
          </section>
          <section class="step-item">
            <div class="text-item">
              Vous pouvez admirer les réalisations de vos amis.
            </div>
            <div class="picture-item">
              <img src="assets/pictures/homepage/friend-finished.png" alt="kits mais" class="screen-picture" />
            </div>
          </section>
          <section class="step-item">
            <div class="text-item">
              Et leur laisser un message si leur montage vous plait.
            </div>
            <div class="picture-item">
              <img src="assets/pictures/homepage/friend-finished-details.png" alt="kits mais" class="screen-picture" />
            </div>
          </section>
          <section class="step-item">
            <div class="text-item">
              Enfin, sur la page de gestion de kit, vous pouvez gérer votre stock, simplement en faisant glisser vos kits dans la case qui correspond.
            </div>
            <div class="picture-item">
              <img src="assets/pictures/homepage/gestion.png" alt="gestion stock" class="screen-picture" />
            </div>
          </section>
          <section class="step-item">
            <div class="text-item">
              Lorsqu'un kit est terminé, vous pouvez rajouter jusqu'à 4 photos du kit fini. Vous pouvez aussi voir les messages laisser par vos amis.
            </div>
            <div class="picture-item">
              <img src="assets/pictures/homepage/message-finished.png" alt="modèles terminés" class="screen-picture" />
            </div>
          </section>
          <section class="step-item">
            <div class="text-item">
              Si vous manquez d'inspiration pour commencer un nouveau kit, laisserz l'application vous proposer un kit au hasard dans votre stock.<br />
              Si le kit vous convient, un simple clic vous le mets en mode établi.
            </div>
            <div class="picture-item">
              <img src="assets/pictures/homepage/generateur.png" alt="générateur aléatoire" class="screen-picture" />
            </div>
          </section>

          <section class="step-item">
            <div class="text-item">Vous souhaitez nous rejoindre ?<br />D'abord, enregistrez vous. Aucune information personnelle n'est utilisée à des fins extérieures</div>
            <div class="picture-item">
              <img src="assets/pictures/homepage/signup.png" alt="sign up" class="screen-picture" />
            </div>
          </section>
          <section class="step-item">
            <div class="text-item">
              Ensuite, sur la page login, vous pouvez vous connecter.
            </div>
            <div class="picture-item">
              <img src="assets/pictures/homepage/login.png" alt="login" class="screen-picture" />
            </div>
          </section>
        </article>
      </section>
  </div>
{/block}