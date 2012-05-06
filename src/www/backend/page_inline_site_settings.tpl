[:include file="inc_inline_html_header.tpl":]
<body class="[:$DOJO_THEME:]">
    <h1 class="heading">[:$MODEL.language->getMessage('msg.siteSettings'):]</h1>
    <form dojoType="dijit.form.Form" id="[:$FORM.name|escape:'html':]" name="[:$FORM.name|escape:'html':]"
            action="[:$FORM.action:]" method="post">
        <script type="dojo/method" event="onSubmit">
            return this.validate();
        </script>
        [:call name="printFormHeader" form=$FORM:]
        <label for="form_siteName">[:$LANG->getMessage('msg.siteName'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_siteName" class="input-medium" type="text"
            name="siteName" value="[:$MODEL.form.siteName|escape:'html':]" />
        <br />
            
        <label for="form_siteTitle">[:$LANG->getMessage('msg.siteTitle'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_siteTitle" class="input-medium" type="text"
            name="siteTitle" value="[:$MODEL.form.siteTitle|escape:'html':]" />
            
        <label for="form_siteKeywords">[:$LANG->getMessage('msg.siteKeywords'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_siteKeywords" class="input-medium" type="text"
            name="siteKeywords" value="[:$MODEL.form.siteKeywords|escape:'html':]" />
            
        <label for="form_siteDescription">[:$LANG->getMessage('msg.siteDescription'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_siteDescription" class="input-medium" type="text"
            name="siteDescription" value="[:$MODEL.form.siteDescription|escape:'html':]" />
            
        <label for="form_siteCopyright">[:$LANG->getMessage('msg.siteCopyright'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_siteCopyright" class="input-medium" type="text"
            name="siteCopyright" value="[:$MODEL.form.siteCopyright|escape:'html':]" />
    
        <p></p>
        <button dojoType="dijit.form.Button" type="submit" name="submit" class="button-medium">[:$LANG->getMessage('msg.save'):]</button>
    </form>
</body>
[:include file="inc_inline_html_footer.tpl":]
