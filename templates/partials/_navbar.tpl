<nav class="navbar-container">
    <div class="navlink-container">
        <input type="checkbox" class="toggle-btn"></input>
        <div class="burger-menu"></div>
       
        <ul class="menu">
            <li><a href="#"class="main-font-20 {if isset($accueil)}active{/if} ">Accueil</a></li>
            <li><a href="#"class="main-font-20 {if isset($params)}active{/if}">Paramètres</a></li>
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
        <a href="#"><span  class="material-icons md-48 welcome-lock">lock</span></a>
        {/if}
    </div>
</nav>