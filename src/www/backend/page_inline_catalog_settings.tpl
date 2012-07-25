[:include file="inc_inline_html_header.tpl":]
<body class="[:$DOJO_THEME:]">
    <h1 class="heading align-center viewport-800">[:$MODEL.language->getMessage('msg.catalogSettings'):]</h1>
    <form dojoType="dijit.form.Form" id="[:$FORM.name|escape:'html':]" class="align-center viewport-800"
            name="[:$FORM.name|escape:'html':]" action="[:$FORM.action:]" method="post">
        <script type="dojo/method" event="onSubmit">
            return this.validate();
        </script>
        [:call name="printFormHeader" form=$FORM:]
        
        <label for="form_thumbnailWidth">[:$LANG->getMessage('msg.thumbnailWidth'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_thumbnailWidth" style="width: 100%" type="text"
            name="thumbnailWidth" value="[:$MODEL.form.thumbnailWidth|escape:'html':]" />
        <br/>
        
        <label for="form_thumbnailHeight">[:$LANG->getMessage('msg.thumbnailHeight'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_thumbnailHeight" style="width: 100%" type="text"
            name="thumbnailHeight" value="[:$MODEL.form.thumbnailHeight|escape:'html':]" />
        <br/>
        
        <label for="form_currency">[:$LANG->getMessage('msg.currency'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_currency" style="width: 100%" type="text"
            name="currency" value="[:$MODEL.form.currency|escape:'html':]" />
        <br />
            
        <label for="form_priceDecimalPlaces">[:$LANG->getMessage('msg.priceDecimalPlaces'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_priceDecimalPlaces" style="width: 100%" type="text"
            name="priceDecimalPlaces" value="[:$MODEL.form.priceDecimalPlaces|escape:'html':]" />
        <br />
            
        <label for="form_quantityDecimalPlaces">[:$LANG->getMessage('msg.quantityDecimalPlaces'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_quantityDecimalPlaces" style="width: 100%" type="text"
            name="quantityDecimalPlaces" value="[:$MODEL.form.quantityDecimalPlaces|escape:'html':]" />
        <br />
            
        <label for="form_decimalSeparator">[:$LANG->getMessage('msg.decimalSeparator'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_decimalSeparator" style="width: 100%" type="text"
            name="decimalSeparator" value="[:$MODEL.form.decimalSeparator|escape:'html':]" />
        <br />
            
        <label for="form_thousandsSeparator">[:$LANG->getMessage('msg.thousandsSeparator'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_thousandsSeparator" style="width: 100%" type="text"
            name="thousandsSeparator" value="[:$MODEL.form.thousandsSeparator|escape:'html':]" />
    
        <p></p>
        <button dojoType="dijit.form.Button" type="submit" name="submit" class="button-medium">[:$LANG->getMessage('msg.save'):]</button>
        
        <br/><br/>
        <label for="form_priceExample"><small>[:$MODEL.language->getMessage('msg.priceExample'):]:</small></label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_priceExample" disabled="disabled" style="width: 100%" type="text"
            name="priceExample" value="[:$MODEL.form.priceExample|escape:'html':]"/>
        <br/>
        <label for="form_quantityExample"><small>[:$MODEL.language->getMessage('msg.quantityExample'):]:</small></label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_quantityExample" disabled="disabled" style="width: 100%" type="text"
            name="quantityExample" value="[:$MODEL.form.quantityExample|escape:'html':]" />
    </form>
</body>
[:include file="inc_inline_html_footer.tpl":]
