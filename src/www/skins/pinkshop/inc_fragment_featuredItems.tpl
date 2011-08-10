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
