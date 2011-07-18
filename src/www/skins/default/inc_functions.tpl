[:function name=displayCategoryItem cart=NULL item=NULL picAlign='left':]
    <div style="height: 50px">
        <img src="./img/img_general.jpg" class="[:if $picAlign=='left':]middle-column-img-left[:else:]middle-column-img-right[:/if:]" width="50" alt="" />
        <small>
            [:$MODEL.language->getMessage('msg.item.price'):]: <strong>[:$_item->getPrice():]</strong>
            <br />
            [:$MODEL.language->getMessage('msg.item.vendor'):]: <strong>[:$_item->getVendor()|escape:'html':]</strong>
        </small>
    </div>
    <div>
        <form method="post" action="[:$smarty.server.SCRIPT_NAME:]/addToCart">
            <small>
                <a href="[:$_cart->getUrlView():]">[:$MODEL.language->getMessage('msg.inCart'):]: <strong>
                    [:if $_cart->existInCart($_item):]
                        [:$_cart->getItem($_item)->getQuantity():]
                    [:else:]
                        0
                    [:/if:]
                </strong></a>
                <br />
                [:$MODEL.language->getMessage('msg.addToCart'):]:
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
