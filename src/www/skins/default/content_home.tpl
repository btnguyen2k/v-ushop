<!-- MIDDLE COLUMN -->
<div id="middle-column"
    [:if isset($DISABLE_COLUMN_LEFT) && isset($DISABLE_COLUMN_RIGHT):]
        style="width: 98%"
    [:elseif isset($DISABLE_COLUMN_RIGHT)||isset($DISABLE_COLUMN_LEFT):]
        style="width: 77.9%"
    [:/if:]
><!-- Middle column full box -->
    <div class="middle-column-box-blue">
        <div class="middle-column-box-title-blue">[:$MODEL.language->getMessage('msg.categories'):]</div>
        [:if count($MODEL.categoryList) gt 0:]
            <table style="width: 90%; margin-left: auto; margin-right: auto">
            [:foreach $MODEL.categoryList as $cat:]
                [:if $cat@index % 3 == 0:][:if !$cat@first:]</tr>[:/if:]<tr>[:/if:]
                <td width="25%">
                    <a href="[:$cat->getUrlView():]"><img border="1" width="50" height="50" alt="" style="float: left; margin: 4px"
                        src="[:if $cat->getUrlThumbnail()=='':]img/img_general.jpg[:else:][:$cat->getUrlThumbnail():][:/if:]"/><small>[:$cat->getTitle()|escape:'html':]</small></a>
                </td>
                [:if $cat@last:]
                    [:for $i=($cat@index % 3) to 1:]
                        <td>&nbsp;</td>
                    [:/for:]
                    </tr>
                [:/if:]
            [:/foreach:]
            </table>
        [:/if:]
    </div>

    [:assign var="_cart" value=$MODEL.cart nocache:]
    <div class="middle-column-left">
        [:for $i = 0 to round(count($MODEL.itemList)/2)-1:]
            [:assign var="_item" value=$MODEL.itemList[$i]:]
            <!-- Middle column left box -->
            <div class="middle-column-box-left-white">
                <div class="middle-column-box-title-grey">[:$_item->getTitle()|escape:'html':]</div>
                [:displayCategoryItem cart=$_cart item=$_item picAlign='left':]
            </div>
        [:/for:]
    </div>

    <div class="middle-column-right">
        [:for $i = round(count($MODEL.itemList)/2) to count($MODEL.itemList)-1:]
            [:assign var="_item" value=$MODEL.itemList[$i]:]
            <!-- Middle column right box -->
            <div class="middle-column-box-right-white">
                <div class="middle-column-box-title-grey">[:$_item->getTitle()|escape:'html':]</div>
                [:displayCategoryItem cart=$_cart item=$_item picAlign='left':]
            </div>
        [:/for:]
    </div>

    <!-- Middle column full box -->
    <!--
    <div class="middle-column-box-white">
        <div class="middle-column-box-title-grey">Grey title</div>
        <p class="subheading">Basic layout</p>
        <p>The basic concept consiss of a three-column layout combined with individual boxes in the middle
        and right columns. The layout is flexible in two ways. Firstly, the strong menu-capabilities at the
        top header and left column are comphrehensive and can navigate through a content heavy website.
        Secondly, by having boxes in the middle and right columns, important topics can be brought to
        special attention and found more quickly than by going through the menus.</p>
        <p class="subheading">Middle section</p>
        <p>The text boxes in the middle column consist of two types. Firstly, boxes covering the full width,
        and secondly boxes covering the half width. The number or sequence of full- or half-width boxes can
        be chosen freely.</p>
        <p class="subheading">Color scheme and graphics</p>
        <p>The color scheme for the middle and right columns have an independent control of the box titles
        and the box backgrounds. The layout also provides the possibility of inserting or removing graphics
        in the middle column.</p>
        <p class="subheading">Text paragraphs</p>
        <p>Three types of text paragraphs are offered, namely "heading", "subheading" and normal text.</p>
    </div>
    -->
</div>
