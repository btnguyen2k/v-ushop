[:assign var="LANGUAGE" value=$MODEL.language scope=root:]
[:if isset($MODEL.user):]
    [:assign var="USER" value=$MODEL.user scope=root:]
[:/if:]
[:if isset($MODEL.form):]
    [:assign var="FORM" value=$MODEL.form scope=root:]
[:/if:]

[:function name="displayCategoryList" categotyList=NULL:]

    <ul class="thumbnails" >
        [:foreach $categoryList as $_cat:]
            [:if $_cat->getUrlThumbnail()=='':]
                [:assign var="_urlThumbnail" value="img/img_general.jpg":]
            [:else:]
                [:assign var="_urlThumbnail" value=$_cat->getUrlThumbnail():]
            [:/if:]
            [:if count($_cat->getChildren()) gt 0:]            
                 <li class="span3 grid-image" name="categories" ref="popover" data-original-title="[:$_cat->getTitle()|escape:'html':]" data-content="[:$_cat->getDescription()|escape:'html':]">    
                  	<a href="javascript:void(0)" onclick="redirect('[:$_cat->getUrlView():]')" class="thumbnail">
                  		<div class="caption category-header" >[:$_cat->getTitle()|escape:'html':]</div>
                   		<img alt="[:$_cat->getTitle()|escape:'html':]" src="[:$_urlThumbnail:]"/>          
                 	</a>	
                </li>
           [:else:]
           	 	<li class="span3 grid-image" name="categories" ref="popover" data-original-title="[:$_cat->getTitle()|escape:'html':]" data-content="[:$_cat->getDescription()|escape:'html':]">    
                  	<a href="javascript:void(0)" onclick="redirect('[:$_cat->getUrlView():]')" class="thumbnail">
                  		<div class="caption category-header" >[:$_cat->getTitle()|escape:'html':]</div>
                   		<img alt="[:$_cat->getTitle()|escape:'html':]" src="[:$_urlThumbnail:]"/>          
                 	</a>	
                </li>           
           [:/if:]
        [:foreachelse:]
            <li class="span12">[:$MODEL.language->getMessage('msg.nodata'):]</li>
        [:/foreach:]
        [:call name=popover elName='categories' placement='top':]
    </ul>
[:/function:]

[:function name="displayCategoryItemList" itemList=NULL cart=NULL:]
    <ul class="thumbnails">
        [:foreach $itemList as $_item:]
            [:call name="displayCategoryItem" cart=$cart item=$_item:]
        [:foreachelse:]
            <li class="span12">[:$MODEL.language->getMessage('msg.nodata'):]</li>
        [:/foreach:]
    </ul>
[:/function:]

[:function name=displayCategoryItem cart=NULL item=NULL:]
    [:if $item->getUrlThumbnail()=='':]
        [:assign var="_urlThumbnail" value="img/img_general.jpg":]
    [:else:]
        [:assign var="_urlThumbnail" value=$item->getUrlThumbnail():]
    [:/if:]
    <li class="span3  grid-image" style="position: relative;">    
      	<a href="javascript:void(0)" class="thumbnail" onclick="redirect('[:$item->getUrlView():]')">
      		<div class="caption category-header" >[:$item->getTitle()|escape:'html':]<img src="img/new.gif"> </div>
      		<div class="label label-info" style="position: absolute; top: 40px;right: 5px;">[:if $item->getCode()!='':][:$item->getCode()|escape:'html':][:/if:]</div>
       		<img src="[:$_urlThumbnail:]" alt="">           
     	</a>     
     	<div style="padding-top: 10px;"> 
     		 <form method="post" action="[:$smarty.server.SCRIPT_NAME:]/addToCart">    
     		 	<input type="hidden" name="item" value="[:$item->getId():]" />
                <input type="hidden" name="quantity" value="1" />       
         		<div class="btn-group" style="float: left;">
                  	<button class="btn btn-warning" type="button" onclick="redirect('[:$item->getUrlView():]')">[:$LANGUAGE->getMessage('msg.view'):]</button>
                  	<button class="btn btn-warning" type="button" onclick="this.form.submit(); return 0;"><img alt="" src="img/cart_add.png"></button>
                </div> 
                <span class="label label-important" style="font-size: 17px;float: right;height: 17px;margin-left: 5px;margin-top: 5px">[:$item->getPriceForDisplay():]</span>
             </form>    	   		
        </div> 
        <br/>
        <div>  
         	[:if $cart->existInCart($item):] [:$LANGUAGE->getMessage('msg.inCart'):]: <strong>[:$cart->getItem($item)->getQuantity():]</strong>[:/if:]
        </div> 
    </li>
     
   <!-- <li class="span3">
        <div class="thumbnail">
            <img src="[:$_urlThumbnail:]" alt="[:$item->getTitle()|escape:'html':]" width="100px" height="100px" />  
            <div class="caption">
                <h5>[:if $item->getCode()!='':][:$item->getCode()|escape:'html':] | [:/if:][:$item->getTitle()|escape:'html':]</h5>
                <p>[:$LANGUAGE->getMessage('msg.item.price'):]: <strong>[:$item->getPriceForDisplay():]</strong></p>
                <p>[:if $item->getVendor()!='':][:$MODEL.language->getMessage('msg.item.vendor'):]: <strong>[:$item->getVendor()|escape:'html':]</strong>[:else:]&nbsp;[:/if:]</p>
                <p>
                    <form method="post" action="[:$smarty.server.SCRIPT_NAME:]/addToCart">
                        <input type="hidden" name="item" value="[:$item->getId():]" />
                        <input type="hidden" name="quantity" value="1" />
                        <button onclick="this.form.submit(); return 0;" class="btn btn-warning">[:$LANGUAGE->getMessage('msg.addToCart'):]</button>
                        [:if $cart->existInCart($item):]| [:$LANGUAGE->getMessage('msg.inCart'):]: <strong>[:$cart->getItem($item)->getQuantity():]</strong>[:/if:]
                    </form>
                </p>
            </div>
        </div>
    </li> -->
[:/function:]

[:function name=printFormHeader form=NULL:]
    [:if isset($form.errorMessages) && count($form.errorMessages) gt 0:]
        [:foreach $form.errorMessages as $msg:]
           <div class="errorMsg">[:$msg:]</div>
        [:/foreach:]
        <br />
    [:/if:]
    [:if isset($form.infoMessages) && count($form.infoMessages) gt 0:]
        [:foreach $form.infoMessages as $msg:]
            <div class="infoMsg">[:$msg:]</div>
        [:/foreach:]
        <br />
    [:/if:]
[:/function:]

[:function name=tinymce elName='':]
    <!-- TinyMCE -->
    <script type="text/javascript" src="./tinymce/tiny_mce.js"></script>
    <script type="text/javascript">
        tinyMCE.init({
            mode    : "exact",
            elements: "[:$elName:]",
            theme   : "advanced",
            plugins : "autolink,lists,table,advhr,advimage,advlink,emotions,preview,media,searchreplace,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,template,inlinepopups,wordcount",

            // Theme options
            theme_advanced_buttons1: "help,code,preview,fullscreen,|,undo,redo,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontsizeselect",
            theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,image,|,forecolor,backcolor",
            theme_advanced_buttons3: "tablecontrols,hr,advhr,removeformat,|,sub,sup,|,charmap",
            theme_advanced_toolbar_location  : "top",
            theme_advanced_toolbar_align     : "left",
            theme_advanced_statusbar_location: "bottom",
            theme_advanced_resizing          : false,
            entity_encoding: "raw"
            //content_css    : false
        });
    </script>
    <!-- /TinyMCE -->
[:/function:]

[:function name=scroller elId='':]
    <!-- Scroller -->
   <script src="js/jquery.simplyscroll.js" type="text/javascript"></script>    
   <script type="text/javascript">       
        (function($) {
        	$(function() { //on DOM ready
        		$("#[:$elId:]").simplyScroll({
        			customClass: 'vert',
        			orientation: 'vertical',
                    auto: true,
                    manualMode: 'loop',
        			frameRate: 24,			
        			speed: 1
        		});
        	});
        })(jQuery);      
    </script>
    <!-- /Scroller -->
[:/function:]


[:function name=carousel:]
    <!-- Carousel -->
   <script src="bootstrap/js/bootstrap-carousel.js" type="text/javascript"></script>  
   <script type="text/javascript">
   		$(function() {
			$('.carousel').carousel();
		});
    </script>
    <!-- /Carousel -->
[:/function:]

[:function name=popover elName='' placement='':]
    <!-- Popover -->
  <script src="bootstrap/js/bootstrap-popover.js" type="text/javascript"></script> 
   <script type="text/javascript">
   		$(function ()  
			{ $("[name='[:$elName:]']").popover({placement:'[:$placement:]'});  
		}); 
    </script>
    <!-- /Popover -->
[:/function:]
