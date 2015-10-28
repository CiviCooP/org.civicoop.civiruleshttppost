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
            <span class="helpIcon" id="helptext">
                <a href="#" onClick="return showToken('Text', 1);">{$form.token1.label}</a>
                <div id='tokenText' style="display: none">
                    <input  style="border:1px solid #999999;" type="text" id="filter1" size="20" name="filter1" onkeyup="filter(this, 1)"/><br />
                    <span class="description">{ts}Begin typing to filter list of tokens{/ts}</span><br/>
                    {$form.token1.html}
                </div>
            </span>
            <div class="clear">
                {$form.text_message.html}
                <p class="description">{ts}You can use contact tokens{/ts}</p>
                <p class="description"><span id='char-count-message'></span></p>
            </div>
        </div>
        <div class="clear"></div>
    </div>

    <div class="crm-submit-buttons">
        {include file="CRM/common/formButtons.tpl" location="bottom"}
    </div>
</div>


{include file="CRM/Mailing/Form/InsertTokens.tpl"}
<script type="text/javascript">
    {literal}
    maxCharInfoDisplay();

    cj(function() {
        cj('#text_message').bind({
            change: function () {
                maxLengthMessage();
            },
            keyup: function () {
                maxCharInfoDisplay();
            }
        });
    });

    function maxLengthMessage()
    {
        var len = cj('#text_message').val().length;
        var maxLength = 140;
        if (len > maxLength) {
            cj('#status').crmError({/literal}'{ts escape="js"}Tweet exceeding limit of 140 characters{/ts}'{literal});
            return false;
        }
        return true;
    }

    function maxCharInfoDisplay(){
        var maxLength = 140;
        var enteredCharLength = cj('#text_message').val().length;
        var count = maxLength - enteredCharLength;

        if( count < 0 ) {
            cj('#text_message').val(cj('#text_message').val().substring(0, maxLength));
            count = 0;
        }
        cj('#char-count-message').text( "You can insert upto " + count + " characters" );
    }
    {/literal}
</script>
