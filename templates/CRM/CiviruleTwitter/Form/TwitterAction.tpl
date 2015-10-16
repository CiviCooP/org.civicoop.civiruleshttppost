<h3>{$ruleActionHeader}</h3>
<div class="crm-block crm-form-block crm-civirule-rule_action-block-group-contact">

    <div class="crm-section">
        <div class="label">{$form.twitter_account.label}</div>
        <div class="content">{$form.twitter_account.html}</div>
        <div class="clear"></div>
    </div>
    <div class="crm-section">
        <div class="label">{$form.status.label}</div>
        <div class="content">
            {$form.status.html}
            <p class="description">{ts}You can use contact tokens{/ts}</p>
        </div>
        <div class="clear"></div>
    </div>

    <div class="crm-submit-buttons">
        {include file="CRM/common/formButtons.tpl" location="bottom"}
    </div>
</div>
