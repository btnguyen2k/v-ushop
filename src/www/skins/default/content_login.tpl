<!-- MIDDLE COLUMN -->
<div id="middle-column" style="width: 97.5%">
    <!-- Middle column full box -->
    <div class="middle-column-box-green">
        <div class="middle-column-box-title-green">[:$MODEL.language->getMessage('msg.login'):]</div>
        <form method="post" action="[:$MODEL.form.action:]" name="[:$MODEL.form.name|escape:'html':]">
            [:if isset($MODEL.form.errorMessage):]
                <div class="errorMsg">[:$MODEL.form.errorMessage:]</div><br/>
            [:/if:]
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