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
        <img src="{if $model->boxPicture!=null ||$model->boxPicture!=''}{$model->boxPicture}{else}assets/uploads/models/no_image.jpg{/if}" alt="" class="img-box-detail">
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
                <textarea name="message" id="" cols="30" rows="10" required class="input-message" placeholder="Votre message"></textarea>
                <button class="btn-send-model-message">Envoyer</button>
            </section>
            messages :
            <section class="message-model-container">
                {if isset($messages)}
                {foreach from=$messages item=message}
                <div class="friend-build-message-container">
                    <div className="friend-identity-message-container">
                        <div class="avatar-container">
                            {if $message->avatar==null||$message->avatar==''}
                            {$message->firstname|truncate:1:""|upper}{$message->lastname|truncate:1:""|upper}
                            {else}
                            <img src="assets/uploads/users/{$message->userId}/{$message->avatar}" alt="{$message->avatar}"
                                class="avatar-img">
                            {/if}
                        </div>
                        <div class="right-identity-message">
                            <p>{$message->firstname} {$message->lastname}</p>
                            <p>le : {$message->dateMessage}</p>
                        </div>
                    </div>
                    <article>{$message->message|nl2br}</article>
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