<!-- MIDDLE COLUMN -->
<div id="main" [:if isset($DISABLE_COLUMN_RIGHT)&&isset($DISABLE_COLUMN_LEFT):]style="width: 870px"[:else:]style="width: 680px"[:/if:]>
	<h1>[:$LANG->getMessage('msg.profile'):]</h1>
	<br/>
    <div id="tabs">
        <ul>
        	<li><a onclick="window.location.href='[:$MODEL.urlProfile:]';" href="javascript:void(0);">[:$LANG->getMessage('msg.shop.information'):]</a></li>
        	<li><a onclick="window.location.href='[:$MODEL.urlChangePassword:]';" href="javascript:void(0);">[:$LANG->getMessage('msg.changePassword'):]</a></li>
            <li><a onclick="window.location.href='[:$MODEL.urlMyItems:]';" href="javascript:void(0);">[:$LANG->getMessage('msg.myitems'):]</a></li>
            <li><a href="#tab-4">[:$LANG->getMessage('msg.createItem'):]</a></li>
             <li><a onclick="window.location.href='[:$MODEL.urlMyOrders:]';" href="javascript:void(0);">[:$LANG->getMessage('msg.myOrders'):]</a></li>
        </ul>
        <div id="tab-4">
        	<h2>[:$LANG->getMessage('msg.createItem'):]</h2>
        	<form id="[:$FORM.name|escape:'html':]" class="align-center viewport-800"
                    name="[:$FORM.name|escape:'html':]" action="[:$FORM.action:]" method="post" enctype="multipart/form-data">
               [:call name="printFormHeader" form=$FORM:]
                
                <p></p>
                <label for="form_itemCategory">[:$LANG->getMessage('msg.item.category'):]:</label>
                <select dojoType="dijit.form.Select" name="categoryId">
                    [:call name="printCategoryTreeSelectBox" catList=$MODEL.categoryTree index=0 selectedIndex=$MODEL.form.categoryId:]
                </select>
                <br />
                
                <label for="form_itemVendor">[:$LANG->getMessage('msg.item.vendor'):]:</label>
                <input dojoType="dijit.form.ValidationTextBox" id="form_itemVendor"
                    style="width: 50%" type="text" name="itemVendor" value="[:$MODEL.form.itemVendor|escape:'html':]" />
                <br />
                
                <label for="form_itemCode">[:$LANG->getMessage('msg.item.code'):]:</label>
                <input dojoType="dijit.form.ValidationTextBox" id="form_itemCode"
                    style="width: 50%" type="text" name="itemCode" value="[:$MODEL.form.itemCode|escape:'html':]" />
                <br />
                
                <label for="form_itemPrice">[:$LANG->getMessage('msg.price'):]:</label>
                <input dojoType="dijit.form.ValidationTextBox" id="form_itemPrice"
                    style="width: 50%" type="text" name="itemPrice" value="[:$MODEL.form.itemPrice|escape:'html':]" />
                <br />
                
                <label for="form_itemShopPrice">[:$LANG->getMessage('msg.shopPrice'):]:</label>
                <input dojoType="dijit.form.ValidationTextBox" id="form_itemShopPrice"
                    style="width: 50%" type="text" name="itemOldPrice" value="[:$MODEL.form.itemOldPrice|escape:'html':]" />
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
                 <input id="form_itemImage" style="display: none" type="file" name="itemImage" onchange="getFileUploadName('form_itemImage','images-name')" />
				 <input type="text" id="images-name" readonly="readonly" onclick="document.getElementById('form_itemImage').click();"><button type="button" onclick="document.getElementById('form_itemImage').click();" cl >&nbsp;&nbsp;[:$LANG->getMessage('msg.selectImage'):]&nbsp;&nbsp;</button>
				<input type="hidden" name="itemImageId" value="[:$MODEL.form.itemImageId|escape:'html':]" /><br/>
        		<br />
                
                <p></p>
                <button class="btn" type="submit">&nbsp;&nbsp;&nbsp;&nbsp;[:$LANG->getMessage('msg.save'):]&nbsp;&nbsp;&nbsp;&nbsp;</button>
                <button class="btn" type="button" onclick="openUrl('[:$MODEL.form.actionCancel:]');">&nbsp;&nbsp;[:$LANG->getMessage('msg.cancel'):]&nbsp;&nbsp;</button>
            </form>
           [:call name=tinymce elName=form_itemDesc:]
        	<script type="text/javascript">           
                $('#tabs').tabs({ selected: 3 });
        	</script>
        	<br/>
        	<br/>
        	<br/>
        </div>             
    </div>
    <script>
	$(function() {
		$( "#tabs" ).tabs();
	});
    </script>
</div>