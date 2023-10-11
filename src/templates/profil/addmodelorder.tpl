<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/profil/addmodel.css">
    <script src="assets/scripts/addmodelorder.js" defer></script>
    <title>Ajouter un modèle</title>
</head>
<body>
    <div class="models-lists-container">
        <div class="favorites box-models">
            <h2>Liste des modèles favoris</h2>
            <div class="favorites-container">
                toto
            </div>
        </div>
        <div class="others-models box-models">
            <h2>Liste des modèles</h2>
            <form action="profil_model" method="get" class="form-search">
                <label for="filter-text" class="filter-label">Filtre : 
                    <input type="text" name="name" id="filter-text" class="filter-text" autocomplete="off">
                </label>
                <button type="submit" class="search-button">
                    <svg 
                    stroke="currentColor" 
                    class="search-icon"
                    fill="currentColor" 
                    stroke-width="0" 
                    viewBox="0 0 24 24" 
                    height="1em" 
                    width="1em" 
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill="none" d="M0 0h24v24H0V0z"></path>
                    <path d="M7 9H2V7h5v2zm0 3H2v2h5v-2zm13.59 7l-3.83-3.83c-.8.52-1.74.83-2.76.83-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5c0 1.02-.31 1.96-.83 2.75L22 17.59 20.59 19zM17 11c0-1.65-1.35-3-3-3s-3 1.35-3 3 1.35 3 3 3 3-1.35 3-3zM2 19h10v-2H2v2z"></path>
                    </svg>
                </button>
            </form>
            <div class="others-models-container">
                titi
            </div>
        </div>
    </div>
    <div class="info-container">
        <label for="price" class="info-label">Prix : 
            <input type="text" name="price" id="price" class="filter-text" autocomplete="off">euros
        </label>
        <label for="qtty" class="info-label">Quantité : 
            <input type="number" name="qtty" id="qtty" class="filter-text">
        </label>
        <button class="search-button">
            <svg 
            stroke="currentColor" 
            fill="currentColor" 
            stroke-width="0" 
            viewBox="0 0 24 24" 
            class="search-icon" 
            height="1em" 
            width="1em" 
            xmlns="http://www.w3.org/2000/svg">
                <path fill="none" d="M0 0h24v24H0z"></path>
                <path d="M18 13c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zm3 5.5h-2.5V21h-1v-2.5H15v-1h2.5V15h1v2.5H21v1zM7 5h13v2H7z"></path>
                <circle cx="3.5" cy="18" r="1.5"></circle>
                <path d="M18 11H7v2h6.11c1.26-1.24 2.99-2 4.89-2zM7 17v2h4.08c-.05-.33-.08-.66-.08-1s.03-.67.08-1H7z"></path>
                <circle cx="3.5" cy="6" r="1.5"></circle>
                <circle cx="3.5" cy="12" r="1.5"></circle>
            </svg>
        </button>
    </div>
</body>
</html>