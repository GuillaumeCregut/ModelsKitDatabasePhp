{extends file="../_params_template.tpl"}
{block name=title}Models Kit Database - Paramètres{/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/params/converter.css">
{/block}
{block name=script}
<script src="assets/scripts/converter.js" defer></script>
{/block}
{block name=innerMenu}
<div class="params-container">
    <h2 class="converter-title">Convertisseur d'échelle</h2>
    <section class="scale-converter">
        <h3 class="title-section">Calculer le taux de conversion entre deux échelles</h3>
        <label for="scale1" class="scale-Label">Echelle 1 :
            <span class="scale-item">1/</span><input type="text" id="scale1" class="scale-input">
        </label> => 
        <label for="scale2" class="scale-Label">Echelle 2 :
            <span class="scale-item">1/</span><input type="text" id="scale2" class="scale-input">
        </label>
        <p><button id="btn-convert" class="btn-convert">Calculer</button></p>
        <p>Résultat : <span class="result-convert" id="result">0</span> %</p>
    </section>
    <section class="scale-converter">
        <h3 class="title-section">Conversion d'une distance entre deux échelles</h3>
        <input type="text" id="distance" class="scale-input"> 
        <select  id="multiplicator" class="select-multiplicator">
            <option value="1">cm</option>
            <option value="100">m</option>
        </select> à l'échelle 
        <label for="scale1-dist" class="scale-Label">
            <span class="scale-item">1/</span><input type="text" id="scale1-dist" class="scale-input">
        </label> donne à 
        <label for="scale2-dist" class="scale-Label">l'échelle 
            <span class="scale-item">1/</span><input type="text" id="scale2-dist" class="scale-input">
        </label>
        <p><button id="btn-calc" class="btn-convert">Calculer</button></p>
        <p>Résultat : <span class="result-convert" id="calc-result">0</span> cm</p>
    </section>
</div>
{/block}
