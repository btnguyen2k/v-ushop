<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <base href="<:$MODEL.basehref:>" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="<:$MODEL.page.description|escape:'html':>" />
    <meta name="keywords" content="<:$MODEL.page.keywords|escape:'html':>" />
    <meta name="author" content="GPV.COM.VN/" />
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <title><:$MODEL.page.title|escape:'html':></title>
</head>

<body>
<div id="wrap"><!-- HEADER --> <!-- Background -->
<div id="header-section"><a href="<:$MODEL.urlHome:>"><img id="header-background-left" src="./img/KNbabyshop-logo-01.jpg"
    alt="" /></a> <img id="header-background-right" src="./img/KNbabyshop-banner-01.jpg" alt="" /></div>

<!-- Navigation -->
<div id="header">
<ul>
    <li><a href="<:$MODEL.urlHome:>"><:$MODEL.language->getMessage('msg.home'):></a></li>
    <:if isset($MODEL.urlLogout):>
        <li><a href="<:$MODEL.urlLogout:>"><:$MODEL.language->getMessage('msg.logout'):></a></li>
    <:else:>
        <li><a href="<:$MODEL.urlLogin:>"><:$MODEL.language->getMessage('msg.login'):></a></li>
        <li><a href="<:$MODEL.urlRegister:>"><:$MODEL.language->getMessage('msg.register'):></a></li>
    <:/if:>
    <!--
    <li><a href="#">Menu Link 1</a></li>
    <li><a href="#">Menu Link 2</a></li>
    <li class="selected">Menu Link 3</li>
    <li><a href="#">Menu Link 4</a></li>
    <li><a href="#">Menu Link 5</a></li>
    -->
</ul>
</div>

<:if !isset($DISABLE_COLUMN_LEFT):>
    <:include file='inc_column_left.tpl':>
<:/if:>

<:if !isset($DISABLE_COLUMN_RIGHT):>
    <:include file='inc_column_right.tpl':>
<:/if:>

<!-- MIDDLE COLUMN -->
<div id="middle-column"><!-- Middle column full box -->
<div class="middle-column-box-white">
<div class="middle-column-box-title-grey">Grey title</div>
<p><img src="./img/img_general.jpg" class="middle-column-img-left" width="100" alt="" />Lorem ipsum
dolor sit amet, consectetuer adipiscing elit. <a href="#">Aliquam at libero</a>. Suspendisse non
risus a diam convallis lobortis. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
Suspendisse non risus a diam convallis lobortis. Lorem ipsum dolor sit amet, consectetuer adipiscing
elit. Suspendisse non risus a diam convallis lobortis.</p>
<p><a href="#">Read more</a></p>
</div>

<!-- Middle column left section -->
<div class="middle-column-left"><!-- Middle column left box -->
<div class="middle-column-box-left-white">
<div class="middle-column-box-title-grey">Grey title</div>
<p><img src="./img/img_general.jpg" class="middle-column-img-left" width="50" alt="" />Lorem ipsum
dolor sit amet, consectetuer adipiscing elit. <a href="#">Aliquam at libero</a>. Suspendisse non
risus a diam convallis lobortis.</p>
<p><a href="#">Read more</a></p>
</div>

<!-- Middle column left box -->
<div class="middle-column-box-left-white">
<div class="middle-column-box-title-grey">Grey title</div>
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. <a href="#">Aliquam at libero</a>.
Suspendisse non risus a diam convallis lobortis.</p>
<p><a href="#">Read more</a></p>
</div>
</div>

<!-- Middle column right section -->
<div class="middle-column-right"><!-- Middle column right box -->
<div class="middle-column-box-right-white">
<div class="middle-column-box-title-grey">Grey title</div>
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. <a href="#">Aliquam at libero</a>.
Suspendisse non risus a diam convallis lobortis.</p>
</div>

<!-- Middle column right box -->
<div class="middle-column-box-right-white">
<div class="middle-column-box-title-grey">Grey title</div>
<p><img src="./img/img_general.jpg" class="middle-column-img-left" width="50" alt="" />Lorem ipsum
dolor sit amet, consectetuer adipiscing elit. <a href="#">Aliquam at libero</a>. Suspendisse non
risus a diam convallis lobortis. Suspendisse non risus a diam convallis lobortis. Suspendisse non
risus a diam convallis lobortis</p>
</div>
</div>

<!-- Middle column full box -->
<div class="middle-column-box-white">
<div class="middle-column-box-title-grey">Grey title</div>
<p class="subheading">Basic layout</p>
<p>The basic concept consiss of a three-column layout combined with individual boxes in the middle
and right columns. The layout is flexible in two ways. Firstly, the strong menu-capabilities at the
top header and left column are comphrehensive and can navigate through a content heavy website.
Secondly, by having boxes in the middle and right columns, important topics can be brought to
special attention and found more quickly than by going through the menus.</p>
<p class="subheading">Middle section</p>
<p>The text boxes in the middle column consist of two types. Firstly, boxes covering the full width,
and secondly boxes covering the half width. The number or sequence of full- or half-width boxes can
be chosen freely.</p>
<p class="subheading">Color scheme and graphics</p>
<p>The color scheme for the middle and right columns have an independent control of the box titles
and the box backgrounds. The layout also provides the possibility of inserting or removing graphics
in the middle column.</p>
<p class="subheading">Text paragraphs</p>
<p>Three types of text paragraphs are offered, namely "heading", "subheading" and normal text.</p>
</div>
</div>

<!-- FOOTER -->
<div id="footer">Copyright &copy; 2006 Your Company Name | All Rights Reserved<br />
Design by <a href="mailto:gw@actamail.com">Gerhard Erbes</a> | <a
    href="http://validator.w3.org/check?uri=referer"
    title="Validate code as W3C XHTML 1.1 Strict Compliant">W3C XHTML 1.1</a> | <a
    href="http://jigsaw.w3.org/css-validator/" title="Validate Style Sheet as W3C CSS 2.0 Compliant">W3C
CSS 2.0</a></div>
</div>
</body>
</html>