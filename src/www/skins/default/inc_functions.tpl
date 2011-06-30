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
