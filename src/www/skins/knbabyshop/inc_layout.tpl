<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <base href="[:$MODEL.basehref:]" />
    <title>[:$MODEL.page.title|escape:'html':]</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="[:$MODEL.page.description|escape:'html':]" />
    <meta name="keywords" content="[:$MODEL.page.keywords|escape:'html':]" />
    <meta name="author" content="GPV.COM.VN/" />
    [:if isset($MODEL.urlTransit):]
        <meta http-equiv="refresh" content="2; url=[:$MODEL.urlTransit:]" />
    [:/if:]
</head>
<body>
    <div>
        <a href="[:$MODEL.urlHome:]"><img src="images/KNbabyshop-logo-01.jpg"
            width="237" height="123" class="float" alt="setalpm" /></a>
        <div class="topnav">
            <span style="float: right;">Welcome
                [:if isset($MODEL.urlLogout):]
                    <strong><a href="[:$MODEL.urlProfileCp:]">[:$MODEL.user.email|escape:'html':]</a></strong>
                [:else:]
                    &nbsp;
                    <strong>
                        <a href="[:$MODEL.urlLogin:]">[:$MODEL.language->getMessage('msg.login'):]</a> &nbsp;
                        |
                        &nbsp; <a href="[:$MODEL.urlRegister:]">[:$MODEL.language->getMessage('msg.register'):]</a>
                    </strong>
                [:/if:]
            </span>
            <!--
            <select>
                <option>Type of Product</option>
                <option>Clothing</option>
                <option>Accessories</option>
                <option>Clothing</option>
                <option>Accessories</option>
            </select>
            -->
            <!--
		    <span>Language:</span> <a href="#"><img src="images/flag1.jpg" alt="" width="21" height="13" /></a> <a href="#"><img src="images/flag2.jpg" alt="" width="21" height="13" /></a> <a href="#"><img src="images/flag3.jpg" alt="" width="21" height="13" /></a>
            -->
        </div>
        <ul id="menu">
            <li><a href="[:$MODEL.urlHome:]"><img src="images/btn_home_[:$MODEL.language->getName():].gif" alt="" width="110" height="32" /></a></li>
            [:if isset($MODEL.urlLogout):]
                <li><a href="[:$MODEL.urlProfileCp:]"><img src="images/btn_profile_[:$MODEL.language->getName():].gif" alt="" width="110" height="32" /></a></li>
            [:else:]
                <li><a href="[:$MODEL.urlLogin:]"><img src="images/btn_login_[:$MODEL.language->getName():].gif" alt="" width="110" height="32" /></a></li>
                <li><a href="[:$MODEL.urlRegister:]"><img src="images/btn_register_[:$MODEL.language->getName():].gif" alt="" width="110" height="32" /></a></li>
            [:/if:]
            <li><a href="[:$MODEL.cart->getUrlView():]"><img src="images/btn_cart_[:$MODEL.language->getName():].gif" alt="" width="110" height="32" /></a></li>
            <li><a href="[:$MODEL.cart->getUrlCheckout():]"><img src="images/btn_checkout_[:$MODEL.language->getName():].gif" alt="" width="110" height="32" /></a></li>
        </ul>
	</div>
    <div id="content">
        <div id="sidebar">
            <div id="navigation">
                <ul>
                    <li><a href="[:$MODEL.urlHome:]">[:$MODEL.language->getMessage('msg.home'):]</a></li>
                    [:foreach $MODEL.onMenuPages as $page:]
                        <li><a href="[:$page->getUrlView():]">[:$page->getTitle()|escape:'html':]</a></li>
                    [:/foreach:]
				</ul>
				<div id="cart">
					<strong>[:$MODEL.language->getMessage('msg.cart'):]:</strong>
                    <br />
                    [:count($MODEL.cart->getItems()):] [:$MODEL.language->getMessage('msg.items'):]
                </div>
            </div>
            <div>
                <div class="block-title-1">
                    [:$MODEL.language->getMessage('msg.categories'):]
                </div>
				<!-- <img src="images/title1.gif" alt="" width="233" height="41" /><br /> -->
                <ul class="categories">
                    [:foreach $MODEL.categoryTree as $cat:]
                        <li><a title="[:$cat->getTitle()|escape:'html':]" href="[:$cat->getUrlView():]">[:$cat->getTitleForDisplay(40)|escape:'html':]</a></li>
                    [:/foreach:]
                </ul>
                <!--
				<img src="images/title2.gif" alt="" width="233" height="41" /><br />																																																																																																																																																															<div class="inner_copy"><a href="http://www.bestfreetemplates.org/">free templates</a><a href="http://www.bannermoz.com/">banner templates</a></div>
				<div class="review">
					<a href="#"><img src="images/pic1.jpg" alt="" width="181" height="161" /></a><br />
					<a href="#">Product 07</a><br />
					<p>Dolor sit amet, consetetur sadipscing elitr, seddiam nonumy eirmod tempor. invidunt ut labore et dolore magna </p>
					<img src="images/stars.jpg" alt="" width="118" height="20" class="stars" />
				</div>
                -->
            </div>
        </div>
        <div id="main">

            <!-- <img src="images/photo.jpg" alt="" width="682" height="334" border="0" usemap="#Map" /> -->
            <!--
                <img src="images/KNbabyshop-banner-01.jpg" alt="" width="682" border="0" usemap="#Map" />
            <br />
            -->
            <!--
            <div id="inside">
				<img src="images/title3.gif" alt="" width="159" height="15" /><br />
				<div class="info">
					<img src="images/pic2.jpg" alt="" width="159" height="132" />
					<p>Dolor sit amet, consetetur sadipscing elitr, seddiam nonumy eirmod tempor. invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. Lorem ipsum dolor sit amet, consetetur sadip- scing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. Lorem ipsum dolor sit amet, consetetur. </p>
					<a href="#" class="more"><img src="images/more.gif" alt="" width="106" height="28" /></a>
				</div>
				<img src="images/title4.gif" alt="" width="159" height="17" /><br />
				<div id="items">
					<div class="item">
						<a href="#"><img src="images/item1.jpg" width="213" height="192" /></a><br />
						<p><a href="#">Product 01</a></p><span class="price">$125</span><br />
					</div>
					<div class="item center">
						<a href="#"><img src="images/item2.jpg" width="213" height="192" /></a><br />
						<p><a href="#">Product 02</a></p><span class="price">$215</span><br />
					</div>
					<div class="item">
						<a href="#"><img src="images/item3.jpg" width="213" height="192" /></a><br />
						<p><a href="#">Product 03</a></p><span class="price">$85</span><br />
					</div>
					<div class="item">
						<a href="#"><img src="images/item4.jpg" width="213" height="192" /></a><br />
						<p><a href="#">Product 04</a></p><span class="price">$35</span><br />
					</div>
					<div class="item center">
						<a href="#"><img src="images/item5.jpg" width="213" height="192" /></a><br />
						<p><a href="#">Product 05</a></p><span class="price">$27</span><br />
					</div>
					<div class="item">
						<a href="#"><img src="images/item6.jpg" width="213" height="192" /></a><br />
						<p><a href="#">Product 06</a></p><span class="price">$40</span><br />
					</div>
				</div>
			</div>
            -->
		</div>
	</div>
	<div id="footer">
		<img src="images/cards.jpg" alt="" width="919" height="76" />
		<ul>
			<li><a href="#">Home page</a> |</li>
			<li><a href="#">New Products</a> |</li>
			<li><a href="#">All Products</a> |</li>
			<li><a href="#">Reviews</a> |</li>
			<li><a href="#">F.A.Q.</a> |</li>
			<li><a href="#">Contacts</a></li>
		</ul>
		<p>Copyright ©. All rights reserved. Design by <a href="http://www.bestfreetemplates.info" title="Free CSS Templates" target="_blank" class="bft">BFT</a></p>																																																																				<div class="inner_copy"><a href="http://www.beautifullife.info/">beautiful</a><a href="http://www.grungemagazine.com/">grunge</a></div>
	</div>
    <!--
    <map name="Map">
        <area shape="rect" coords="16,306,159,326" href="#">
    </map>
    -->
</body>
</html>
