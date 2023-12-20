{extends file="../_profil_template.tpl"}
{block name=title}Models Kit Database - Profil{/block}
{block name=styles}
<link rel="stylesheet" href="assets/styles/profil_general.css">
<link rel="stylesheet" href="assets/styles/profil/friendbuild.css">
{/block}
{block name=script}
<script src="assets/scripts/friendhome.js" defer></script>
{/block}
{block name=innerMenu}
<div class="main-profil-container">
    <h2>Détails du montage</h2>
    <p class="back-link">
        <a href="profil_ami?id={$friend}">Retour</a>
    </p>
    <div class="details-friend-kit">
        <img src="{if $model->boxPicture!=null ||$model->boxPicture!=''}{$model->boxPicture}{else}assets/uploads/models/no_image.jpg{/if}"
            alt="" class="img-box-detail">
        <p>{$model->builderName} {$model->modelName}</p>
        <p>{$model->brandName} {$model->reference} {$model->scaleName}</p>
    </div>
    <p class="title-friend-pictures">Photos du montage :</p>
    <div>
        {if isset($pictures)}
        <ul class="picture-model-container">
            {foreach from=$pictures item=$picture}
            <li>
                <img src="{$picture}" alt="photo du montage" class="img-built-model">
            </li>
            {/foreach}
        </ul>
        {else}
        <p>Il n'y a pas d'images</p>
        {/if}
    </div>
    {if isset($allow)}
    <div class="message-zone-model">
        <form action="" method="post">
            <section class="new-model-message">
                <p>Laisser un message :</p>
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="id" value="{$model->id}">
                <input type="hidden" name="friend" value="{$friend}">
                <textarea name="message" id="" cols="30" rows="10" required class="input-message"
                    placeholder="Votre message"></textarea>
                <button class="btn-send-model-message">Envoyer</button>
            </section>
            messages :
            <section class="message-model-container">
                {if isset($messages)}
                {foreach from=$messages item=message}
                <div class="friend-build-message-container">
                    <div className="friend-identity-message-container">
                        <div class="avatar-container">
                            {if $message.message->avatar==null||$message->avatar==''}
                            {$message.message->firstname|truncate:1:""|upper}{$message.message->lastname|truncate:1:""|upper}
                            {else}
                            <img src="assets/uploads/users/{$message.message->userId}/{$message.message->avatar}"
                                alt="{$message.message->avatar}" class="avatar-img">
                            {/if}
                        </div>
                        <div class="right-identity-message">
                            <p>{$message.message->firstname} {$message.message->lastname}</p>
                            <p>le : {$message.message->dateMessage}</p>
                        </div>
                    </div>
                    <article>{$message.message->message|nl2br}</article>
                    <section class="reponse-msg">
                        {foreach from=$message.replies item=reply}
                        <article style="background-color: red; margin-bottom: 5px;">
                            <div>
                                <div class="avatar-container">
                                    {if $reply->avatar==null || $reply->avatar==''}
                                    {$reply->firstname|truncate:1:""|upper}{$reply->lastname|truncate:1:""|upper}
                                    {else}
                                    <img src="assets/uploads/users/{$reply->userId}/{$reply->avatar}"
                                        alt="{$reply->avatar}" class="avatar-img"><br>
                                    {/if}
                                </div>
                                <p>{$reply->firstname} {$reply->lastname}</p>
                                <p>{$reply->dateMessage}</p>
                            </div>
                            <div class="message-reply">
                                {$reply->message}
                            </div>
                        </article>
                        {/foreach}
                    </section>
                </div>
                {/foreach}
                {else}
                <p>Il n'y a pas de messages encore.</p>
                {/if}
            </section>
        </form>
    </div>
    {/if}
</div>
{/block}