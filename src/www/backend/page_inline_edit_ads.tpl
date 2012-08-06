[:include file="inc_inline_html_header.tpl":]
<body class="[:$DOJO_THEME:]">
    <h1 class="heading align-center viewport-800">[:$MODEL.language->getMessage('msg.editAds'):]</h1>
    <form dojoType="dijit.form.Form" id="[:$FORM.name|escape:'html':]" class="align-center viewport-800"
            name="[:$FORM.name|escape:'html':]" action="[:$FORM.action:]" method="post" enctype="multipart/form-data">
        <script type="dojo/method" event="onSubmit">
            return this.validate();
        </script>
		   [:if isset($MODEL.form.urlAdsImage):]
            <p style="float: right; text-align: center;">
                <img border="0" src="[:$MODEL.form.urlAdsImage:]" width="165px" height="60px"/>
                <br />
                <!--
                <small>[:$MODEL.language->getMessage('msg.ads.image'):]</small>
                <br />
                -->
                
            </p>
        [:/if:]
            
        [:call name="printFormHeader" form=$FORM:]
        <label for="form_adsTitle">[:$LANG->getMessage('msg.ads.title'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_adsTitle"
            style="width: 50%" type="text" name="adsTitle" value="[:$MODEL.form.adsTitle|escape:'html':]" />
        <br />
        
        <label for="form_adsUrl">[:$LANG->getMessage('msg.ads.url'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_adsUrl"
            style="width: 50%" type="text" name="adsUrl" value="[:$MODEL.form.adsUrl|escape:'html':]" />
        <br />
        
         <label for="form_adsImage">[:$LANG->getMessage('msg.ads.image'):]:</label>
        <input id="form_adsImage" style="width: 50%" type="file" name="adsImage" />
        <input type="hidden" name="adsImageId" value="[:$MODEL.form.adsImageId|escape:'html':]" />
        <br />
        
        <p></p>
        <button dojoType="dijit.form.Button" type="submit"><strong>[:$LANG->getMessage('msg.save'):]</strong></button>
        <button dojoType="dijit.form.Button" type="button" onclick="openUrl('[:$MODEL.form.actionCancel:]');">[:$LANG->getMessage('msg.cancel'):]</button>
    </form>
</body>
[:include file="inc_inline_html_footer.tpl":]
