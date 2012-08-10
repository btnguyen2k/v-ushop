<div class="footer-fix" id="back-top">
	<img alt="" src="images/back-top.png">
</div>
<script>
jQuery(document).ready(function(){
	var backTop=document.getElementById("back-top");
	var doc = jQuery(window);
	
	jQuery(window).scroll(function() {
		if(doc.scrollTop()>100)
				backTop.setAttribute("style", "display:block");
			else
				backTop.setAttribute("style", "display:none");
	});
	$("#back-top").click(function() {		
		 $('html, body').animate({scrollTop:0}, 'normal');
	});
});
</script>
<!-- footer starts -->			
	<div id="footer-wrap" >
				
		<div id="footer">	
				
			<p>
    			<a>[:$MODEL.page.copyright:] </a>
    
                &nbsp;&nbsp;&nbsp;&nbsp;
    
    
       		    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    
    			<a href="javascript:void(0)" onclick="redirect('$MODEL.urlHome')">[:$LANG->getMessage('msg.home'):] |</a> 
    			<a href="javascript:void(0)" onclick="showMessage('[:$LANG->getMessage('msg.shop.register.info'):]')">[:$LANG->getMessage('msg.registerShop'):] </a>
    			[:if isset($MODEL.urlBackend):]
    			<a href="javascript:void(0)" onclick="redirect('[:$MODEL.urlBackend:]')">| [:$LANG->getMessage('msg.pageAdmin'):]</a>
    			[:/if:]
			</p>
		</div>
	</div>
	<!-- footer ends-->	
	