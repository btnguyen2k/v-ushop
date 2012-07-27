[:assign var="LANGUAGE" value=$MODEL.language scope=root:]
[:if isset($MODEL.user):]
    [:assign var="USER" value=$MODEL.user scope=root:]
[:/if:]
[:if isset($MODEL.form):]
    [:assign var="FORM" value=$MODEL.form scope=root:]
[:/if:]

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

[:function name=topMenu:]
    <div  id="nav" align="center">
    	<ul>
    		<li ><a href="#" class="home">&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
     	[:foreach $MODEL.categoryTree as $cat:] 	
     		 <li><a href="#">[:$cat->getTitleForDisplay(25)|escape:'html':]</a></li> 	
     	[:/foreach:]
     		<li><a href="#">KHUYẾN MÃI</a></li>
     		<li><a href="#">TIN TỨC</a></li>
    		<li><a href="#">HƯỚNG DẪN</a></li>
    		<li><a href="#">LIÊN HỆ</a></li>	
    	</ul>
    </div>
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
        [:assign var="_urlThumbnail" value="img/img_general.jpg":]
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
                    				<button type="button" class="btn">[:$LANGUAGE->getMessage('msg.view'):]</button>
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
		<li><a href=""><a href="ymsgr:sendim?[:$yahoo:]">
            <img src="http://opi.yahoo.com/online?u=[:$nickYahoo:]&m=g&t=2" alt="gpv-jsc.com" border=0></a> 
         </li>
	</ul>
[:/function:]

[:function name=noData:]
	<div class="message"><img src="images/message.png" width="25" style="padding-right: 10px;margin-bottom: -5px" /> [:$LANG->getMessage('msg.nodata'):]</div>
[:/function:]