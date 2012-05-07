[:include file="inc_inline_html_header.tpl":]
<body class="[:$DOJO_THEME:]">
    <h1 class="heading align-center viewport-800">[:$MODEL.language->getMessage('msg.editCategory'):]</h1>
    <form dojoType="dijit.form.Form" id="[:$FORM.name|escape:'html':]" class="align-center viewport-800"
            name="[:$FORM.name|escape:'html':]" action="[:$FORM.action:]" method="post" enctype="multipart/form-data">
        <script type="dojo/method" event="onSubmit">
            return this.validate();
        </script>
        [:if isset($MODEL.form.urlCategoryImage):]
            <p style="float: right; text-align: center;">
                <img border="0" src="[:$MODEL.form.urlCategoryImage:]" width="100px" height="100px"/>
                <br />
                <!--
                <small>[:$MODEL.language->getMessage('msg.category.image'):]</small>
                <br />
                -->
                <small><input dojoType="dijit.form.CheckBox" type="checkbox" value="1" name="removeImage"/>[:$MODEL.language->getMessage('msg.category.removeImage'):]</small>
            </p>
        [:/if:]
        [:call name="printFormHeader" form=$FORM:]
        
        <p>&nbsp;</p>
        <label for="form_parentId">[:$LANG->getMessage('msg.category.parent'):]:</label>
        <select dojoType="dijit.form.Select" name="parentId" style="height: 20px">
            <option value="0"></option>
            [:foreach $MODEL.categoryTree as $cat:]
                <option [:if $MODEL.form.parentId==$cat->getId():]selected="selected"[:/if:] value="[:$cat->getId():]">[:$cat->getTitle()|escape:'html':]</option>
            [:/foreach:]
        </select>
        <br />
            
        <label for="form_categoryTitle">[:$LANG->getMessage('msg.category.title'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" missingMessage="[:$LANG->getMessage('error.emptyPageTitle'):]" id="form_categoryTitle"
            style="width: 50%" type="text" name="categoryTitle" value="[:$MODEL.form.categoryTitle|escape:'html':]" />
        <br />
            
        <label for="form_categoryDescription">[:$LANG->getMessage('msg.category.description'):]:</label>
        <textarea dojoType="dijit.form.Textarea" id="form_categoryDescription" style="width: 100%"
            rows="6" name="categoryDescription">[:$MODEL.form.categoryDescription|escape:'html':]</textarea>
        <br />
        
        <label for="form_categoryImage">[:$LANG->getMessage('msg.category.image'):]:</label>
        <input id="form_categoryImage" style="width: 100%" type="file" name="categoryImage" />
        <input type="hidden" name="categoryImageId" value="[:$MODEL.form.categoryImageId|escape:'html':]" />
        <br />
            
        <p></p>
        <button dojoType="dijit.form.Button" type="submit"><strong>[:$LANG->getMessage('msg.save'):]</strong></button>
        <button dojoType="dijit.form.Button" type="button" onclick="openUrl('[:$MODEL.form.actionCancel:]');">[:$LANG->getMessage('msg.cancel'):]</button>
    </form>
</body>
[:include file="inc_inline_html_footer.tpl":]
