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
    <Welcome />
</nav>