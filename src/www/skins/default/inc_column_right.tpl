<!-- RIGHT COLUMN -->
<div id="right-column">
    <div class="right-column-box-green">
        <div class="right-column-box-title-green">[:$MODEL.language->getMessage('msg.cart'):]</div>
        [:foreach $MODEL.cart->getItems() as $item:]
        [:foreachelse:]
            [:$MODEL.language->getMessage('msg.nodata'):]
        [:/foreach:]
    </div>
</div>