<!-- MIDDLE COLUMN -->
<div id="main" [:if isset($DISABLE_COLUMN_RIGHT)&&isset($DISABLE_COLUMN_LEFT):]style="width: 870px"[:else:]style="width: 680px"[:/if:]>
	<h1>[:$LANG->getMessage('msg.profile'):]</h1>
	<br/>
	[:call name=printFormHeader form=$MODEL.form:]
	
    <div id="tabs">
        <ul>
        	<li><a href="#tabs-1">[:$LANG->getMessage('msg.shop.information'):]</a></li>
        	<li><a href="#tabs-2">[:$LANG->getMessage('msg.changePassword'):]</a></li>
            <li><a onclick="window.location.href='[:$MODEL.urlMyItems:]';" href="javascript:void(0);">[:$LANG->getMessage('msg.myitems'):]</a></li>
        </ul>
        <div id="tabs-1">
        	<form method="post" id="userInformation" name="frmUserInformation" enctype="multipart/form-data" action="[:$MODEL.urlProfile:]">
        		<table width="100%">
        			<tr>
        				<td colspan="4"><h2>[:$LANG->getMessage('msg.accountInformation'):]</h2></td>
        			</tr>
        			<tr>
        				<td class="lable" width="15%">[:$LANG->getMessage('msg.user.email'):] :</td>
        				<td width="35%"><input type="text" value="[:$MODEL.form.email|escape:'html':]" name="email" /></td>
        				<td class="lable" width="15%">[:$LANG->getMessage('msg.user.fullname'):] :</td>
        				<td width="35%"><input type="text" value="[:$MODEL.form.fullname|escape:'html':]" name="fullname" /></td>
        			</tr>
                </table>
                <table width="100%">
        			<tr>
        				<td colspan="3"><h2>[:$LANG->getMessage('msg.shop.information'):]</h2></td>
        			</tr>
        			<tr>
        				<td class="lable" width="15%" valign="top">[:$LANG->getMessage('msg.shop.name'):]:</td>
        				<td valign="top"><input type="text" value="[:$MODEL.form.shopTitle|escape:'html':]" name="shopTitle" style="width: 40%" /></td>
                        <td rowspan="3" valign="top">
                            [:if isset($MODEL.form.urlShopImage):]
                                [:assign var="_urlThumbnail" value=$MODEL.form.urlShopImage:]
                            [:else:]
                                [:assign var="_urlThumbnail" value="images/shop_default.jpg":]
                            [:/if:]
                            <img alt="" src="[:$_urlThumbnail:]" width="230" height="250" style="margin: 8px;border: 1px solid #DCDCDC;">
                        </td>
        			</tr>
        			<tr>
        				<td class="lable" width="15%" valign="top">[:$LANG->getMessage('msg.image'):]:</td>
        				<td valign="top">
                            <input id="form_categoryImage" style="display: none" type="file" name="shopImage" onchange="getFileUploadName('form_categoryImage','images-name')" />
							<input type="text" id="images-name" readonly="readonly" onclick="document.getElementById('form_categoryImage').click();" style="width: 40%" />
                            <button type="button" onclick="document.getElementById('form_categoryImage').click();" >&nbsp;&nbsp;[:$LANG->getMessage('msg.selectImage'):]&nbsp;&nbsp;</button>
        					<input type="hidden" name="shopImageId" value="" />
                            <br/>
						</td>
        			</tr>
                    <tr>
                        <td class="lable" width="15%" valign="top">[:$LANG->getMessage('msg.shop.location'):]:</td>
                        <td valign="top">
                            <input type="text" value="[:$MODEL.form.shopLocation|escape:'html':]" name="shopLocation" style="width: 40%" />
                            <button type="button" onclick="openPopupTestLocation('#popupLocation', this.form.shopLocation.value);">&nbsp;&nbsp;[:$LANG->getMessage('msg.testLocation'):]&nbsp;&nbsp;</button>
                            <br />
                            <small><i>[:$LANG->getMessage('msg.testLocation.hint'):]</i></small>
                        </td>
                    </tr>
        		</table> 
        		<a class="button" href="javascript:void(0)" onclick="submitForm('userInformation')"><span>&nbsp;&nbsp;[:$LANG->getMessage('msg.save'):]</span></a>
        	</form>
        	<br/><br/><br/>
        </div>
        <div id="tabs-2">
        	<form method="post" id="changePassword" name="frmChangePassword" action="[:$MODEL.urlChangePassword:]" >
        		<table width="100%">
        			<tr>
        				<td colspan="2"><h2>[:$LANG->getMessage('msg.account'):] - [:$MODEL.form.username|escape:'html':]</h2><br/></td>
        			</tr>        			
        			<tr>
        				<td class="lable">[:$LANG->getMessage('msg.profile.currentPassword'):]:</td>
        				<td><input type="password" value="" name="currentPassword" /></td>
        			</tr>
        			<tr>
        				<td class="lable">[:$LANG->getMessage('msg.profile.newPassword'):]:</td>
        				<td ><input type="password" name="newPassword" /></td>
        			</tr>
        			<tr>
        				<td class="lable">[:$LANG->getMessage('msg.profile.confirmedPassword'):]:</td>
        				<td ><input type="password" name="confirmedNewPassword" /></td>
        			</tr>
        		</table>
        		<br/>
        		<a class="button" href="javascript:void(0)" onclick="submitForm('changePassword')"><span>&nbsp;&nbsp;[:$LANG->getMessage('msg.save'):]</span></a><br/><br/>        
        	</form>

        	<script type="text/javascript">
            var address= document.location.href;
            if (address.indexOf('changePassword') > 0) {
                $('#tabs').tabs({ selected: 1 });
            }
        	</script>
        </div>       
    </div>
    <script>
	$(function() {
		$( "#tabs" ).tabs();
	});
    </script>
</div>