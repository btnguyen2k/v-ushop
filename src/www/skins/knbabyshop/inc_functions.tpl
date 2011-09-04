[:function name="displayCategoryTreeForSelectBox" categoryTree=NULL selectedIndex=0 indent=0:]
    [:foreach $categoryTree as $cat:]
        <option value="[:$cat->getId():]" [:if $cat->getId()==$selectedIndex:]selected="selected" style="font-weight: bold"[:/if:]>
            [:for $tmp=1 to $indent:]&nbsp;&nbsp;&nbsp;&nbsp;[:/for:]+-- [:$cat->getTitle()|escape:'html':]
            [:if count($cat->getChildren()) gt 0:]
                [:foreach $cat->getChildren() as $child:]
                    [:displayCategoryTreeForSelectBox categoryTree=$cat->getChildren() selectedIndex=$selectedIndex indent=$indent+1:]
                [:/foreach:]
            [:/if:]
        </option>
    [:/foreach:]
[:/function:]

[:function name="displayCategoryList" categotyList=NULL:]
    [:assign var="_styleOuterLeft" value=['middle-column-box-left-blue','middle-column-box-left-green','middle-column-box-left-yellow','middle-column-box-left-red']:]
    [:assign var="_styleOuterRight" value=['middle-column-box-right-blue','middle-column-box-right-green','middle-column-box-right-yellow','middle-column-box-right-red']:]
    [:assign var="_styleInner" value=['middle-column-box-title-blue','middle-column-box-title-green','middle-column-box-title-yellow','middle-column-box-title-red']:]
    [:assign var="_counter" value=0:]
    <div class="middle-column-left">
        [:for $i = 0 to round(count($categoryList)/2)-1:]
            [:assign var="_cat" value=$categoryList[$i]:]
            <!-- Middle column left box -->
            <div class="[:$_styleOuterLeft[$_counter]:]">
                <div class="[:$_styleInner[$_counter]:] blockTitle"><a href="[:$_cat->getUrlView():]">[:$_cat->getTitle()|escape:'html':]</a></div>
                <p align="center"><a href="[:$_cat->getUrlView():]"><img border="0" width="150" height="150" alt=""
                    src="[:if $_cat->getUrlThumbnail()=='':]img/img_general.jpg[:else:][:$_cat->getUrlThumbnail():][:/if:]"/></a>
            </div>
            [:assign var="_counter" value=$_counter+1:]
            [:if $_counter ge count($_styleOuterLeft):][:assign var="_counter" value=0:][:/if:]
        [:/for:]
    </div>

    [:if $_counter ge count($_styleOuterRight):][:assign var="_counter" value=0:][:/if:]
    <div class="middle-column-right">
        [:for $i = round(count($categoryList)/2) to count($categoryList)-1:]
            [:assign var="_cat" value=$categoryList[$i]:]
            <!-- Middle column right box -->
            <div class="[:$_styleOuterRight[$_counter]:]">
                <div class="[:$_styleInner[$_counter]:] blockTitle"><a href="[:$_cat->getUrlView():]">[:$_cat->getTitle()|escape:'html':]</a></div>
                <p align="center"><a href="[:$_cat->getUrlView():]"><img border="0" width="150" height="150" alt=""
                    src="[:if $_cat->getUrlThumbnail()=='':]img/img_general.jpg[:else:][:$_cat->getUrlThumbnail():][:/if:]"/></a>
            </div>
            [:assign var="_counter" value=$_counter+1:]
            [:if $_counter ge count($_styleOuterRight):][:assign var="_counter" value=0:][:/if:]
        [:/for:]
    </div>
[:/function:]

[:function name="displaySubCategoryList" categotyList=NULL:]
<table style="width: 98%; margin-left: auto; margin-right: auto">
    [:foreach $categoryList as $cat:]
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
[:/function:]

[:function name=displayCategoryItem cart=NULL item=NULL picAlign='left':]
    <div>
        [:if $item->getUrlThumbnail()=='':]
            [:assign var="_urlThumbnail" value="img/img_general.jpg":]
        [:else:]
            [:assign var="_urlThumbnail" value=$item->getUrlThumbnail():]
        [:/if:]
        [:if $item->getUrlImage()=='':]
            [:assign var="_urlImage" value="img/img_general.jpg":]
        [:else:]
            [:assign var="_urlImage" value=$item->getUrlImage():]
        [:/if:]
        <a href="[:$item->getUrlView():]" onmouseover="ddrivetip('<img src=\'[:$_urlImage:]\' alt=\'\' border=\'0\';>', 'white'[:if $item->getImageWidth() gt 0:], [:$item->getImageWidth():][:else:], 100[:/if:]);" onmouseout="hideddrivetip();"><img src="[:$_urlThumbnail:]"
            class="[:if $picAlign=='left':]middle-column-img-left[:else:]middle-column-img-right[:/if:]" width="100" height="100" alt="" /></a>
        <small>
            <!-- [:$MODEL.language->getMessage('msg.item.price'):]: --><strong>[:$item->getPriceForDisplay():]</strong>
            <br />
            [:$MODEL.language->getMessage('msg.item.vendor'):]: <strong>[:$_item->getVendor()|escape:'html':]</strong>
        </small>
    </div>
    <div>
        <form method="post" action="[:$smarty.server.SCRIPT_NAME:]/addToCart">
            <small>
                <a href="[:$cart->getUrlView():]">[:$MODEL.language->getMessage('msg.inCart'):]: <strong>
                    [:if $cart->existInCart($_item):]
                        [:$cart->getItem($_item)->getQuantity():]
                    [:else:]
                        0
                    [:/if:]
                </strong></a>
                <br />
                <!-- [:$MODEL.language->getMessage('msg.addToCart'):]: -->
                <input type="hidden" name="item" value="[:$_item->getId():]" />
                <input type="text" name="quantity" value="1" style="width: 20px"/>
                <input type="image" src="img/cart_put.png" align="top" title="[:$MODEL.language->getMessage('msg.add'):]"/>
                <!--
                <input type="submit" value="[:$MODEL.language->getMessage('msg.add'):]" style="font-size: xx-small;"/>
                -->
            </small>
         </form>
     </div>
[:/function:]

[:function name=printFormHeader form=NULL:]
    [:if isset($form.errorMessages) && count($form.errorMessages) gt 0:]
        [:foreach $form.errorMessages as $msg:]
            <div class="errorMsg">[:$msg:]</div>
        [:/foreach:]
        <br />
    [:/if:]
    [:if isset($form.infoMessages) && count($form.infoMessages) gt 0:]
        [:foreach $form.infoMessages as $msg:]
            <div class="infoMsg">[:$msg:]</div>
        [:/foreach:]
        <br />
    [:/if:]
[:/function:]

[:function name=tinymce elName='':]
    <!-- TinyMCE -->
    <script type="text/javascript" src="./tinymce/tiny_mce.js"></script>
    <script type="text/javascript">
        tinyMCE.init({
            mode    : "exact",
            elements: "[:$elName:]",
            theme   : "advanced",
            plugins : "autolink,lists,table,advhr,advimage,advlink,emotions,preview,media,searchreplace,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,template,inlinepopups,wordcount",

            // Theme options
            theme_advanced_buttons1: "help,code,preview,fullscreen,|,undo,redo,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontsizeselect",
            theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,image,|,forecolor,backcolor",
            theme_advanced_buttons3: "tablecontrols,hr,advhr,removeformat,|,sub,sup,|,charmap",
            theme_advanced_toolbar_location  : "top",
            theme_advanced_toolbar_align     : "left",
            theme_advanced_statusbar_location: "bottom",
            theme_advanced_resizing          : false,
            entity_encoding: "raw"
            //content_css    : false
        });
    </script>
    <!-- /TinyMCE -->
[:/function:]
