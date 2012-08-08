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

			<a href="javascript:void(0)">[:$LANG->getMessage('msg.home'):] |</a> 
			<a href="javascript:void(0)">[:$LANG->getMessage('msg.contact'):] |</a>
			<a href="javascript:void(0)">[:$LANG->getMessage('msg.registerShop'):] </a>
			[:if isset($MODEL.urlBackend):]
			<a href="javascript:void(0)" onclick="redirect('[:$MODEL.urlBackend:]')">| [:$LANG->getMessage('msg.pageAdmin'):]</a>
			[:/if:]
			</p>
			
            <p>
                <!-- Histats.com  START  (standard)-->
                <script type="text/javascript">document.write(unescape("%3Cscript src=%27http://s10.histats.com/js15.js%27 type=%27text/javascript%27%3E%3C/script%3E"));</script>
                <a href="http://www.histats.com" target="_blank" title="counter easy hit" ><script  type="text/javascript" >
                try {Histats.start(1,2026361,4,2036,130,60,"00011111");
                Histats.track_hits();} catch(err){};
                </script></a>
                <noscript><a href="http://www.histats.com" target="_blank"><img  src="http://sstatic1.histats.com/0.gif?2026361&101" alt="counter easy hit" border="0"></a></noscript>
                <!-- Histats.com  END  -->
            </p>
		</div>
	</div>
	<!-- footer ends-->	
	