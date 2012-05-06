[:assign var="DOJO_THEME" value='claro' scope='global':]
[:function name=dijitEditor fieldId='' fieldName='' fieldValue='' cssStyle='' cssClass='':]
    <div dojoType="dijit.Editor" id="[:$fieldId:]" namd="[:$fieldName:]"
        [:if cssStyle!='':]style="[:$cssStyle:]"[:/if:] [:if cssClass!='':]class="[:$cssClass:]"[:/if:]
        plugins="['undo','redo','removeFormat','|','cut','copy','paste','|','createLink','unlink','|','bold','italic','underline','strikethrough','subscript','superscript','|','insertHorizontalRule','|','insertOrderedList','insertUnorderedList','indent','outdent','|','justifyLeft','justifyRight','justifyCenter','justifyFull']">
        [:$fieldValue:]
    </div>
[:/function:]

[:function name=tinymce elName='':]
    <!-- TinyMCE -->
    <script type="text/javascript" src="./tinymce/tiny_mce.js"></script>
    <script type="text/javascript">
        tinyMCE.init({
            mode              : "exact",
            elements          : "[:$elName:]",
            theme             : "advanced",
            plugins           : "autolink,lists,table,advhr,advimage,advlink,emotions,preview,media,searchreplace,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,template,inlinepopups,wordcount",
            relative_urls     : false,
            remove_script_host: true,


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

[:function name=printFormHeader form=NULL:]
    [:if isset($form.errorMessages) && count($form.errorMessages) gt 0:]
        [:foreach $form.errorMessages as $msg:]
            <span class="errorMsg">[:$msg:]</span>
        [:/foreach:]
        <br />
    [:/if:]
    [:if isset($form.infoMessages) && count($form.infoMessages) gt 0:]
        [:foreach $form.infoMessages as $msg:]
            <span class="infoMsg">[:$msg:]</span>
        [:/foreach:]
        <br />
    [:/if:]
[:/function:]

[:function renderMenuItemAction menuItem=NULL:]
    [:if isset($menuItem.URL):]
        onclick="window.location.href='[:$menuItem.URL:]';"
    [:elseif isset($menuItem.FORM):]
        onclick="apiOpenForm('[:$menuItem.FORM|escape:'html':]');"
    [:/if:]
[:/function:]

[:function name=printMenubarItem menuItem=NULL:]
    [:if isset($menuItem.CHILDREN):]
        <div dojoType="dijit.PopupMenuBarItem">
            <span>[:$menuItem.TITLE|escape:'html':]</span>
            <div dojoType="dijit.Menu">
                [:foreach $menuItem.CHILDREN as $child:]
                    [:call name="printMenuItem" menuItem=$child:]
                [:/foreach:]
            </div>
        </div>
    [:else:]
        <div dojoType="dijit.MenuBarItem" [:call name="renderMenuItemAction" menuItem=$menuItem:]>
            [:$menuItem.TITLE|escape:'html':]
        </div>
    [:/if:]
[:/function:]

[:function name=printMenuItem menuItem=NULL:]
    [:if isset($menuItem.CHILDREN):]
        <div dojoType="dijit.PopupMenuItem" [:call name="renderMenuItemAction" menuItem=$menuItem:]>
            <span>[:$menuItem.TITLE|escape:'html':]</span>
            <div dojoType="dijit.Menu">
                [:foreach $menuItem.CHILDREN as $child:]
                    [:call name="printMenuItem" menuItem=$child:]
                [:/foreach:]
            </div>
        </div>
    [:else:]
        <div dojoType="dijit.MenuItem" [:call name="renderMenuItemAction" menuItem=$menuItem:]>[:$menuItem.TITLE|escape:'html':]</div>
    [:/if:]
[:/function:]
