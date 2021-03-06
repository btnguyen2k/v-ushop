<!-- MIDDLE COLUMN -->
<div id="middle-column"
    [:if isset($DISABLE_COLUMN_LEFT) && isset($DISABLE_COLUMN_RIGHT):]
        style="width: 98%"
    [:elseif isset($DISABLE_COLUMN_RIGHT)||isset($DISABLE_COLUMN_LEFT):]
        style="width: 77.9%"
    [:/if:]
><!-- Middle column full box -->
    <div class="middle-column-box-green">
        <div class="middle-column-box-title-green">[:$MODEL.language->getMessage('msg.createCategory'):]</div>
        <form method="post" action="[:$MODEL.form.action:]" name="[:$MODEL.form.name|escape:'html':]" enctype="multipart/form-data">
            [:if isset($MODEL.form.urlCategoryImage):]
                <p style="float: right; text-align: center;">
                    <img border="0" src="[:$MODEL.form.urlCategoryImage:]" width="100px" height="100px"/>
                    <br />
                    <small>[:$MODEL.language->getMessage('msg.category.image'):]</small>
                </p>
            [:/if:]
            [:printFormHeader form=$MODEL.form:]
            <label>[:$MODEL.language->getMessage('msg.category.parent'):]:</label>
            <select name="parentId">
                <option value="0"></option>
                [:foreach $MODEL.categoryTree as $cat:]
                    <option [:if $MODEL.form.parentId==$cat->getId():]selected="selected"[:/if:] value="[:$cat->getId():]">[:$cat->getTitle()|escape:'html':]</option>
                [:/foreach:]
            </select>
            <br/>
            <label>[:$MODEL.language->getMessage('msg.category.title'):]:</label>
            <input type="text" name="categoryTitle" value="[:$MODEL.form.categoryTitle|escape:'html':]" style="width: 75%" />
            <br/>
            <label>[:$MODEL.language->getMessage('msg.category.description'):]:</label>
            <textarea rows="6" name="categoryDescription" style="width: 98%">[:$MODEL.form.categoryDescription|escape:'html':]</textarea>
            <br/>
            <label>[:$MODEL.language->getMessage('msg.category.image'):]:</label>
            <input type="file" name="categoryImage" style="width: 98%" />
            <input type="hidden" name="categoryImageId" value="[:$MODEL.form.categoryImageId|escape:'html':]" />
            <br />
            <input type="submit" value="[:$MODEL.language->getMessage('msg.save'):]" style="width: 64px" />
            <input type="button" onclick="javascript:location.href='[:$MODEL.form.actionCancel:]';"
                value="[:$MODEL.language->getMessage('msg.cancel'):]" style="width: 64px" />
        </form>
    </div>
</div>