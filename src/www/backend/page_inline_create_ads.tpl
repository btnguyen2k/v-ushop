[:include file="inc_inline_html_header.tpl":]
<body class="[:$DOJO_THEME:]">
    <h1 class="heading align-center viewport-800">[:$MODEL.language->getMessage('msg.createAds'):]</h1>
    <div dojoType="dijit.form.Form" id="[:$FORM.name|escape:'html':]" class="align-center viewport-800"
            name="[:$FORM.name|escape:'html':]" action="[:$FORM.action:]" method="post" enctype="multipart/form-data">
        <script type="dojo/method" event="onSubmit">
            return this.validate();
        </script>
		[:call name="printFormHeader" form=$FORM:]
        <label for="form_adsTitle">[:$LANG->getMessage('msg.ads.title'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_adsTitle"
            style="width: 100%" type="text" name="adsTitle" value="[:$MODEL.form.adsTitle|escape:'html':]" />
        <br />
        
        <label for="form_adsUrl">[:$LANG->getMessage('msg.ads.url'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_adsUrl"
            style="width: 100%" type="text" name="adsUrl" value="[:$MODEL.form.adsUrl|escape:'html':]" />
        <br />
        
        <label for="form_adsImage">[:$LANG->getMessage('msg.item.image'):]:</label>
         <input id="form_adsImage" style="display: none" type="file" name="adsImageId" onchange="getFileUploadName('form_adsImage','images-name')" />
		 <input type="text" id="images-name" readonly="readonly" onclick="document.getElementById('form_adsImage').click();">
		 <button type="button" dojoType="dijit.form.Button" onclick="document.getElementById('form_adsImage').click();" cl >&nbsp;&nbsp;[:$LANG->getMessage('msg.selectImage'):]&nbsp;&nbsp;</button>
		<input type="hidden" name="adsImageId" value="[:$MODEL.form.adsImageId|escape:'html':]" /><br/>
		<br />
        
        <p></p>
        <button dojoType="dijit.form.Button" type="submit"><strong>[:$LANG->getMessage('msg.save'):]</strong></button>
        <button dojoType="dijit.form.Button" type="button" onclick="openUrl('[:$MODEL.form.actionCancel:]');">[:$LANG->getMessage('msg.cancel'):]</button>
    </div>
</body>
[:include file="inc_inline_html_footer.tpl":]
