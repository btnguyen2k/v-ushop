[:include file="inc_html_header.tpl":]
<body class="[:$DOJO_THEME:]">
    <div dojoType="dijit.layout.BorderContainer" design="headline" gutters="true" liveSplitters="false" id="main">
        <div dojoType="dijit.layout.ContentPane" splitter="false" region="top" minSize="0">
            <strong><a href="[:$MODEL.urlHome:]">[:$MODEL.APP_NAME:]</a> |</strong>
            [:$LANG->getMessage('msg.login'):]
        </div>
        <div dojoType="dijit.layout.ContentPane" splitter="false" region="bottom" minSize="0" style="text-align: center;">
            [:$MODEL.APP_NAME:] [:$MODEL.APP_VERSION:] | [:$MODEL.page.copyright:]
        </div>
        <div dojoType="dijit.layout.ContentPane" splitter="false" region="center">
            <h1 class="heading align-center viewport-640">[:$MODEL.language->getMessage('msg.login'):]</h1>
            <form dojoType="dijit.form.Form" id="[:$FORM.name|escape:'html':]" class="align-center viewport-640"
                    name="[:$FORM.name|escape:'html':]" action="[:$FORM.action:]" method="post">
                <script type="dojo/method" event="onSubmit">
                    return this.validate();
                </script>
                [:call name="printFormHeader" form=$FORM:]
                
                <label for="frmLogin_Username">[:$LANG->getMessage('msg.username'):] *:</label>
                <input dojoType="dijit.form.ValidationTextBox" id="frmLogin_Username" required="true"
                    missingMessage="[:$LANG->getMessage('error.empty.username'):]"
                    style="width: 100%" type="text" name="username" value="[:$FORM.username|escape:'html':]" />
                <br />
                            
                <label for="frmLogin_Password">[:$LANG->getMessage('msg.password'):] *:</label>
                <input dojoType="dijit.form.ValidationTextBox" id="frmLogin_Password" required="true"
                    missingMessage="[:$LANG->getMessage('error.empty.password'):]"
                    style="width: 100%" type="password" name="password" />
                                
                <p></p>
                <button dojoType="dijit.form.Button" type="submit" name="submit">[:$LANG->getMessage('msg.login'):]</button>
            </form>
        </div>
    </div>
</body>
[:include file="inc_html_footer.tpl":]
