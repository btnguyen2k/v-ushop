<!-- MIDDLE COLUMN -->
<div id="middle-column"
    [:if isset($DISABLE_COLUMN_LEFT) && isset($DISABLE_COLUMN_RIGHT):]
        style="width: 98%"
    [:elseif isset($DISABLE_COLUMN_RIGHT)||isset($DISABLE_COLUMN_LEFT):]
        style="width: 77.9%"
    [:/if:]
><!-- Middle column full box -->
    <div class="middle-column-box-green">
        <div class="middle-column-box-title-green">[:$MODEL.language->getMessage('msg.emailSettings'):]</div>
        <form method="post" action="[:$MODEL.form.action:]" name="[:$MODEL.form.name|escape:'html':]">
            [:printFormHeader form=$MODEL.form:]
            <label style="display: inline;">[:$MODEL.language->getMessage('msg.emailSettings.useSmtp'):]:</label>
            <input type="checkbox" value="1" name="useSmtp" [:if $MODEL.form.useSmtp:]checked="checked"[:/if:]/>
            <br />
            <label>[:$MODEL.language->getMessage('msg.emailSettings.smtpHost'):]:</label>
            <input type="text" name="smtpHost" value="[:$MODEL.form.smtpHost|escape:'html':]" style="width: 98%" />
            <br/>
            <label>[:$MODEL.language->getMessage('msg.emailSettings.smtpPort'):]:</label>
            <input type="text" name="smtpPort" value="[:$MODEL.form.smtpPort|escape:'html':]" style="width: 98%" />
            <br/>
            <label style="display: inline;">[:$MODEL.language->getMessage('msg.emailSettings.smtpSsl'):]:</label>
            <input type="checkbox" value="1" name="smtpSsl" [:if $MODEL.form.smtpSsl:]checked="checked"[:/if:]/>
            <br />
            <label>[:$MODEL.language->getMessage('msg.emailSettings.smtpUsername'):]:</label>
            <input type="text" name="smtpUsername" value="[:$MODEL.form.smtpUsername|escape:'html':]" style="width: 98%" />
            <br/>
            <label>[:$MODEL.language->getMessage('msg.emailSettings.smtpPassword'):]:</label>
            <input type="text" name="smtpPassword" value="[:$MODEL.form.smtpPassword|escape:'html':]" style="width: 98%" />
            <br/><br/>
            <label>[:$MODEL.language->getMessage('msg.emailSettings.emailOutgoing'):]:</label>
            (<small>[:$MODEL.language->getMessage('msg.emailSettings.emailOutgoing.info'):]</small>)
            <input type="text" name="emailOutgoing" value="[:$MODEL.form.emailOutgoing|escape:'html':]" style="width: 98%" />
            <br/>
            <label>[:$MODEL.language->getMessage('msg.emailSettings.emailOrderNotification'):]:</label>
            (<small>[:$MODEL.language->getMessage('msg.emailSettings.emailOrderNotification.info'):]</small>)
            <input type="text" name="emailOrderNotification" value="[:$MODEL.form.emailOrderNotification|escape:'html':]" style="width: 98%" />
            <br/>
            <label>[:$MODEL.language->getMessage('msg.emailSettings.emailOnSubject'):]:</label>
            (<small>[:$MODEL.language->getMessage('msg.emailSettings.emailOnSubject.info'):]</small>)
            <input type="text" name="emailOnSubject" value="[:$MODEL.form.emailOnSubject|escape:'html':]" style="width: 98%" />
            <br/>
            <label>[:$MODEL.language->getMessage('msg.emailSettings.emailOnBody'):]:</label>
            (<small>[:$MODEL.language->getMessage('msg.emailSettings.emailOnBody.info'):]</small>)
            <textarea rows="6" style="width: 98%" name="emailOnBody">[:$MODEL.form.emailOnBody|escape:'html':]</textarea>
            <br />

            <input type="submit" value="[:$MODEL.language->getMessage('msg.save'):]" style="width: 64px" />
        </form>
    </div>
</div>