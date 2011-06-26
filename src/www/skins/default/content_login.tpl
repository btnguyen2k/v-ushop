<!-- MIDDLE COLUMN -->
<div id="middle-column"
    [:if isset($DISABLE_COLUMN_LEFT) && isset($DISABLE_COLUMN_RIGHT):]
        style="width: 98%"
    [:elseif isset($DISABLE_COLUMN_RIGHT)||isset($DISABLE_COLUMN_LEFT):]
        style="width: 77.9%"
    [:/if:]
><!-- Middle column full box -->
    <div class="middle-column-box-green">
        <div class="middle-column-box-title-green">[:$MODEL.language->getMessage('msg.login'):]</div>
        <form method="post" action="[:$MODEL.form.action:]" name="[:$MODEL.form.name|escape:'html':]">
            [:printFormHeader form=$MODEL.form:]
            <label>[:$MODEL.language->getMessage('msg.email'):]:</label>
            <input type="text" name="email" style="width: 256px" />
            <br/>
            <label>[:$MODEL.language->getMessage('msg.password'):]:</label>
            <input type="password" name="password" style="width: 256px" />
            <br/>
            <input type="submit" value="[:$MODEL.language->getMessage('msg.login'):]" />
        </form>
    </div>
</div>