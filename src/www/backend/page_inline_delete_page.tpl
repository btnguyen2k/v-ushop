[:include file="inc_inline_html_header.tpl":]
<body class="[:$DOJO_THEME:]">
    <h1 class="heading align-center viewport-800">[:$MODEL.language->getMessage('msg.deletePage'):]</h1>
    <form dojoType="dijit.form.Form" id="[:$FORM.name|escape:'html':]" class="align-center viewport-800"
            name="[:$FORM.name|escape:'html':]" action="[:$FORM.action:]" method="post">
        <script type="dojo/method" event="onSubmit">
            return this.validate();
        </script>
        [:call name="printFormHeader" form=$FORM:]
        
        <button dojoType="dijit.form.Button" type="submit"><strong>[:$LANG->getMessage('msg.yes'):]</strong></button>
        <button dojoType="dijit.form.Button" type="button" onclick="openUrl('[:$MODEL.form.actionCancel:]');">[:$LANG->getMessage('msg.cancel'):]</button>
    </form>
</body>
[:include file="inc_inline_html_footer.tpl":]
