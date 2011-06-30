<!-- MIDDLE COLUMN -->
<div id="middle-column"
    [:if isset($DISABLE_COLUMN_LEFT) && isset($DISABLE_COLUMN_RIGHT):]
        style="width: 98%"
    [:elseif isset($DISABLE_COLUMN_RIGHT)||isset($DISABLE_COLUMN_LEFT):]
        style="width: 77.9%"
    [:/if:]
><!-- Middle column full box -->
    <div class="middle-column-box-green">
        <div class="middle-column-box-title-green">[:$MODEL.language->getMessage('msg.createPage'):]</div>
        <form method="post" action="[:$MODEL.form.action:]" name="[:$MODEL.form.name|escape:'html':]">
            [:printFormHeader form=$MODEL.form:]
            <label>[:$MODEL.language->getMessage('msg.page.id'):]:</label>
            <input type="text" name="pageId" value="[:$MODEL.form.pageId|escape:'html':]" style="width: 50%" />
            <br/>
            <label style="display: inline;">[:$MODEL.language->getMessage('msg.page.onMenu'):]:</label>
            <input type="checkbox" name="onMenu" value="1" [:if $MODEL.form.onMenu:]checked="checked"[:/if:]/>
            <br />
            <label>[:$MODEL.language->getMessage('msg.page.title'):]:</label>
            <input type="text" name="pageTitle" value="[:$MODEL.form.pageTitle|escape:'html':]" style="width: 98%" />
            <br/>
            <label>[:$MODEL.language->getMessage('msg.page.content'):]:</label>
            <textarea id="createPageContent" rows="16" name="pageContent" style="width: 98%">[:$MODEL.form.pageContent|escape:'html':]</textarea>
            <br/>
            <input type="submit" value="[:$MODEL.language->getMessage('msg.save'):]" style="width: 64px" />
            <input type="button" onclick="javascript:location.href='[:$MODEL.form.actionCancel:]';"
                value="[:$MODEL.language->getMessage('msg.cancel'):]" style="width: 64px" />
        </form>
        [:tinymce elName='createPageContent':]
    </div>
</div>
