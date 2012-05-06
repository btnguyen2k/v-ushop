[:include file="inc_inline_html_header.tpl":]
<body class="[:$DOJO_THEME:]">
    <h1 class="heading">[:$MODEL.language->getMessage('msg.emailSettings'):]</h1>
    <form id="[:$FORM.name|escape:'html':]" name="[:$FORM.name|escape:'html':]" action="[:$FORM.action:]" method="post">
        <script type="dojo/method" event="onSubmit">
            return this.validate();
        </script>
        [:call name="printFormHeader" form=$FORM:]
        
        <label for="form_useSmtp" style="display: inline;">[:$LANG->getMessage('msg.emailSettings.useSmtp'):]:</label>
        <input dojoType="dijit.form.CheckBox" id="form_useSmtp" type="checkbox"
            value="1" name="useSmtp" [:if $MODEL.form.useSmtp:]checked="checked"[:/if:]/>
        <br />
    
        <label for="form_smtpHost">[:$LANG->getMessage('msg.emailSettings.smtpHost'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_smtpHost" class="input-medium" type="text"
            name="smtpHost" value="[:$MODEL.form.smtpHost|escape:'html':]" />
        <br />
        
        <label for="form_smtpPort">[:$LANG->getMessage('msg.emailSettings.smtpPort'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_smtpPort" class="input-medium" type="text"
            name="smtpPort" value="[:$MODEL.form.smtpPort|escape:'html':]" />
        <br /><br />
        
        <label for="form_smtpSsl" style="display: inline;">[:$LANG->getMessage('msg.emailSettings.smtpSsl'):]:</label>
        <input dojoType="dijit.form.CheckBox" id="form_smtpSsl" type="checkbox"
            value="1" name="smtpSsl" [:if $MODEL.form.smtpSsl:]checked="checked"[:/if:]/>
        <br />
        
        <label for="form_smtpUsername">[:$LANG->getMessage('msg.emailSettings.smtpUsername'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_smtpUsername" class="input-medium" type="text"
            name="smtpUsername" value="[:$MODEL.form.smtpUsername|escape:'html':]" />
        <br />
    
        <label for="form_smtpPassword">[:$LANG->getMessage('msg.emailSettings.smtpPassword'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_smtpPassword" class="input-medium" type="text"
            name="smtpPassword" value="[:$MODEL.form.smtpPassword|escape:'html':]" />
        <br />
    
        <label for="form_emailOutgoing">[:$LANG->getMessage('msg.emailSettings.emailOutgoing'):]:</label>
        (<small>[:$MODEL.language->getMessage('msg.emailSettings.emailOutgoing.info'):]</small>)<br />
        <input dojoType="dijit.form.ValidationTextBox" id="form_emailOutgoing" class="input-medium" type="text"
            name="emailOutgoing" value="[:$MODEL.form.emailOutgoing|escape:'html':]" />
        <br />
    
        <label for="form_emailOrderNotification">[:$LANG->getMessage('msg.emailSettings.emailOrderNotification'):]:</label>
        (<small>[:$MODEL.language->getMessage('msg.emailSettings.emailOrderNotification.info'):]</small>)<br />
        <input dojoType="dijit.form.ValidationTextBox" id="form_emailOrderNotification" class="input-medium" type="text"
            name="emailOrderNotification" value="[:$MODEL.form.emailOrderNotification|escape:'html':]" />
        <br />
        
        <label for="form_emailOnSubject">[:$LANG->getMessage('msg.emailSettings.emailOnSubject'):]:</label>
        (<small>[:$MODEL.language->getMessage('msg.emailSettings.emailOnSubject.info'):]</small>)<br />
        <input dojoType="dijit.form.ValidationTextBox" id="form_emailOnSubject" class="input-medium" type="text"
            name="emailOnSubject" value="[:$MODEL.form.emailOnSubject|escape:'html':]" />
        <br />
        
        <label for="form_emailOnBody">[:$LANG->getMessage('msg.emailSettings.emailOnBody'):]:</label>
        (<small>[:$MODEL.language->getMessage('msg.emailSettings.emailOnBody.info'):]</small>)<br />
        <textarea id="form_emailOnBody" name="emailOnBody" class="input-xlarge" rows="10">[:$MODEL.form.emailOnBody|escape:'html':]</textarea>
    
        <p></p>
        <button dojoType="dijit.form.Button" type="submit" name="submit" class="button-medium">[:$LANG->getMessage('msg.save'):]</button>
    </form>
    [:call name="tinymce" elName="form_emailOnBody":]
</body>
[:include file="inc_inline_html_footer.tpl":]
