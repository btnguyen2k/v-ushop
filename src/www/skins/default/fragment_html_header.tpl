
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>

    <meta name="Description" content="Information architecture, Web Design, Web Standards." />
    <meta name="Keywords" content="your, keywords" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Distribution" content="Global" />
    <meta name="Author" content="Erwin Aligam - ealigam@gmail.com" />
    <meta name="Robots" content="index,follow" />
	<base href="[:$MODEL.basehref:]" />
	<link rel="stylesheet" href="css/market_place.css" type="text/css" />
	<link rel="stylesheet" href="css/jquery.simplyscroll.css" type="text/css" />
	
	<script src="js/jquery.js" type="text/javascript"></script>  
	<script src="js/jquery.min.js" type="text/javascript"></script>  
	<script src="js/jquery.tools.min.js" type="text/javascript"></script>  
	<script src="js/jquery.simplyscroll.js" type="text/javascript"></script>  
	<script src="js/script.js" type="text/javascript"></script> 

  <title>[:$MODEL.page.title|escape:'html':]</title>
    [:if isset($MODEL.urlTransit):]
        <meta http-equiv="refresh" content="2; url=[:$MODEL.urlTransit:]" />
    [:/if:] 

</head>