<!--header -->

    <div id="header" ><br/>
        <img style="padding-left: 20px;" src="images/logo1.png"><br/>
        <span class="text-logo">Thời trang hiệu nơi thể hiện sự sành điệu!</span>
		<div id="header-links">
			<br/>
            <p>
                <a href="[:$MODEL.cart->getUrlView():]"><img src="images/shopping-cart_red.png" style="width: 25px" alt="some_text"/>
                    [:$MODEL.language->getMessage('msg.cart.numItems'):]: <strong>[:$MODEL.cart->getTotalItems():]</strong>,
                    [:$MODEL.language->getMessage('msg.cart.totalPrice'):]: <strong>[:$MODEL.cart->getTotalPriceForDisplay():]</strong>
    			</a>
    		</p>
    		[:if isset($USER):]
                <p style="font-weight: bold;font-size: 12px">
                    [:$LANG->getMessage('msg.hello'):] [:$USER->getDisplayName():]
                    [:if $USER->getGroupId() == $USER_GROUP_SHOP_OWNER:]| <a href="[:$MODEL.urlProfile:]">[:$LANG->getMessage('msg.profile'):]</a>[:/if:]
                    | <a href="[:$MODEL.urlLogout:]">[:$LANG->getMessage('msg.logout'):]</a>
                </p>
    		[:else:]
                <a href="javascript:void(0)" style="font-weight: bold;font-size: 12px" onclick="redirect('[:$MODEL.urlRegister:]')">[:$LANG->getMessage('msg.register'):]</a> | <a href="javascript:void(0)" onclick="login('[:$MODEL.urlLogin:]')" style="font-weight: bold;font-size: 12px">[:$LANG->getMessage('msg.login'):]</a>
    		[:/if:]
		</div>
	</div>
<!--/ header ends-->
		
<!-- navigation starts-->
<div class="menu" style="padding-left: 5px;padding-right: 5px;position: relative;">	
    <ul class="ws_css_cb_menu videoCssMenu">
   
      <li ><a href="[:$MODEL.urlHome:]" onmouseout="changeHomeImage('out')" onmouseover="changeHomeImage('over')"><img id="home-image" style="width: 20px;height: 20px;padding-left: 8px" src="images/icons/home.png" width="35" alt="some_text"/>&nbsp;</a></li>
      [:foreach $MODEL.categoryTree as $_cat:]
      	<li><a href="[:$_cat->getUrlView():]">      		
      		[:if $_cat->hasChildren():]
      			<span>[:$_cat->getTitle()|escape:'html':] </span>
      				 <![if gt IE 6]>
                   		 </a> 
                    <![endif]> 
      				<ul class='ws_css_cb_menum'>
      				[:foreach $_cat->getChildren() as $_child:]
      					 <li><a href="[:$_child->getUrlView():]" >[:$_child->getTitle()|escape:'html':]</a></li>
      				[:/foreach:]
      				</ul> 
      		[:else:]
      			[:$_cat->getTitle()|escape:'html':] 
      		[:/if:]
      		</a>  
      </li>
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
<div style="border: 1px solid #DCDCDC;margin-left: 5px;margin-right: 5px;">
<!-- sidebar top -->
[:if isset($MODEL.newItems) && count($MODEL.newItems) gt 0:]
	<div class="sidebar-top">
		<h1>[:$LANG->getMessage('msg.sanPhamNoiBanNhat'):]</h1>
		<br style="clear: both;"/>
		<ul id="scroller">
			[:foreach $MODEL.newItems as $_item:]	
				 [:if $_item->getUrlThumbnail()=='':]
                    [:assign var="_urlThumbnail" value="images/img_general.jpg":]
                [:else:]
                    [:assign var="_urlThumbnail" value=$_item->getUrlThumbnail():]
                [:/if:]			
            	<li onclick="redirect('[:$_item->getUrlView():]')" style="text-align: left;"><img src="[:$_urlThumbnail:]" alt=""><div style="padding-left: 5px">
            		[:$_item->getTitle():]<br/>
            		[:$LANG->getMessage('msg.price'):]: [:$_item->getPriceForDisplay():]<br/>
            		[:$LANG->getMessage('msg.shopPrice'):]: [:$_item->getOldPriceForDisplay():]<br/>
            		[:$LANG->getMessage('msg.savingPrice'):]: [:$_item->getSavingForDisplay():]</div>
            	</li>
           [:/foreach:]
        </ul>
	</div>
	<script type="text/javascript">
	$("div.sidebar-top").hide();
	 setTimeout('showHeader()',800);
	function showHeader(){
		$("div.sidebar-top").show();
	}
	</script>
	[:call name=autoScroller elName=scroller auto='yes':]
[:/if:]
</div>
<!--/ sidebar top end-->