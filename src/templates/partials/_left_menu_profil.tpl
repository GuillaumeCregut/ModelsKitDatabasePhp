    <div class="left-menu">
        <ul class="left-links-container">
            <li class="link-param-item"><a href="profil_info" class="nav-item {if isset($info_menu)}active{/if}">Mes informations</a></li>
            <li class="link-param-item"><a href="profil_fournisseurs" class="nav-item {if isset($provider_menu)}active{/if}">Mes fournisseurs</a></li>
            <li class="link-param-item"><a href="profil_commandes" class="nav-item {if isset($bills_menu)}active{/if}">Mes commandes</a></li>
            <li class="link-param-item"><a href="profil_stats" class="nav-item {if isset($stats_menu)}active{/if}">Statistiques</a></li>
            <li class="link-param-item"><a href="profil_statpdf" class="nav-item {if isset($pdf_menu)}active{/if}">Statistiques en pdf</a></li>
            <li class="link-param-item"><a href="profil_statexport" class="nav-item {if isset($csv_menu)}active{/if}">Exporter en CSV</a></li>
            <li class="link-param-item"><a href="profil_social" class="nav-item {if isset($social_menu)}active{/if}">Réseau social</a></li>
        </ul>
    </div>