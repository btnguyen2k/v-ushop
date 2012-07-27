<!--- main column starts-->
<div id="main">
	<h1>DANH SÁCH SHOP</h1>
	<br></br>			
	[:if isset($MODEL.shopOwners) && count($MODEL.shopOwners) gt 0:]
		[:foreach $MODEL.shopOwners as $_shop:]
			 [:if $_shop->getUrlThumbnail()=='':]
                [:assign var="_urlThumbnail" value="images/shop_default.jpg":]
            [:else:]
                [:assign var="_urlThumbnail" value=$_shop->getUrlThumbnail():]
            [:/if:]
			<div class="shop" onclick="redirect('[:$_shop->getUrlView():]')">
				<div class="[:if $_shop@index %2==0:]shop-title-blue[:else:]shop-title-red[:/if:]">[:$_shop->getTitle():]</div>
				<img src="[:$_urlThumbnail:]"  alt="" />
			</div>
			
		[:/foreach:] 
	[:else:]
		[:call name=noData:]
	[:/if:]	
		</div>
<!--- main column ends -->