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
                            [:assign var="urlThumbnail" value="images/noimage.jpg":]
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

    [:include file="inc_fragment_categoryList.tpl"
        CAT_LIST=$MODEL.categoryList TITLE=$MODEL.language->getMessage('msg.categories'):]
</div> <!-- end of templatmeo_content -->
