[:assign var="LANGUAGE" value=$MODEL.language scope=root:]
[:if isset($MODEL.user):]
    [:assign var="USER" value=$MODEL.user scope=root:]
[:/if:]
[:if isset($MODEL.form):]
    [:assign var="FORM" value=$MODEL.form scope=root:]
[:/if:]
[:assign var="USER_GROUP_ADMIN" value=1 scope=root:]
[:assign var="USER_GROUP_SHOP_OWNER" value=2 scope=root:]

[:function name=printFormHeader form=NULL:]
    [:if isset($form.errorMessages) && count($form.errorMessages) gt 0:]
    	<ul id="mess" style="text-align: left;">
        [:foreach $form.errorMessages as $msg:]
          <li> <div class="errorMsg" >[:$msg:]</div></li>
        [:/foreach:]
        </ul>
        <script type="text/javascript">
    		jumpTo('mess');
    	</script>
    [:/if:]
    [:if isset($form.infoMessages) && count($form.infoMessages) gt 0:]
    	<ul id="mess" style="text-align: left;">
        [:foreach $form.infoMessages as $msg:]
            <li><div class="infoMsg">[:$msg:]</div></li>
        [:/foreach:]
        </ul>
         <script type="text/javascript">
    		jumpTo('mess');
    	</script>
    [:/if:]
   
[:/function:]


[:function name=categoryTree:]
    <ul id="treemenu1" class="treeview" style="cursor: pointer;">
     [:foreach $MODEL.categoryTree as $cat:] 	
     		 <li style="font-weight: bold;" class="submenu">[:$cat->getTitleForDisplay(30)|escape:'html':]
         		<ul>
         		[:foreach $cat->getChildren() as $child:]
         			[:if $child->hasChildren():]
                		<li >[:$child->getTitleForDisplay(25)|escape:'html':]
                    		<ul>
                        		[:foreach $child->getChildren() as $child1:]
                            		<li onclick="redirect('[:$child1->getUrlView():]')">[:$child1->getTitleForDisplay(25)|escape:'html':]</li>
                            	[:/foreach:]  
                    		</ul>
                    	</li>
                   	[:else:]
                   		<li onclick="redirect('[:$child->getUrlView():]')">[:$child->getTitleForDisplay(25)|escape:'html':]</li>               	
                   	[:/if:]
                    	
            	 [:foreachelse:]
                        <li>Chưa có sản phẩm</li>
                 [:/foreach:]       	
         		</ul>
         	</li> 	
         	
     [:/foreach:]	
    </ul>
    <script type="text/javascript">
   		ddtreemenu.createTree("treemenu1", true)
    </script>
[:/function:]

[:function name=autoScroller elName='' auto='yes':]
	<script src="js/jquery.simplyscroll.js" type="text/javascript"></script>
	<script type="text/javascript">
		if('[:$auto:]'=='yes'){
            (function($) {
            	$(function() {
            		$("#[:$elName:]").simplyScroll();
            	});
            })(jQuery);
		}else{
			(function($) {
            	$(function() {
            		$("#[:$elName:]").simplyScroll({
            			auto: false,
            			speed: 5
            		});
            	});
            })(jQuery);
		}
	</script>
[:/function:]

[:function name="displayCategoryItemList" itemList=NULL cart=NULL:]    
    [:foreach $itemList as $_item:]
        [:call name="displayCategoryItem" cart=$cart item=$_item:]
    [:foreachelse:]
     	[:call name=noData:]
    [:/foreach:]
[:/function:]

[:function name=displayCategoryItem cart=NULL item=NULL:]
    [:if $item->getUrlThumbnail()=='':]
        [:assign var="_urlThumbnail" value="images/img_general.jpg":]
    [:else:]
        [:assign var="_urlThumbnail" value=$item->getUrlThumbnail():]
    [:/if:]
	<div class="item-list">
    		<div class="item">
    			<a href="javascript:void(0)" onclick="redirect('[:$item->getUrlView():]')">
    			<div class="item-header">[:$item->getTitle()|escape:'html':]</div>
    			<div class="item-image">
        			<div class="item-code">[:if $item->getCode()!='':][:$item->getCode()|escape:'html':][:/if:]</div>
        			[:if $item->getNewItem() gt 0:]<div class="item-new"></div>[:/if:]
        			<img src="[:$_urlThumbnail:]" width="220px" height="150px" class="sanpham" alt="some_text"/><br/>  </a>
    			</div>
    			<div class="item-price">[:$LANGUAGE->getMessage('msg.price'):]: [:$item->getPriceForDisplay():]</div>
    			<table width="100%">
    				<tr>
    					<td>
    					 	<form method="post" action="[:$smarty.server.SCRIPT_NAME:]/addToCart">    
                     		 	<input type="hidden" name="item" value="[:$item->getId():]" />
                                <input type="hidden" name="quantity" value="1" />       
                         		<div class="btn-group">
                    				<button type="button" class="btn" onclick="redirect('[:$item->getUrlView():]')">[:$LANGUAGE->getMessage('msg.view'):]</button>
                    				<button type="submit" class="btn icon-cart-add" >[:$LANGUAGE->getMessage('msg.addToCart'):]</button>    				
            					</div>
                			</form>
        				</td>
    					<td align="right"><a href="[:$cart->getUrlView():]">[:if $cart->existInCart($item):] [:$LANGUAGE->getMessage('msg.inCart'):]: <strong>[:$cart->getItem($item)->getQuantity():]</strong>[:/if:]</td>
    					
    				</tr>
    			</table>
    		</div>
    	</div>
    	
[:/function:]


[:function name=skypeAndYahoo skype='' yahoo='' nickYahoo='':]
	<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
	<ul class="sidemenu">
		<li><a href=""><a href="skype:[:$skype:]?call"><img src="http://download.skype.com/share/skypebuttons/buttons/call_blue_white_124x52.png" style="border: none;" width="124" height="52" alt="Skype Me™!" /></a></li>
		<li>
			<a href="ymsgr:sendIM?[:$nickYahoo:]"><img src="http://opi.yahoo.com/online?u=[:$nickYahoo:]&m=g&t=2" /></a>
        </li>
        
	</ul>
[:/function:]

[:function name=noData:]
	<div class="message"><img src="images/message.png" width="25" style="padding-right: 10px;margin-bottom: -5px" /> [:$LANG->getMessage('msg.nodata'):]</div>
[:/function:]

[:function name=tinymce elName='':]
    <!-- TinyMCE -->
    <script type="text/javascript" src="./tinymce/tiny_mce.js"></script>
    <script type="text/javascript">
        tinyMCE.init({
            mode              : "exact",
            elements          : "[:$elName:]",
            theme             : "advanced",
            plugins           : "autolink,lists,table,advhr,advimage,advlink,emotions,preview,media,searchreplace,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,template,inlinepopups,wordcount",
            relative_urls     : false,
            remove_script_host: true,


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


[:function name="printCategoryTreeSelectBox" catList=NULL index=0 selectedIndex=0:]
    [:foreach $catList as $cat:]
        <option [:if $selectedIndex==$cat->getId():]selected="selected"[:/if:] value="[:$cat->getId():]">
            [:if ($index > 0):]
              [:for $_=1 to $index:]&nbsp;&nbsp;&nbsp;&nbsp;[:/for:]+-
            [:/if:]
            [:$cat->getTitle()|escape:'html':]
        </option>
        [:if (count($cat->getChildren()) > 0):]
            [:call name="printCategoryTreeSelectBox" catList=$cat->getChildren() index=$index+1 selectedIndex=$selectedIndex:]
        [:/if:]
    [:/foreach:]
[:/function:]
[:function name="paginator" paginator=NULL:]
<div align="right" style="color: black;">
        	<strong>[:$MODEL.language->getMessage('msg.page'):]:</strong>
            [:foreach $paginator->getVisiblePages() as $_page:]
                [:if $_page==0:]
                    &nbsp;<big>...</big>&nbsp;
                [:elseif $_page==$paginator->getCurrentPage():]
                    &nbsp;<big>[:$_page:]</big>&nbsp;
                [:else:]
                	&nbsp;<a style="text-decoration: underline;" href="[:$paginator->getUrlForPage($_page):]">[:$_page:]</a>&nbsp;
                [:/if:]
            [:/foreach:]
        </div>
[:/function:]


[:function name=displayAds adsList=NULL:]
    [:foreach $adsList as $_ads:]
        [:if $_ads->getUrlThumbnail()=='':]
            [:assign var="_urlThumbnail" value="images/img_general.jpg":]
        [:else:]
            [:assign var="_urlThumbnail" value=$_ads->getUrlThumbnail():]
        [:/if:]
        <div class="pr-banner">		
    		<a href="javascript:void(0)" onclick="openNewTab('[:$_ads->getUrlView():]')">[:$_ads->getTitle():]</a><br/>
    		<a href="javascript:void(0)" onclick="openNewTab('[:$_ads->getUrlView():]')"><img src="[:$_urlThumbnail:]" alt="some_text"/></a>
        </div>
    
     [:/foreach:]

[:/function:]
