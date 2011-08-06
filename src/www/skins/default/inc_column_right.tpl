<!-- RIGHT COLUMN -->
<div id="right-column">
    <div class="right-column-box-green">
        <div class="right-column-box-title-green">[:$MODEL.language->getMessage('msg.cart'):]</div>
        [:foreach $MODEL.cart->getItems() as $item:]
            &#187; [:$item->getTitle()|escape:'html':] ([:$item->getQuantity():])<br/>
        [:foreachelse:]
            [:$MODEL.language->getMessage('msg.nodata'):]
        [:/foreach:]
        [:if count($MODEL.cart->getItems()) gt 0:]
            <br/>
            <a href="[:$MODEL.cart->getUrlView():]">[:$MODEL.language->getMessage('msg.viewCart'):]</a>
        [:/if:]
    </div>
    [:if isset($MODEL.hotItems):]
        <div class="right-column-box-blue" align="center">
            <marquee behavior="scroll" direction="up" loop="-1" style="text-align: center;" scrolldelay="150">
                [:foreach $MODEL.hotItems as $item:]
                    [:if $item->getUrlThumbnail():]
                        [:assign var="urlThumbnail" value=$item->getUrlThumbnail():]
                    [:else:]
                        [:assign var="urlThumbnail" value="img/img_general.jpg":]
                    [:/if:]
                    <a href="[:$item->getUrlView():]" title="[:$item->getTitle()|escape:'html':]"><img border="0" alt="" src="[:$urlThumbnail:]" width="100"/></a>
                [:/foreach:]
            </marquee>
        </div>
    [:/if:]
</div>
