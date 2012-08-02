<!--- main column starts-->
<div id="main">
	<h1>[:$LANG->getMessage('msg.shopList'):]</h1>
	<br>		
	[:if isset($MODEL.shopList) && count($MODEL.shopList) gt 0:]
		[:call name="paginator" paginator=$MODEL.paginator:]
		[:foreach $MODEL.shopList as $_shop:]
			 [:if $_shop->getUrlThumbnail()=='':]
                [:assign var="_urlThumbnail" value="images/shop_default.jpg":]
            [:else:]
                [:assign var="_urlThumbnail" value=$_shop->getUrlThumbnail():]
            [:/if:]
			<div class="shop" onclick="redirect('[:$_shop->getUrlView():]')">
				<div class="shop-title-blue" >[:$_shop->getTitle():]</div>
				<img src="[:$_urlThumbnail:]"  alt="" />
			</div>
			
		[:/foreach:] 
		<br style="clear:both;"/>
		[:call name="paginator" paginator=$MODEL.paginator:]
	[:else:]
		[:call name=noData:]
	[:/if:]	
		</div>
<!--- main column ends -->