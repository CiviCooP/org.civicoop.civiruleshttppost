<h3>{$ruleActionHeader}</h3>
<div class="crm-block crm-form-block crm-civirule-rule_action-block-group-contact">

    <div class="crm-section">
        <div class="label">{$form.twitter_account.label}</div>
        <div class="content">
            {$form.twitter_account.html}
            &nbsp;&nbsp;<a href="{crmURL p='civicrm/admin/twitter_account' q='?reset=1' }">{ts}Manage twitter accounts{/ts}</a>
        </div>
        <div class="clear"></div>
    </div>
    <div class="crm-section">
        <div class="label">{$form.text_message.label}</div>
        <div class="content">
            {$form.text_message.html}
            <p class="description">{ts}You can use contact tokens{/ts}</p>
            <p class="description"><span id='char-count-message'></span></p>
        </div>
        <div class="clear"></div>
    </div>

    <div class="crm-submit-buttons">
        {include file="CRM/common/formButtons.tpl" location="bottom"}
    </div>
</div>

<script type="text/javascript">
    {literal}
    maxCharInfoDisplay();

    cj(function() {
        cj('#text_message').bind({
            keyup: function () {
                maxCharInfoDisplay();
            }
        });
    });

    function maxCharInfoDisplay(){
        var maxLength = 140;
        var enteredCharLength = cj('#text_message').val().length;
        var count = maxLength - enteredCharLength;

        cj('#char-count-message').text( "You can insert upto " + count + " characters" );
    }
    {/literal}
</script>
