<nav class="navbar-container">
    <div class="navlink-container">
        <input type="checkbox" class="toggle-btn"></input>
        <div class="burger-menu"></div>
       
        <ul class="menu">
            <li><a href="index.php"class="main-font-20 {if isset($accueil)}active{/if} ">Accueil</a></li>
            <li><a href="params.php"class="main-font-20 {if isset($params)}active{/if}">Paramètres</a></li>
            <li><a href="#"class="main-font-20 {if isset($profil)}active{/if}">Mon profil</a></li>
            <li><a href="#"class="main-font-20 {if isset($kits)}active{/if}">Mes kits</a></li>
            {*
            {if $loggedInAdmin}
            <li><a href="#"class="main-font-20  {if isset($admin)}active{/if}">Admin</a></li>
            {/if}
            *}
        </ul>
    </div>
    <div class='welcome' id="welcome">
        {if isset($logged_in)}
            <p><span class="welcome-name">{$firstname} {$lastname}</span> 
            <a href="#"><span  class='welcome-unlock material-icons-outlined'>lock</span></a> </p>
        {else}
        <a href="#"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 20 20" aria-hidden="true" class="welcome-lock" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg></a>
        {/if}
    </div>
</nav>