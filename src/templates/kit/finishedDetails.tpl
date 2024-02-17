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
        <div class="delete-kit">
            <form action="kit_finishedDetails?id={$model->id}" method="post" id="deleteKitForm">
                <input type="hidden" name="action" value="removeKit">
                <input type="hidden" name="token" value="{$token}" id="token">
                <input type="hidden" name="id" value="{$model->id}">
            </form>
            <button type="button" class="remove-kit-btn" id="delete-kit-btn">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512"
                class="remove-kit-icon" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z">
                </path>
            </svg></button>
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
    <form action="kit_finishedDetails?id={$model->id}" method="post" id="delete-picture-form">
        <input type="hidden" name="action" value="deletePicture">
        <input type="hidden" name="token" value="{$token}">
        <input type="hidden" name="id" value="{$model->id}">
        <input type="hidden" name="file" value="" id="filename-delete">
    </form>
    <div class="picturebox">
        {if isset($pictures)}
        <ul class="picture-container">
            {foreach from=$pictures item=picture}
            <li>
                <div>
                    <div class="image-container" data-file="{$picture}">
                        <img src="{$picture}" alt="photo" class="img-model">
                    </div>

                </div>
                <button class="btn-delete-picture" data-file="{$picture}">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512"
                        class="trash-delete-icon" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z">
                        </path>
                    </svg>
                </button>
            </li>
            {/foreach}
        </ul>
        {else}
        <ul class="picture-container hidden"> </ul>
        <p id="no-photo">Il n'y a pas de photos</p>
        {/if}
    </div>
    {if $countPicture<=4} <input type="hidden" id="count-files" value="{$countPicture}">
        <input type="hidden" id="id_add" value="{$model->id}">
        <div class="file-uploader">
            <section class="file-upload-container">
                <label for="" class="input-label">Téléchargement</label>
                <p class="drag-drop-text">Glisser ici vos fichiers ou</p>
                <button class="upload-file-btn">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 384 512"
                        class="upload-icon" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M224 136V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zm65.18 216.01H224v80c0 8.84-7.16 16-16 16h-32c-8.84 0-16-7.16-16-16v-80H94.82c-14.28 0-21.41-17.29-11.27-27.36l96.42-95.7c6.65-6.61 17.39-6.61 24.04 0l96.42 95.7c10.15 10.07 3.03 27.36-11.25 27.36zM377 105L279.1 7c-4.5-4.5-10.6-7-17-7H256v128h128v-6.1c0-6.3-2.5-12.4-7-16.9z">
                        </path>
                    </svg>
                    <span class="btn-title">Téléchargez vos fichiers</span>
                </button>
                <input type="file" name="filesPictures" id="files-field" class="form-field"
                    accept="image/png,image/jpeg" multiple>
            </section>
            <article class="file-preview-container">
                <span>A télécharger</span>
                <section class="preview-list"></section>
                <button id="UpLoadBtn" class="hidden-btn classic-btn">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 384 512"
                        class="upload-icon-launch" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M224 136V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zm65.18 216.01H224v80c0 8.84-7.16 16-16 16h-32c-8.84 0-16-7.16-16-16v-80H94.82c-14.28 0-21.41-17.29-11.27-27.36l96.42-95.7c6.65-6.61 17.39-6.61 24.04 0l96.42 95.7c10.15 10.07 3.03 27.36-11.25 27.36zM377 105L279.1 7c-4.5-4.5-10.6-7-17-7H256v128h128v-6.1c0-6.3-2.5-12.4-7-16.9z">
                        </path>
                    </svg>
                    Télécharger
                </button>
            </article>
        </div>
        {/if}
        {if isset($messages)}
        <section>
            <h3 class="kit-detail-message">Messages</h3>
            <div class="kit-details-messages-container">
                {foreach from=$messages item=message}
                <div class="friend-build-message-container">
                    <div class="friend-identity-message-container">
                        <div class="avatar">
                            {if $message.message->avatar=='' || $message.message->avatar==null}
                            {$message.message->firstname|truncate:1:""|upper}{$message.message->lastname|truncate:1:""|upper}
                            {else}
                            <img src="{$message.message->avatar}" alt="{$message.message->firstname}"
                                class="avatar-img">
                            {/if}
                        </div>
                        <div class="right-identity-message">
                            <p>{$message.message->firstname} {$message.message->lastname}</p>
                            <p>Le : {$message.message->dateMessage}</p>
                        </div>
                    </div>
                    <article>
                        {$message.message->message}
                    </article>
                    <section class="reply-container">
                        {foreach from=$message.replies item=reply}
                        <article class="friend-build-message-container-reply">
                            <div class="friend-identity-message-container-reply">
                                <div class="identity-reply">
                                    <div class="avatar">
                                        {if $reply->avatar=='' || $reply->avatar==null}
                                        {$reply->firstname|truncate:1:""|upper}{$reply->lastname|truncate:1:""|upper}
                                        {else}
                                        <img src="{$reply->avatar}" alt="{$reply->firstname}" class="avatar-img">
                                        {/if}
                                    </div>
                                    <div class="right-identity-message-reply">
                                        <p>{$reply->firstname} {$reply->lastname}</p>
                                        <p>Le : {$reply->dateMessage}</p>
                                    </div>
                                </div>
                                <article class="message-reply">
                                    {$reply->message}
                                </article>
                        </article>
                        {/foreach}
                    </section>
                    <button data-id="msg-{$message.message->id}" class="btn-response">Répondre au message</button>
                    <div id="msg-{$message.message->id}" class="answer-container">
                        <form action="kit_finishedDetails?id={$model->id}" method="post">
                            <input type="hidden" name="action" value="reply">
                            <input type="hidden" name="token" value="{$token}">
                            <input type="hidden" name="messageId" value="{$message.message->id}">
                            <label for="response{$message.message->id}">Votre réponse : </label>
                            <textarea name="response" id="response{$message.message->id}" cols="30"
                                rows="10" class="answer-text"></textarea>
                            <button type="submit">Répondre</button>
                        </form>
                    </div>
                </div>
                {/foreach}
            </div>
        </section>
        {/if}
</div>
<div class="zoom-image hidden" id="zoom-container">
    <div class="zoom-in-div">
        <img src="" alt="photo" id="zoom-picture">
        <button class="close-zoom" id="close-zoom">X</button>
    </div>
</div>
{/block}