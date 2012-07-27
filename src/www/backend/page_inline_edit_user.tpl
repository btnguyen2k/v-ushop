[:include file="inc_inline_html_header.tpl":]
<body class="[:$DOJO_THEME:]">
    <h1 class="heading align-center viewport-800">[:$MODEL.language->getMessage('msg.createUser'):]</h1>
   <div id="[:$FORM.name|escape:'html':]" class="align-center viewport-800" name="[:$FORM.name|escape:'html':]" dojoType="dijit.form.Form" 
   		method="post" enctype="multipart/form-data" action="[:$FORM.action:]">
        <script type="dojo/method" event="onSubmit">
            return this.validate();
        </script>
        
        <label for="form_groupId">[:$LANG->getMessage('msg.category.group'):]:</label>
        <select name="groupId" style="width: 150px">
             <option value="1" [:if $MODEL.form.groupId ==1:]selected="selected"[:/if:]>[:$LANG->getMessage('msg.adminCp'):]</option>
            <option value="2" [:if $MODEL.form.groupId ==2:]selected="selected"[:/if:]>[:$LANG->getMessage('msg.member'):]</option>
        </select>
        <br />
          
        <label for="form_username">[:$LANG->getMessage('msg.user.username'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" required="true" missingMessage="[:$LANG->getMessage('error.emptyUsername'):]" id="form_username"
            style="width: 50%" type="text" name="username" value="[:$MODEL.form.username|escape:'html':]" />
        <br />
        
         <label for="form_fullname">[:$LANG->getMessage('msg.user.fullname'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_fullname"
            style="width: 50%" type="text" name="fullname" value="[:$MODEL.form.fullname|escape:'html':]" />
        <br />
            
        <label for="form_email">[:$LANG->getMessage('msg.user.email'):]:</label>
        <input id="form_email" style="width: 50%"  required="true" missingMessage="[:$LANG->getMessage('error.emptyEmail'):]"
            name="email" dojoType="dijit.form.ValidationTextBox" regExp="(^[A-Za-z][A-Za-z0-9_])([\w.])*([\w]+)(@)([\w]{2,10})([.]([\w]{2,10}))+$"
			invalidMessage="[:$LANG->getMessage('error.invalidEmails'):]"
            value="[:$MODEL.form.email|escape:'html':]"></input>
        <br />  
        
        <label for="form_location">[:$LANG->getMessage('msg.user.location'):]:</label>
        <input id="form_location" type="text" style="width: 50%"
            name="location" dojoType="dijit.form.TextBox"
            value="[:$MODEL.form.location|escape:'html':]"></input>
        <br />
        
         <label for="form_title">[:$LANG->getMessage('msg.user.title'):]:</label>
        <textarea id="form_title" style="width: 100%;"  height="100px"
          	rows="6" name="title" dojoType="dijit.Editor"> [:$MODEL.form.title|escape:'html':]</textarea>
        <br />
            
        <p></p>
        <button dojoType="dijit.form.Button" type="submit"><strong>[:$LANG->getMessage('msg.save'):]</strong></button>
        <button dojoType="dijit.form.Button" type="button" onclick="openUrl('[:$MODEL.form.actionCancel:]');">[:$LANG->getMessage('msg.cancel'):]</button>
    </form>
   
</body>
[:include file="inc_inline_html_footer.tpl":]
