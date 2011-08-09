<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <base href="[:$MODEL.basehref:]" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="[:$MODEL.page.description|escape:'html':]" />
    <meta name="keywords" content="[:$MODEL.page.keywords|escape:'html':]" />
    <meta name="author" content="vCatalog ([:$MODEL.APP_VERSION:])" />
    <link href="templatemo_style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="stylesheet/styles.css" />
    <link href="custom.css" rel="stylesheet" type="text/css" />
    <title>[:$MODEL.page.title|escape:'html':]</title>
    [:if isset($MODEL.urlTransit):]
        <meta http-equiv="refresh" content="2; url=[:$MODEL.urlTransit:]" />
    [:/if:]
    <script language="javascript" type="text/javascript">
    function clearText(field) {
        if (field.defaultValue == field.value) field.value = '';
        else if (field.value == '') field.value = field.defaultValue;
    }
    </script>
    <script language="javascript" type="text/javascript" src="scripts/mootools-1.2.1-core.js"></script>
    <script language="javascript" type="text/javascript" src="scripts/mootools-1.2-more.js"></script>
    <script language="javascript" type="text/javascript" src="scripts/slideitmoo-1.1.js"></script>
    <script language="javascript" type="text/javascript">
    window.addEvents({
        'domready': function(){
            /* thumbnails example , div containers */
            new SlideItMoo({
                overallContainer: 'SlideItMoo_outer',
                elementScrolled: 'SlideItMoo_inner',
                thumbsContainer: 'SlideItMoo_items',
                itemsVisible: 5,
                elemsSlide: 3,
                duration: 200,
                itemsSelector: '.SlideItMoo_element',
                itemWidth: 140,
                showControls:1});
    		}
    	});
    </script>
</head>
<body>
    <div id="templatemo_wrapper">
    	<div id="templatemo_menu">
            <ul>
                [:assign var="_index" value=1:]
                <li><a href="[:$MODEL.urlHome:]"[:if $MODEL.reqModule=='home':]class="current"[:/if:]><span>.[:$_index|indent:1:0:]</span>[:$MODEL.language->getMessage('msg.home'):]</a></li>
                [:assign var="_index" value=$_index+1:]
                [:foreach $MODEL.onMenuPages as $page:]
                    <li><a href="[:$page->getUrlView():]"[:if $MODEL.reqModule=='page' && $MODEL.reqAction==$page->getId():]class="current"[:/if:]><span>.[:$_index|indent:1:0:]</span>[:$page->getTitle()|escape:'html':]</a></li>
                    [:assign var="_index" value=$_index+1:]
                [:/foreach:]
                <li><a href="[:$MODEL.cart->getUrlView():]"[:if $MODEL.reqModule=='cart':]class="current"[:/if:]><span>.[:$_index|indent:1:0:]</span>[:$MODEL.language->getMessage('msg.cart'):]</a></li>
                [:assign var="_index" value=$_index+1:]
                [:if isset($MODEL.urlAdmin):]
                    <li class="float-right"><a href="[:$MODEL.urlAdmin:]"><span>.[:$_index|indent:1:0:]</span><strong>[:$MODEL.language->getMessage('msg.adminCp'):]</strong></a></li>
                    [:assign var="_index" value=$_index+1:]
                [:/if:]
            </ul>
        </div> <!-- end of templatemo_menu -->

        <div id="templatemo_header_bar">
            <div id="header">
                <div class="right"></div>
                <h1>
                    <a href="[:$MODEL.urlHome:]" target="_parent">
                        <img src="images/templatemo_logo.png" alt="Logo" />
                        <span>[:$MODEL.page.slogan|escape:'html':]</span>
                    </a>
                </h1>
            </div>

            <div id="search_box">
                <form action="#" method="get">
                    <input type="text" value="[:$MODEL.language->getMessage('msg.search.hint'):]"
                        name="q" size="10" id="searchfield" title="[:$MODEL.language->getMessage('msg.search'):]"
                        onfocus="clearText(this)" onblur="clearText(this)" />
                    <input type="submit" name="[:$MODEL.language->getMessage('msg.search'):]" value=""
                        title="[:$MODEL.language->getMessage('msg.search'):]" id="searchbutton" />
                </form>
            </div>
        </div> <!-- end of templatemo_header_bar -->

        <div class="cleaner"></div>

        <div id="sidebar">
            <div class="sidebar_top"></div><div class="sidebar_bottom"></div>

            <div class="sidebar_section">
                <h2>[:$MODEL.language->getMessage('msg.members'):]</h2>

                [:if isset($MODEL.urlLogout):]
                [:else:]
                    <form action="[:$MODEL.urlLogin:]" method="post">
                        <label>[:$MODEL.language->getMessage('msg.email'):]</label>
                        <input type="text" value="" name="email" size="10" class="input_field" title="[:$MODEL.language->getMessage('msg.email'):]" />
                        <label>[:$MODEL.language->getMessage('msg.password'):]</label>
                        <input type="password" value="" name="password" class="input_field" title="[:$MODEL.language->getMessage('msg.password'):]" />
                        [:if isset($MODEL.urlRegister):]
                            <a href="[:$MODEL.urlRegister:]">[:$MODEL.language->getMessage('msg.register'):]</a>
                        [:/if:]
                        <input type="submit" value="[:$MODEL.language->getMessage('msg.login'):]" id="submit_btn" title="[:$MODEL.language->getMessage('msg.login'):]" />
                    </form>
                [:/if:]

                <div class="cleaner"></div>
            </div>

            <div class="sidebar_section">
                <h2>[:$MODEL.language->getMessage('msg.categories'):]</h2>
                [:if isset($MODEL.categoryTree):]
                    <ul class="categories_list">
                        [:foreach $MODEL.categoryTree as $cat:]
                            <li>
                                <a title="[:$cat->getTitle()|escape:'html':]" href="[:$cat->getUrlView():]">[:$cat->getTitleForDisplay(30)|escape:'html':]</a>
                                <!--
                                [:if count($cat->getChildren()) gt 0:]
                                    <ul style="list-style-type: none; padding-left: 20px">
                                        [:foreach $cat->getChildren() as $child:]
                                            <li><a title="[:$child->getTitle()|escape:'html':]" href="[:$child->getUrlView():]">[:$child->getTitleForDisplay(30)|escape:'html':]</a></li>
                                        [:/foreach:]
                                    </ul>
                                [:/if:]
                                -->
                            </li>
                        [:/foreach:]
                    </ul>
                [:/if:]
            </div>

            <!--
            <div class="sidebar_section">
                <h2>Discounts</h2>
                <div class="image_wrapper"><a href="http://www.templatemo.com/page/7" target="_parent"><img src="images/image_01.jpg" alt="product" /></a></div>
                <div class="discount"><span>25% off</span> | <a href="#">Read more</a></div>
            </div>
            -->
        </div> <!-- end of sidebar -->

        [:if isset($CONTENT):][:include file=$CONTENT:][:/if:]
    </div> <!-- end of templatemo_wrapper -->

    <div id="templatemo_footer_wrapper">
        <div id="templatemo_footer">
            <ul class="footer_menu">
                <li><a href="[:$MODEL.urlHome:]">[:$MODEL.language->getMessage('msg.home'):]</a></li>
                [:foreach $MODEL.onMenuPages as $page:]
                    <li><a href="[:$page->getUrlView():]">[:$page->getTitle()|escape:'html':]</a></li>
                [:/foreach:]
                <li class="last_menu"><a href="[:$MODEL.cart->getUrlView():]">[:$MODEL.language->getMessage('msg.cart'):]</a></li>
            </ul>

        Copyright © 2048 <a href="#">Your Company Name</a> |
        <a href="http://www.iwebsitetemplate.com" target="_parent">Website Templates</a> by <a href="http://www.templatemo.com" target="_parent">Free CSS Template</a></div>
	<!-- end of footer -->

</div> <!-- end of footer_wrapper -->
<div align=center>This template  downloaded form <a href='http://all-free-download.com/free-website-templates/'>free website templates</a></div></body>
</html>