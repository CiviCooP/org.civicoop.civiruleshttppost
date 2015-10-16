
<h3>{if $action eq 1}{ts}New Twitter account{/ts}{elseif $action eq 2}{ts}Edit Twitter account{/ts}{else}{ts}Delete Twitter account{/ts}{/if}</h3>

<div class="crm-block crm-form-block crm-twitter-account-form-block">
    {if $action eq 8}
        <div class="">
            <div class="icon inform-icon"></div>
            {ts}Deleting a twitter account cannot be undone.{/ts} {ts}Do you want to continue?{/ts}
        </div>
        <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="bottom"}</div>
    {else}
        <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="top"}</div>

        <div class="crm-section">
            <div class="label">{$form.twitter_name.label}</div>
            <div class="content">@{$form.twitter_name.html}</div>
            <div class="clear"></div>
        </div>

        <div class="crm-section">
            <div class="label">{$form.description.label}</div>
            <div class="content">{$form.description.html}</div>
            <div class="clear"></div>
        </div>

        <div class="crm-section">
            <div class="label">{$form.consumer_key.label}</div>
            <div class="content">{$form.consumer_key.html}</div>
            <div class="clear"></div>
        </div>

        <div class="crm-section">
            <div class="label">{$form.consumer_secret.label}</div>
            <div class="content">{$form.consumer_secret.html}</div>
            <div class="clear"></div>
        </div>

        <div class="crm-section">
            <div class="label">{$form.access_token.label}</div>
            <div class="content">{$form.access_token.html}</div>
            <div class="clear"></div>
        </div>

        <div class="crm-section">
            <div class="label">{$form.access_secret.label}</div>
            <div class="content">{$form.access_secret.html}</div>
            <div class="clear"></div>
        </div>


        <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="bottom"}</div>
    {/if}
</div>
