<!-- LEFT COLUMN --> <!-- Navigation -->
<div id="left-column">
    [:if isset($MODEL.categoryTree):]
        <ul>
            <li class="left-navheader-first">[:$MODEL.language->getMessage('msg.categories'):]</li>
            [:foreach $MODEL.categoryTree as $cat:]
                <li><a title="[:$cat->getTitle()|escape:'html':]" class="left-navheader" href="[:$cat->getUrlView():]">[:$cat->getTitleForDisplay(17)|escape:'html':]</a></li>
                [:foreach $cat->getChildren() as $child:]
                    <li><a title="[:$child->getTitle()|escape:'html':]" href="[:$child->getUrlView():]">[:$child->getTitleForDisplay(17)|escape:'html':]</a></li>
                [:foreachelse:]
                    [:$MODEL.language->getMessage('msg.nodata'):]
                [:/foreach:]
            [:/foreach:]
        </ul>
    [:/if:]
</div>
