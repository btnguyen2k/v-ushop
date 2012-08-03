
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>

   <base href="[:$MODEL.basehref:]" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="[:$MODEL.page.description|escape:'html':]" />
    <meta name="keywords" content="[:$MODEL.page.keywords|escape:'html':]" />
    <meta name="author" content="GPV.COM.VN/" />
    [:assign var="LANG" value=$MODEL.language scope=root:]
    [:if isset($MODEL.user):]
        [:assign var="USER" value=$MODEL.user scope=root:]
    [:/if:]
    [:if isset($MODEL.form):]
        [:assign var="FORM" value=$MODEL.form scope=root:]
    [:/if:]
	<link rel="stylesheet" href="css/market_place.css" type="text/css" />
	<link rel="stylesheet" href="css/jquery.simplyscroll.css" type="text/css" />
	<link rel="stylesheet" href="css/simpletree.css" type="text/css" />
	<link rel="stylesheet" href="css/button.css" type="text/css" />
	<link rel="stylesheet" href="css/custom-theme/jquery-ui-1.8.22.custom.css" type="text/css" />
    <link rel="stylesheet" href="css/popup.css" type="text/css" />
    <link rel="stylesheet" href="css/menutop.css" type="text/css" />
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
	<script src="http://code.jquery.com/ui/1.8.22/jquery-ui.min.js" type="text/javascript"></script>
	<script src="http://jquery-ui.googlecode.com/svn/tags/latest/external/jquery.bgiframe-2.1.2.js" type="text/javascript"></script>
	<script src="http://jquery-ui.googlecode.com/svn/tags/latest/ui/minified/i18n/jquery-ui-i18n.min.js" type="text/javascript"></script>
	<script src="js/script.js" type="text/javascript"></script> 
	<script src="js/simpletreemenu.js" type="text/javascript"></script>
	 

  <title>[:$MODEL.page.title|escape:'html':]</title>
    [:if isset($MODEL.urlTransit):]
        <meta http-equiv="refresh" content="2; url=[:$MODEL.urlTransit:]" />
    [:/if:] 

</head>