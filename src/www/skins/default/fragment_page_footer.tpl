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

			<a href="index.html">Trang Chủ |</a> 
			<a href="index.html">Liên Hệ |</a>
			<a href="index.html">Đăng Ký Shop |</a>
			<a href="index.html">Đăng nhập quản trị</a>
			</p>
			
		</div>
	</div>
	<!-- footer ends-->	
	