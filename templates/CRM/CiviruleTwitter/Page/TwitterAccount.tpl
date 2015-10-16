{if $action eq 1 or $action eq 2 or $action eq 8}
    {include file="CRM/CiviruleTwitter/Form/FinancialType.tpl"}
    {include file="CRM/CiviruleTwitter/Form/TwitterAccount.tpl"}
{else}
    <div id="ltype">
    <div class="form-item">
    {strip}
        <table cellpadding="0" cellspacing="0" border="0">
            <thead class="sticky">
                <th>{ts}Twitter account{/ts}</th>
                <th>{ts}Description{/ts}</th>
                <th></th>
            </thead>
            {foreach from=$rows item=row}
                <tr id="row_{$row.id}"class="{cycle values="odd-row,even-row"} {$row.class}">
                    <td>@{$row.twitter_name}</td>
                    <td>{$row.description}</td>
                    <td>{$row.action|replace:'xx':$row.id}</td>
                </tr>
            {/foreach}
        </table>
    {/strip}
    </div>

    {if $action ne 1 and $action ne 2}
        <div class="action-link">
            <a href="{crmURL q="action=add&reset=1"}" id="newTwitterAccount" class="button"><span><div class="icon add-icon"></div>{ts}Add twitter account{/ts}</span></a>
        </div>
    {/if}

    </div>
{/if}