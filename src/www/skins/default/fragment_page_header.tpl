<!--header -->
    <div id="header">
        <br/>
        <h4 style="padding-left: 20px"> MUA LẺ TRỰC TUYẾN </h4>
        <span style="font-size: 14px; font-style: italic;color: #E82E18;padding-left: 50px">Thời trang hiệu nơi thể hiện sự sành điệu!</span>
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
                <a href="javascript:void(0)" onclick="login('[:$MODEL.urlLogin:]')" style="font-weight: bold;font-size: 12px">[:$LANG->getMessage('msg.login'):]</a>
    		[:/if:]
		</div>
	</div>
<!--/ header ends-->
		
<!-- navigation starts-->
<div class="menu" style="padding-left: 5px;padding-right: 5px;position: relative;">	
    <ul class="ws_css_cb_menu videoCssMenu">
   
      <li ><a href="[:$MODEL.urlHome:]" ><img style="width: 20px;height: 20px;padding-left: 8px" src="images/icons/home.png" width="35" alt="some_text"/>&nbsp;</a></li>
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

<!-- sidebar top -->
[:if isset($MODEL.newItems) && count($MODEL.newItems) gt 0:]
	<div class="sidebar-top">
		<h1 style="background-color: #E82E18;color: #fff;float: left;margin-bottom: 5px;">[:$LANG->getMessage('msg.sanPhamNoiBanNhat'):]</h1>
		<ul id="scroller" >
			[:foreach $MODEL.newItems as $_item:]	
				 [:if $_item->getUrlThumbnail()=='':]
                    [:assign var="_urlThumbnail" value="images/img_general.jpg":]
                [:else:]
                    [:assign var="_urlThumbnail" value=$_item->getUrlThumbnail():]
                [:/if:]			
            	<li onclick="redirect('[:$_item->getUrlView():]')"><img src="[:$_urlThumbnail:]" alt="">[:$_item->getTitle():]</li>
           [:/foreach:]
        </ul>
	</div>
	[:call name=autoScroller elName=scroller auto='yes':]
[:/if:]
<!--/ sidebar top end-->