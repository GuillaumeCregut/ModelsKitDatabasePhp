{extends file="../_kit_template.tpl"}
{block name=title}Models Kit Database - Détails{/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/kit_general.css">
<link rel="stylesheet" href="assets/styles/kit/finisheddetails.css">
{/block}
{block name=script}
<script src="assets/scripts/finishedDetails.js" defer></script>
{/block}
{block name=innerMenu}
    <div class="main-kit-container">
        <div class="details-zone">
            <div class="details-kit">
                <h3>{$model->builderName} {$model->modelName}</h3>
                <p>Période : {$model->periodName}</p>
                <p>Catégorie: {$model->categoryName}</p>
                <p>{$model->brandName} - {$model->scaleName} - {$model->reference}</p>
            </div>
            <div>
                <p>
                    <img src="{$model->picture}" alt="{$model->modelName}" class="detail-img">
                </p>
                {if $model->price!=null && $model->providerName!=null}
                <div class="detail-order">
                    <p>Fournisseur : {$model->providerName}</p>
                    <p>Prix d'achat : {$model->price} euros</p>
                </div>
                {/if}
            </div>
        </div>
        <div class="picturebox">
            <ul class="picture-container">
                <li>
                    <div>
                        <div class="image-container">
                            <img src="" alt="" class="img-model">
                        </div>
                        <div class="zoom-image"></div>
                    </div>
                    <button class="btn-delete-picture">
                        <svg 
                        stroke="currentColor" 
                        fill="currentColor" 
                        stroke-width="0" 
                        viewBox="0 0 448 512" 
                        class="trash-delete-icon" 
                        height="1em" 
                        width="1em" 
                        xmlns="http://www.w3.org/2000/svg">
                            <path d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path>
                        </svg>
                    </button>
                </li>
            </ul>
        </div>
        <div class="file-uploader">
            <section class="file-upload-container">
                <label for="" class="input-label">Téléchargement</label>
                <p class="drag-drop-text">Glisser ici vos fichiers ou</p>
                <button class="upload-file-btn">
                    <svg 
                    stroke="currentColor" 
                    fill="currentColor" 
                    stroke-width="0" 
                    viewBox="0 0 384 512" 
                    class="upload-icon" 
                    height="1em" 
                    width="1em" 
                    xmlns="http://www.w3.org/2000/svg">
                        <path d="M224 136V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zm65.18 216.01H224v80c0 8.84-7.16 16-16 16h-32c-8.84 0-16-7.16-16-16v-80H94.82c-14.28 0-21.41-17.29-11.27-27.36l96.42-95.7c6.65-6.61 17.39-6.61 24.04 0l96.42 95.7c10.15 10.07 3.03 27.36-11.25 27.36zM377 105L279.1 7c-4.5-4.5-10.6-7-17-7H256v128h128v-6.1c0-6.3-2.5-12.4-7-16.9z"></path>
                    </svg>
                    <span class="btn-title">Téléchargez vos fichiers</span>
                </button>
                <input type="file" name="" id="" class="form-field" accept="image/png,image/jpeg">
            </section>
            <article class="file-preview-container">
                <span>A télécharger</span>
                <section class="preview-list"></section>
            </article>
        </div>
        {if isset($messages)}
        <section>
            <h3 class="kit-detail-message">Messages</h3>
            <div class="kit-details-messages-container">
                <div class="friend-build-message-container">
                    <div class="friend-identity-message-container">
                        <div class="avatar">
                            MM
                        </div>
                        <div class="right-identity-message">
                            <p>Nom Prenom</p>
                            <p>Le : date</p>
                        </div>
                    </div>
                    <article>
                        Message
                    </article>
                </div>
            </div>
        </section>
        {/if}
    </div>
{/block}