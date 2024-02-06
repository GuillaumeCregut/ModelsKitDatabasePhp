<div>
    {if isset($connected)}
    <div class="user-rate-container">
        <p>Votre note :</p>
        <div class="rating-stars">
            <input type="radio" class="radio-rating " name="rating-{$id}" id="rs-{$id}-0" checked><label
                class="label-rating star-hidden" for="rs-{$id}-0"></label>
            <input type="radio" class="radio-rating" data-id="{$id}" data-value="1" {if $rating==1}checked {/if}
                name="rating-{$id}" id="rs-{$id}-1"><label class="label-rating" for="rs-{$id}-1"></label>
            <input type="radio" class="radio-rating" data-id="{$id}" data-value="2" {if $rating==2}checked {/if}
                name="rating-{$id}" id="rs-{$id}-2"><label class="label-rating" for="rs-{$id}-2"></label>
            <input type="radio" class="radio-rating" data-id="{$id}" data-value="3" {if $rating==3}checked {/if}
                name="rating-{$id}" id="rs-{$id}-3"><label class="label-rating" for="rs-{$id}-3"></label>
            <input type="radio" class="radio-rating" data-id="{$id}" data-value="4" {if $rating==4}checked {/if}
                name="rating-{$id}" id="rs-{$id}-4"><label class="label-rating" for="rs-{$id}-4"></label>
            <input type="radio" class="radio-rating" data-id="{$id}" data-value="5" {if $rating==5}checked {/if}
                name="rating-{$id}" id="rs-{$id}-5"><label class="label-rating" for="rs-{$id}-5"></label>
        </div>
    </div>
    {/if}
    <div>
        Note globale : <span id="global-{$id}">{$globalrate}</span>/5
    </div>
</div>