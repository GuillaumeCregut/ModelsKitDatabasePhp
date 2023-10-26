<nav class="navbar-container">
    <div class="navlink-container">
        <input type="checkbox" class="toggle-btn">
        <div class="burger-menu"></div>
       
        <ul class="menu">
            <li><a href="/" class="main-font-20 {if isset($accueil)}active{/if} ">Accueil</a></li>
            <li><a href="parametres" class="main-font-20 {if isset($params)}active{/if}">Paramètres</a></li>
            <li><a href="profil" class="main-font-20 {if isset($profil)}active{/if}">Mon profil</a></li>
            <li><a href="kit" class="main-font-20 {if isset($kits)}active{/if}">Mes kits</a></li>
            {if isset($loggedInAdmin)}
            <li><a href="admin" class="main-font-20  {if isset($admin)}active{/if}">Admin</a></li>
            {/if}
        </ul>
    </div>
    <div class='welcome' id="welcome">
        {if isset($logged_in)}
            <p><span class="welcome-name">{$fullname}</span> 
            <a href="/logout"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 20 20" aria-hidden="true" class="welcome-unlock" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2H7V7a3 3 0 015.905-.75 1 1 0 001.937-.5A5.002 5.002 0 0010 2z"></path></svg></a> </p>
        {else}
        <a href="/login"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 20 20" aria-hidden="true" class="welcome-lock" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg></a>
        {/if}
    </div>
</nav>