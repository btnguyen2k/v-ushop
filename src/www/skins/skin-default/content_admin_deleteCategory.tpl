<!-- MIDDLE COLUMN -->
<div id="middle-column"
    [:if isset($DISABLE_COLUMN_LEFT) && isset($DISABLE_COLUMN_RIGHT):]
        style="width: 98%"
    [:elseif isset($DISABLE_COLUMN_RIGHT)||isset($DISABLE_COLUMN_LEFT):]
        style="width: 77.9%"
    [:/if:]
><!-- Middle column full box -->
    <div class="middle-column-box-yellow">
        <div class="middle-column-box-title-yellow">[:$MODEL.language->getMessage('msg.deleteCategory'):]</div>
        <form method="post" action="[:$MODEL.form.action:]" name="[:$MODEL.form.name|escape:'html':]">
            [:printFormHeader form=$MODEL.form:]
            <br/>
            <input type="submit" value="[:$MODEL.language->getMessage('msg.yes'):]" style="width: 64px" />
            <input type="button" onclick="javascript:location.href='[:$MODEL.form.actionCancel:]';"
                value="[:$MODEL.language->getMessage('msg.cancel'):]" style="width: 64px" />
        </form>
    </div>
</div>