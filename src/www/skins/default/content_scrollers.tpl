<style>

#makeMeScrollable div.scroller *
{
	position: relative;
	display: block;
	float: left;
	padding: 0;
	margin: 0;
}

</style>

<div class="sidebar-top">
	<h1>Sản Phẩm Nổi Bật Nhất</h1>
	<div id="makeMeScrollable" >
       <img src="images/sanpham1.png" class="sanpham" alt="Firehouse">D001 San pham 01
       <img src="images/sanpham1.png" class="sanpham" alt="Chloe nightclub"> D001 San pham 01
       <img src="images/sanpham2.png" class="sanpham" alt="Firehouse bar"> D001 San pham 01
       <img src="images/sanpham3.png" class="sanpham" alt="Firehouse chloe club fishtank">D001 San pham 01
       <img src="images/sanpham4.png" class="sanpham" alt="Firehouse restaurant">D001 San pham 01
       <img src="images/sanpham1.png" class="sanpham" alt="Firehouse">D001 San pham 01
       <img src="images/sanpham1.png" class="sanpham" alt="Chloe nightclub">D001 San pham 01
       <img src="images/sanpham2.png" class="sanpham" alt="Firehouse bar">D001 San pham 01
       <img src="images/sanpham3.png" class="sanpham" alt="Firehouse chloe club fishtank">D001 San pham 01
       <img src="images/sanpham4.png" class="sanpham" alt="Firehouse restaurant">D001 San pham 01
       <img src="images/sanpham1.png" class="sanpham" alt="Firehouse">D001 San pham 01
       <img src="images/sanpham1.png" class="sanpham" alt="Chloe nightclub">D001 San pham 01
       <img src="images/sanpham2.png" class="sanpham" alt="Firehouse bar">D001 San pham 01
       <img src="images/sanpham3.png" class="sanpham" alt="Firehouse chloe club fishtank">D001 San pham 01
       <img src="images/sanpham4.png" class="sanpham" alt="Firehouse restaurant">D001 San pham 01
    </div>
</div>
<!-- jQuery UI Widget and Effects Core (custom download)
		 You can make your own at: http://jqueryui.com/download -->
	<script src="js/jquery-ui-1.8.18.custom.min.js" type="text/javascript"></script>
	
	<!-- Latest version of jQuery Mouse Wheel by Brandon Aaron
		 You will find it here: http://brandonaaron.net/code/mousewheel/demos -->
	<script src="js/jquery.mousewheel.min.js" type="text/javascript"></script>

	<!-- Smooth Div Scroll 1.2 minified-->
	<script src="js/jquery.smoothdivscroll-1.2-min.js" type="text/javascript"></script>
	
<script type="text/javascript">
	$(document).ready(function() {
		$("#makeMeScrollable").smoothDivScroll({ 
			mousewheelScrolling: true,
			manualContinuousScrolling: true,
			visibleHotSpotBackgrounds: "always",
			autoScrollingMode: "onstart"
		});
	});
</script>