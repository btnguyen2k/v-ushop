[:include file="inc_inline_html_header.tpl":]
<body class="[:$DOJO_THEME:]">
    <h1 class="heading align-center viewport-800">[:$MODEL.language->getMessage('msg.createItem'):]</h1>
    <form id="[:$FORM.name|escape:'html':]" class="align-center viewport-800"
            name="[:$FORM.name|escape:'html':]" action="[:$FORM.action:]" method="post" enctype="multipart/form-data">
        <script type="dojo/method" event="onSubmit">
            return this.validate();
        </script>
        [:if isset($MODEL.form.urlItemImage):]
            <p style="float: right; text-align: center;">
                <img border="0" src="[:$MODEL.form.urlItemImage:]" width="100px" height="100px"/>
                <br />
                <!--
                <small>[:$MODEL.language->getMessage('msg.item.image'):]</small>
                <br />
                -->
                <small><input dojoType="dijit.form.CheckBox" type="checkbox" value="1" name="removeImage"/>[:$MODEL.language->getMessage('msg.item.removeImage'):]</small>
            </p>
        [:else:]
            <p></p>
        [:/if:]
        [:call name="printFormHeader" form=$FORM:]
        
        <p></p>
        <label for="form_itemCategory">[:$LANG->getMessage('msg.item.category'):]:</label>
        <select name="categoryId">
            <option value="-1"></option>
            [:foreach $MODEL.categoryTree as $cat:]
                <option [:if $MODEL.form.categoryId==$cat->getId():]selected="selected"[:/if:] value="[:$cat->getId():]">[:$cat->getTitle()|escape:'html':]</option>
                [:foreach $cat->getChildren() as $child:]
                    <option [:if $MODEL.form.categoryId==$child->getId():]selected="selected"[:/if:] value="[:$child->getId():]">&nbsp;&nbsp;+- [:$child->getTitle()|escape:'html':]</option>
                [:/foreach:]
            [:/foreach:]
        </select>
        <br />
        
        <label for="form_itemHot" style="display: inline;">[:$MODEL.language->getMessage('msg.item.isHot'):]:</label>
        <input dojoType="dijit.form.CheckBox" id="form_itemHot" type="checkbox"
            value="1" name="itemHot" [:if $MODEL.form.itemHot:]checked="checked"[:/if:]/>
        |
        <label for="form_itemNew" style="display: inline;">[:$MODEL.language->getMessage('msg.item.isNew'):]:</label>
        <input dojoType="dijit.form.CheckBox" id="form_itemNew" type="checkbox"
            value="1" name="itemNew" [:if $MODEL.form.itemNew:]checked="checked"[:/if:]/>
        <br />
        
        <label for="form_itemVendor">[:$LANG->getMessage('msg.item.vendor'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_itemVendor"
            style="width: 50%" type="text" name="itemVendor" value="[:$MODEL.form.itemVendor|escape:'html':]" />
        <br />
        
        <label for="form_itemCode">[:$LANG->getMessage('msg.item.code'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_itemCode"
            style="width: 50%" type="text" name="itemCode" value="[:$MODEL.form.itemCode|escape:'html':]" />
        <br />
        
        <label for="form_itemPrice">[:$LANG->getMessage('msg.item.price'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_itemPrice"
            style="width: 50%" type="text" name="itemPrice" value="[:$MODEL.form.itemPrice|escape:'html':]" />
        <br />
        
        <label for="form_itemTitle">[:$LANG->getMessage('msg.item.title'):]:</label>
        <input dojoType="dijit.form.ValidationTextBox" id="form_itemTitle"
            style="width: 100%" type="text" name="itemTitle" value="[:$MODEL.form.itemTitle|escape:'html':]" />
        <br />
        
        <label for="form_itemDesc">[:$LANG->getMessage('msg.item.description'):]:</label>
        <textarea id="form_itemDesc" rows="6"
            style="width: 100%" name="itemDescription">[:$MODEL.form.itemDescription|escape:'html':]</textarea>
        <br />
        
        <label for="form_itemImage">[:$LANG->getMessage('msg.item.image'):]:</label>
        <input id="form_itemImage" style="width: 100%" type="file" name="itemImage" />
        <input type="hidden" name="itemImageId" value="[:$MODEL.form.itemImageId|escape:'html':]" />
        <br />
        
        <p></p>
        <button dojoType="dijit.form.Button" type="submit"><strong>[:$LANG->getMessage('msg.save'):]</strong></button>
        <button dojoType="dijit.form.Button" type="button" onclick="openUrl('[:$MODEL.form.actionCancel:]');">[:$LANG->getMessage('msg.cancel'):]</button>
    </form>
    [:call name="tinymce" elName='form_itemDesc':]
</body>
[:include file="inc_inline_html_footer.tpl":]
