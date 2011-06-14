<!-- MIDDLE COLUMN -->
<div id="middle-column"
    [:if isset($DISABLE_COLUMN_LEFT) && isset($DISABLE_COLUMN_RIGHT):]
        style="width: 98%"
    [:elseif isset($DISABLE_COLUMN_RIGHT)||isset($DISABLE_COLUMN_LEFT):]
        style="width: 77.9%"
    [:/if:]
><!-- Middle column full box -->
    <div class="middle-column-box-green">
        <div class="middle-column-box-title-green">[:$MODEL.language->getMessage('msg.siteSettings'):]</div>
        <form method="post" action="[:$MODEL.form.action:]" name="[:$MODEL.form.name|escape:'html':]">
            [:if isset($MODEL.form.errorMessage):]
                <div class="errorMsg">[:$MODEL.form.errorMessage:]</div><br/>
            [:/if:]
            [:if isset($MODEL.form.infoMessage):]
                <div class="infoMsg">[:$MODEL.form.infoMessage:]</div><br/>
            [:/if:]
            <label>[:$MODEL.language->getMessage('msg.siteName'):]:</label>
            <input type="text" name="siteName" value="[:$MODEL.form.siteName|escape:'html':]" style="width: 320px" />
            <br/>
            <label>[:$MODEL.language->getMessage('msg.siteTitle'):]:</label>
            <input type="text" name="siteTitle" value="[:$MODEL.form.siteTitle|escape:'html':]" style="width: 320px" />
            <br/>
            <label>[:$MODEL.language->getMessage('msg.siteKeywords'):]:</label>
            <input type="text" name="siteKeywords" value="[:$MODEL.form.siteKeywords|escape:'html':]" style="width: 320px" />
            <br/>
            <label>[:$MODEL.language->getMessage('msg.siteDescription'):]:</label>
            <input type="text" name="siteDescription" value="[:$MODEL.form.siteDescription|escape:'html':]" style="width: 320px" />
            <br/>
            <label>[:$MODEL.language->getMessage('msg.siteCopyright'):]:</label>
            <input type="text" name="siteCopyright" value="[:$MODEL.form.siteCopyright|escape:'html':]" style="width: 320px" />
            <br/>
            <input type="submit" value="[:$MODEL.language->getMessage('msg.save'):]" style="width: 64px" />
        </form>
    </div>
</div>