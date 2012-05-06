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
            <form dojoType="dijit.form.Form" id="[:$FORM.name|escape:'html':]"
                    name="[:$FORM.name|escape:'html':]" action="[:$FORM.action:]" method="post">
                <script type="dojo/method" event="onSubmit">
                    return this.validate();
                </script>
                <table class="form" style="width: 400px; margin: auto" cellspacing="10">
                    <thead>
                        <tr>
                            <th>
                                [:$LANG->getMessage('msg.login'):]
                            </th>
                        </tr>
                    </thead>
                    <tr>
                        <td>
                            [:call name="printFormHeader" form=$FORM:]
                        </td>
                    </tr>
                    <tr>
                        <td>
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
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
[:include file="inc_html_footer.tpl":]
