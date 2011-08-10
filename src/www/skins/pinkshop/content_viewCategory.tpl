<div id="templatmeo_content">
    [:include file="inc_fragment_featuredItems.tpl":]

    [:*
    [:if count($MODEL.categoryObj->getChildren()) gt 0:]
        [:include file="inc_fragment_categoryList.tpl"
            CAT_LIST=$MODEL.categoryObj->getChildren() TITLE=$MODEL.language->getMessage('msg.categories'):]
    [:/if:]
    *:]

    [:if count($MODEL.itemList) eq 0:]
       [:$MODEL.language->getMessage('msg.nodata'):]
    [:else:]
        [:include file="inc_fragment_itemList.tpl"
            ITEM_LIST=$MODEL.itemList TITLE=$MODEL.language->getMessage('msg.items'):]
    [:/if:]
</div> <!-- end of templatmeo_content -->
