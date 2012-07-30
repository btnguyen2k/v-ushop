<!--header -->
    <div id="header">
        <br/>
        <h4 style="padding-left: 20px"> MUA LẺ TRỰC TUYẾN </h4>
		<div id="header-links">
            <p>
                <a href="[:$MODEL.cart->getUrlView():]"><img src="images/shoppingcart.jpg" alt="some_text"/>
                    [:$MODEL.language->getMessage('msg.cart.numItems'):]: <strong>[:$MODEL.cart->getTotalItems():]</strong>,
                    [:$MODEL.language->getMessage('msg.cart.totalPrice'):]: <strong>[:$MODEL.cart->getTotalPriceForDisplay():]</strong>
    			</a>
    		</p>
    		[:if isset($USER):]
                <p style="font-weight: bold;font-size: 12px">
                    [:$LANG->getMessage('msg.hello'):] [:$USER->getDisplayName():]
                    [:if $USER->getGroupId() != $USER_GROUP_ADMIN:]| <a href="[:$MODEL.urlProfile:]">[:$LANG->getMessage('msg.profile'):]</a>[:/if:]
                    | <a href="[:$MODEL.urlLogout:]">[:$LANG->getMessage('msg.logout'):]</a>
                </p>
    		[:else:]
                <a href="javascript:void(0)" onclick="login()" style="font-weight: bold;font-size: 12px">[:$LANG->getMessage('msg.login'):]</a>
    		[:/if:]
		</div>
	</div>
<!--/ header ends-->
		
<!-- navigation starts-->
<div  id="nav" align="center">
    <ul>
        <li><a href="[:$MODEL.urlHome:]" class="home">&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
        [:foreach $MODEL.categoryTree as $_cat:]
            <li><a href="[:$_cat->geturlView():]">[:$_cat->getTitle()|escape:'html':]</a></li>
        [:/foreach:]
        [:foreach $MODEL.onMenuPages as $page:]
            <li><a href="[:$page->getUrlView():]">[:$page->getTitle()|escape:'html':]</a></li>
        [:/foreach:]
    </ul>
</div>
<!--/ navigation ends-->		
	
<!-- header photo start-->				
	<div id="header-photo">
	
		<h1 id="logo-text"><a href="index.html" title=""></a></h1>		
		<h2 id="slogan">Sành điệu và thời trang nhất. Chỉ có tại MUALE.COM.VN</h2>	
		</br>	
	</div>	
<!--/ header photo ends-->

<!-- sidebar top -->
[:if isset($MODEL.hotItems) && count($MODEL.hotItems) gt 0:]
	<div class="sidebar-top">
		<h1>Sản Phẩm Nổi Bật Nhất</h1>
		<ul id="scroller" >
			[:foreach $MODEL.hotItems as $_item:]	
				 [:if $_item->getUrlThumbnail()=='':]
                    [:assign var="_urlThumbnail" value="img/img_general.jpg":]
                [:else:]
                    [:assign var="_urlThumbnail" value=$_item->getUrlThumbnail():]
                [:/if:]			
            	<li onclick="redirect('[:$_item->getUrlView():]')"><img src="[:$_urlThumbnail:]" class="sanpham" alt="">[:$_item->getTitle():]</li>
           [:/foreach:]
        </ul>
	</div>
	[:call name=autoScroller elName=scroller auto='yes':]
[:/if:]
<!--/ sidebar top end-->