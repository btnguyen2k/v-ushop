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
</div>