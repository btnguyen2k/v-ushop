<!-- MIDDLE COLUMN -->
<div id="middle-column"
    [:if isset($DISABLE_COLUMN_LEFT) && isset($DISABLE_COLUMN_RIGHT):]
        style="width: 98%"
    [:elseif isset($DISABLE_COLUMN_RIGHT)||isset($DISABLE_COLUMN_LEFT):]
        style="width: 77.9%"
    [:/if:]
><!-- Middle column full box -->
    <div class="middle-column-box-green">
        <div class="middle-column-box-title-green">[:$MODEL.language->getMessage('msg.catalogSettings'):]</div>
        <form method="post" action="[:$MODEL.form.action:]" name="[:$MODEL.form.name|escape:'html':]">
            [:printFormHeader form=$MODEL.form:]
            <label>[:$MODEL.language->getMessage('msg.currency'):]:</label>
            <input type="text" name="currency" value="[:$MODEL.form.currency|escape:'html':]" style="width: 98%" />
            <br/>
            <label>[:$MODEL.language->getMessage('msg.priceDecimalPlaces'):]:</label>
            <input type="text" name="priceDecimalPlaces" value="[:$MODEL.form.priceDecimalPlaces|escape:'html':]" style="width: 98%" />
            <br/>
            <label>[:$MODEL.language->getMessage('msg.quantityDecimalPlaces'):]:</label>
            <input type="text" name="quantityDecimalPlaces" value="[:$MODEL.form.quantityDecimalPlaces|escape:'html':]" style="width: 98%" />
            <br/>
            <label>[:$MODEL.language->getMessage('msg.decimalSeparator'):]:</label>
            <input type="text" name="decimalSeparator" value="[:$MODEL.form.decimalSeparator|escape:'html':]" style="width: 98%" />
            <br/>
            <label>[:$MODEL.language->getMessage('msg.thousandsSeparator'):]:</label>
            <input type="text" name="thousandsSeparator" value="[:$MODEL.form.thousandsSeparator|escape:'html':]" style="width: 98%" />
            <br/>
            <input type="submit" value="[:$MODEL.language->getMessage('msg.save'):]" style="width: 64px" />
            <br/><br/>
            <label><small>[:$MODEL.language->getMessage('msg.priceExample'):]:</small></label>
            <input disabled="disabled" type="text" name="priceExample" value="[:$MODEL.form.priceExample|escape:'html':]" style="width: 98%" />
            <br/>
            <label><small>[:$MODEL.language->getMessage('msg.quantityExample'):]:</small></label>
            <input disabled="disabled" type="text" name="quantityExample" value="[:$MODEL.form.quantityExample|escape:'html':]" style="width: 98%" />
            <br/>
        </form>
    </div>
</div>