[:include file="inc_inline_html_header.tpl":]
<body class="[:$DOJO_THEME:]">
    <h1 class="heading align-center viewport-800">[:$MODEL.language->getMessage('msg.createPage'):]</h1>
    <form id="[:$FORM.name|escape:'html':]" class="align-center viewport-800"
            name="[:$FORM.name|escape:'html':]" action="[:$FORM.action:]" method="post">
        <script type="dojo/method" event="onSubmit">
            return this.validate();
        </script>
        [:call name="printFormHeader" form=$FORM:]
        
        <label for="form_pageId">[:$LANG->getMessage('msg.page.id'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" missingMessage="[:$LANG->getMessage('error.emptyPageId'):]" id="form_pageId"
            style="width: 100%" type="text" name="pageId" value="[:$MODEL.form.pageId|escape:'html':]" />
        <br />
        
        <label for="form_pageCategory">[:$LANG->getMessage('msg.page.category'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_pageCategory"
            style="width: 100%" type="text" name="pageCategory" value="[:$MODEL.form.pageCategory|escape:'html':]" />
        <br />
        
        <label for="form_onMenu" style="display: inline;">[:$LANG->getMessage('msg.page.onMenu'):]:</label>
        <input dojoType="dijit.form.CheckBox" id="form_onMenu"
            type="checkbox" name="onMenu" value="1" [:if $MODEL.form.onMenu:]checked="checked"[:/if:] />
        <br />
        
        <label for="form_pageTitle">[:$LANG->getMessage('msg.page.title'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_pageTitle"
            style="width: 100%" type="text" name="pageTitle" value="[:$MODEL.form.pageTitle|escape:'html':]" />
        <br />
            
        <label for="form_pageContent">[:$LANG->getMessage('msg.page.content'):]:</label>
        <textarea id="form_pageContent" style="width: 100%" rows="20" name="pageContent">[:$MODEL.form.pageContent|escape:'html':]</textarea>
        
        <p></p>
        <button dojoType="dijit.form.Button" type="submit"><strong>[:$LANG->getMessage('msg.save'):]</strong></button>
        <button dojoType="dijit.form.Button" type="button" onclick="openUrl('[:$MODEL.form.actionCancel:]');">[:$LANG->getMessage('msg.cancel'):]</button>
    </form>
    [:call name="tinymce" elName='form_pageContent':]
</body>
[:include file="inc_inline_html_footer.tpl":]
