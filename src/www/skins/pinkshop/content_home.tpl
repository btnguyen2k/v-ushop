<div id="templatmeo_content">
    <div id="latest_product_gallery">
        <h2>[:$MODEL.language->getMessage('msg.hotItems'):]</h2>
        <div id="SlideItMoo_outer">
            <div id="SlideItMoo_inner">
                <div id="SlideItMoo_items">
                    [:foreach $MODEL.hotItems as $item:]
                        [:if $item->getUrlThumbnail():]
                            [:assign var="urlThumbnail" value=$item->getUrlThumbnail():]
                        [:else:]
                            [:assign var="urlThumbnail" value="img/img_general.jpg":]
                        [:/if:]
                        <div class="SlideItMoo_element">
                            <a href="[:$item->getUrlView():]" title="[:$item->getTitle()|escape:'html':]"><img src="[:$urlThumbnail:]" alt="" height="100" width="100"/></a>
                        </div>
                    [:/foreach:]
                </div>
            </div>
        </div>
    </div> <!-- end of latest_content_gallery -->

    <!--
    <div class="content_section">
        <h2>Welcome to Pink Shop</h2>
        <p><a href="http://www.templatemo.com" target="_parent">Free CSS Templates</a> are provided by <a href="http://www.templatemo.com" target="_parent">templatemo.com</a> for everyone. Feel free to use this template for your websites. Validate <a href="http://validator.w3.org/check?uri=referer">XHTML</a> &amp; <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>. Credit goes to <a href="http://www.photovaco.com" target="_blank">Free Photos</a> for photos used in this template. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et quam vitae ipsum vulputate varius vitae semper nunc. Quisque eget elit quis augue pharetra feugiat.</p>
    </div>
    -->

    <div class="content_section">
        <h2>[:$MODEL.language->getMessage('msg.categories'):]</h2>
        [:assign var="_index" value=0:]
        [:foreach $MODEL.categoryList as $cat:]
            [:if $cat->getUrlThumbnail()=='':]
                [:assign var="_urlThumbnail" value="img/img_general.jpg":]
            [:else:]
                [:assign var="_urlThumbnail" value=$cat->getUrlThumbnail():]
            [:/if:]
            <div class="product_box[:if $_index!=2:] margin_r35[:/if:]">
                <h3>[:$cat->getTitle()|escape:'html':]</h3>
                <div class="image_wrapper"> <a href="[:$cat->getUrlView():]" target="_parent"><img src="[:$_urlThumbnail:]" alt="" width="150"/></a> </div>
                <!--
                <p class="price">Price: $350</p>
                <a href="#">Detail</a> | <a href="#">Buy Now</a>
                -->
                [:if $_index==2:]
                    <div class="cleaner"></div>
                [:/if:]
                [:assign var="_index" value=($_index+1)%3:]
             </div>
        [:/foreach:]
        [:if $_index gt 0 && $_index != 2:]
            <div class="cleaner"></div>
        [:/if:]
        <!-- <div class="button_01"><a href="#">View All</a></div> -->
    </div>
</div> <!-- end of templatmeo_content -->
