<!include file='inc_header.tpl'!>
<p>Current session values:</p>
<table border="1" cellpadding="4">
    <thead>
        <tr>
            <th>Key</th>
            <th>Value</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        {foreach $MODEL as $key => $value}
            <tr>
                <td>{$key|escape:'html'}</td><td>{$value|escape:'html'}</td>
                <td><a href="{$smarty.server.SCRIPT_NAME}/delete?key={$key|escape:'url'}">Delete</a></td>
            </tr>
        {/foreach}
    </tbody>
</table>

<p>Add a new value:</p>
<form method="post" action="{$smarty.server.SCRIPT_NAME}/add">
<table>
    <tr>
        <td>Name:</td>
        <td><input type="text" name="key"></td>
    </tr>
    <tr>
        <td>Value:</td>
        <td><input type="text" name="value"></td>
    </tr>
    <tr>
        <td colspan="2"><input type="submit" value="Add"></td>
    </tr>
</table>
</form>
{include file='inc_footer.tpl'}
