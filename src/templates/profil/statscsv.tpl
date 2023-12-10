{extends file="../_profil_template.tpl"}
{block name=title}Models Kit Database - Statistiques{/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/profil_general.css">
<link rel="stylesheet" href="assets/styles/profil/stats.css">
<link rel="stylesheet" href="assets/styles/profil/csv.css">
{/block}
{block name=script}{/block}
{block name=innerMenu}
<div class="main-profil-container">
    <h2>Statistiques - Export CSV</h2>
    <p>L’export en CSV permet de récupérer les informations dans un tableur de type Excel.<br>
        Les éléments exportés seront : Le nom du kit et la marque, l’échelle, la référence, la catégorie la position
        dans votre stock.<br>
        Les éléments seront organisés par états sélectionnés.</p>
    <form action="profil_statexport" method="post">
        <fieldset class="fieldset">
            <legend>Tri</legend>
            <div class="container-field">
                <label for="separator" class="label-order">Choix du séparateur :
                    <select name="separator" id="separator" class="select-export">
                        <option value="1">Virgule (,)</option>
                        <option value="2">Point virgule (;)</option>
                    </select>
                </label>
                <label for="order" class="label-order">Trier par :
                    <select name="order" id="order" class="select-export">
                        <option value="1">Marque</option>
                        <option value="2">Constructeur</option>
                        <option value="3">Echelle</option>
                        <option value="4">Catégorie</option>
                        <option value="5">Pays</option>
                        <option value="6">Période</option>
                    </select>
                </label>
            </div>
        </fieldset>
        <fieldset class="fieldset">
            <legend>Eléments à inclure</legend>
            <div class="container-field">
                <label for="cb_like"><input type="checkbox" name="cb_like" id="cb_like" checked
                        class="check-include">Modèles en favoris</label>
                <label for="cb_order"><input type="checkbox" name="cb_order" id="cb_order" checked
                        class="check-include">Modèles commandés</label>
                <label for="cb_stock"><input type="checkbox" name="cb_stock" id="cb_stock" checked
                        class="check-include">Modèles en stock</label>
                <label for="cb_wip"><input type="checkbox" name="cb_wip" id="cb_wip" checked
                        class="check-include">Modèles
                    en cours</label>
                <label for="cb_finished"><input type="checkbox" name="cb_finished" id="cb_finished" checked
                        class="check-include">Modèles terminés</label>
            </div>
        </fieldset>
        <input type="submit" value="Exporter" class="export-btn">
    </form>
</div>
{/block}