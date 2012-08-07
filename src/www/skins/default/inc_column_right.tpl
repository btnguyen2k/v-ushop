<!-- rightcolumn starts -->
<h1>[:$LANG->getMessage('msg.shop'):]</h1>
<div class="container-select" style="margin-left: 20px">
<br/>
    <select class="select" onchange="changeShop(this)">
    	<option value="[:$MODEL.urlHome:]" >[:$LANG->getMessage('msg.all'):]</option>
    	[:foreach $MODEL.shopOwners as $_shop:]
    		[:if  isset($smarty.session.SHOP_ID) && $smarty.session.SHOP_ID==$_shop->getOwnerId():]
    			<option value="[:$_shop->getUrlView():]" selected="selected">[:$_shop->getTitle():]</option>
    		[:else:]
    		 	<option value="[:$_shop->getUrlView():]" >[:$_shop->getTitle():]</option>
    		[:/if:]
    	[:/foreach:]  
    </select>
</div>

<!--
<h1>Tìm kiếm</h1>
<form class="form-mini" style="margin-top: 20px;padding-left: 20px">
		<input name="search_query" class="input-mini" type="text" />
		<input name="search" class="button" value="Search" type="submit" />
</form>	
-->
[:if !isset($USER):]
<h1  id="login">[:$LANG->getMessage('msg.login'):]</h1>
<form class="form-login" method="post" style="margin: 20px;margin-bottom: 0px" action="[:$MODEL.urlLogin:]">
	<table >
		<tr>
			<td style="font-weight: bold;">[:$LANG->getMessage('msg.username'):]:</td>
		</tr>
		<tr>
			<td><input id="username" value=""  class="textbox" name="username" type="text" /></td>
		</tr>
		<tr>
			<td style="font-weight: bold;">[:$LANG->getMessage('msg.password'):]:</td>
		</tr>
		<tr>
			<td><input  class="textbox" value="" name="password" type="password" /></td>
		</tr>
		<tr >
			<td><input name="search" class="btn" value="Đăng Nhập" type="submit" /></td>
		</tr>
	</table>
	<div align="center"><a href="javascript:void(0)" onclick="alert('[:$LANG->getMessage('msg.forgotPassword.info'):]')">[:$LANG->getMessage('msg.forgotPassword'):]</a>	</div>
</form>	
[:/if:]

<h1>[:$LANG->getMessage('msg.ads'):]</h1>
[:call name=displayAds adsList=$MODEL.adsList:]
	
