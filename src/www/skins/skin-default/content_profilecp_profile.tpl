<!-- MIDDLE COLUMN -->
<div id="middle-column"
    [:if isset($DISABLE_COLUMN_LEFT) && isset($DISABLE_COLUMN_RIGHT):]
        style="width: 98%"
    [:elseif isset($DISABLE_COLUMN_RIGHT)||isset($DISABLE_COLUMN_LEFT):]
        style="width: 77.9%"
    [:/if:]
><!-- Middle column full box -->
    <div class="middle-column-box-green">
        <form method="post" action="[:$MODEL.form.action:]" name="[:$MODEL.form.name|escape:'html':]">
            [:printFormHeader form=$MODEL.form:]
            <div class="middle-column-box-title-green">[:$MODEL.language->getMessage('msg.updateProfile'):]</div>
            <p>
                <label>[:$MODEL.language->getMessage('msg.profile.email'):]:</label>
                <input type="text" name="email" value="[:$MODEL.form.email|escape:'html':]" style="width: 98%" />
            </p>

            <div class="middle-column-box-title-green">[:$MODEL.language->getMessage('msg.changePassword'):]</div>
            <p>
                <small>([:$MODEL.language->getMessage('msg.changePassword.info'):])</small>
                <label>[:$MODEL.language->getMessage('msg.profile.currentPassword'):]:</label>
                <input type="password" name="currentPassword" value="" style="width: 98%" />
                <br/>
                <label>[:$MODEL.language->getMessage('msg.profile.newPassword'):]:</label>
                <input type="password" name="newPassword" value="" style="width: 98%" />
                <br/>
                <label>[:$MODEL.language->getMessage('msg.profile.confirmedNewPassword'):]:</label>
                <input type="password" name="confirmedNewPassword" value="" style="width: 98%" />
                <br/>
            </p>
            <div class="middle-column-box-title-green">
                <input type="submit" value="[:$MODEL.language->getMessage('msg.save'):]" style="width: 64px" />
            </div>
        </form>
    </div>
</div>