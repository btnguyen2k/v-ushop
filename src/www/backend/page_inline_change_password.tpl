[:include file="inc_inline_html_header.tpl":]
<body class="[:$DOJO_THEME:]">
    <h1 class="heading align-center viewport-800">[:$MODEL.language->getMessage('msg.changePassword'):]</h1>
   <div id="[:$MODEL.name|escape:'html':]" class="align-center viewport-800" name="[:$MODEL.name|escape:'html':]" dojoType="dijit.form.Form" 
   		method="post" enctype="multipart/form-data" action="[:$MODEL.action:]">
        <script type="dojo/method" event="onSubmit">
            return this.validate();
        </script>
		
        <label >[:$LANG->getMessage('msg.user.username'):]: [:$MODEL.user->getUsername()|escape:'html':]</label>
        <br />
        
        <label for="form_newPassword">[:$LANG->getMessage('msg.user.newPassword'):]:</label>
        <input type="password" id="form_newPassword" style="width: 50%"
            dojoType="dijit.form.ValidationTextBox" regExp="([\w]{5})(\w)*(\d)*"            
            invalidMessage="[:$LANG->getMessage('error.passwordMoreThan6characters'):]"
            name="newPassword" intermediateChanges=false
            required="true" missingMessage="[:$LANG->getMessage('msg.newPasswordIsRequired'):]"/>
        <br/>
        
        <label for="form_confirmedNewPassword">[:$LANG->getMessage('msg.user.confirmedPassword'):]:</label>
        <input type="password" name="confirmedNewPassword" style="width: 50%"
            id="form_confirmedNewPassword" dojoType="dijit.form.ValidationTextBox"
            required="true" constraints="{'other': 'form_newPassword'}"
            validator=confirmPassword intermediateChanges=false
            invalidMessage="[:$LANG->getMessage('error.confirmPasswordNotMatch'):]"
            missingMessage="[:$LANG->getMessage('error.confirmPasswordNotMatch'):]" />  
        <br />
            
        <p></p>
        <button dojoType="dijit.form.Button" type="submit">&nbsp;<strong>[:$LANG->getMessage('msg.save'):]&nbsp;</strong></button>
        <button dojoType="dijit.form.Button" type="button" onclick="openUrl('[:$MODEL.actionCancel:]');">[:$LANG->getMessage('msg.cancel'):]</button>
    </form>   
</body>
[:include file="inc_inline_html_footer.tpl":]
