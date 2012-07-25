[:include file="inc_function.tpl":]
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <base href="[:$MODEL.basehref:]" />
    <meta name="description" content="[:$MODEL.page.description|escape:'html':]" />
    <meta name="keywords" content="[:$MODEL.page.keywords|escape:'html':]" />
    <meta name="author" content="GPV.COM.VN/" />
    <title>[:$MODEL.page.title|escape:'html':]</title>
    [:if isset($MODEL.urlTransit):]
        <meta http-equiv="refresh" content="2; url=[:$MODEL.urlTransit:]" />
    [:/if:]
    [:assign var="LANG" value=$MODEL.language scope=root:]
    [:if isset($MODEL.user):]
        [:assign var="USER" value=$MODEL.user scope=root:]
    [:/if:]
    [:if isset($MODEL.form):]
        [:assign var="FORM" value=$MODEL.form scope=root:]
    [:/if:]
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/dojo/1.7.2/dijit/themes/[:$DOJO_THEME:]/document.css"/>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/dojo/1.7.2/dijit/themes/[:$DOJO_THEME:]/[:$DOJO_THEME:].css"/>
    <style type="text/css">
        @import "http://ajax.googleapis.com/ajax/libs/dojo/1.7.2/dojox/grid/resources/Grid.css";
        @import "http://ajax.googleapis.com/ajax/libs/dojo/1.7.2/dojox/grid/resources/[:$DOJO_THEME:]Grid.css";
        .dojoxGrid table {
            margin: 0;
        }
    </style>
    <link rel="stylesheet" href="style.css"/>
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/dojo/1.7.2/dojo/dojo.js" djConfig="parseOnLoad: true, isDebug: false"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/dojo/1.7.2/dijit/dijit.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/dojo/1.7.2/dijit/dijit-all.js" charset="utf-8"></script>
     <script type="text/javascript" src="js/script.js" charset="utf-8"></script>

    <script type="text/javascript">
    dojo.require('dojox.timing');
    dojo.require('dojox.grid.DataGrid');
    dojo.require('dojo.data.ItemFileWriteStore');
    dojo.require('dojo.parser');

    dojo.require("dijit.form.Button");
    dojo.require("dijit.form.CheckBox");
    dojo.require("dijit.form.TextBox");
    dojo.require("dijit.form.ValidationTextBox");
    dojo.require("dijit.form.Textarea");
    dojo.require("dijit.form.Select");
    dojo.require("dojox.form.Uploader");
    dojo.require("dijit.form.Form");

    dojo.require("dijit.Editor");
    dojo.require("dijit.Dialog");

    dojo.require("dijit.MenuBar");
    dojo.require("dijit.PopupMenuBarItem");
    dojo.require("dijit.Menu");
    dojo.require("dijit.MenuItem");
    dojo.require("dijit.PopupMenuItem");

    dojo.require("dijit.layout.ContentPane");
    
    URL_PARAMS = dojo.queryToObject(dojo.doc.location.search.substr((dojo.doc.location.search[0] === "?" ? 1 : 0)));
    </script>

    <script type="text/javascript">
    var isInIFrame = (window.location != window.parent.location) ? true : false;
    if ( !isInIFrame ) {
        window.location.href = '[:$MODEL.urlHome:]?url='+window.location;
    }
    
    function openUrl(url) {
        //document.getElementById("loading").className = "loading-visible";
        window.location.href = url;
    }
    </script>
    <!--
    <style type="text/css">
    div.loading-invisible { display:none; }
    div.loading-visible {
        display:block;
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
        text-align:center;
        /*in supporting browsers, make it a little transparent*/
        background:#fff;
        _background:none; /*this line removes the background in IE*/
        opacity:.85;
        border-top:1px solid #ddd;
        border-bottom:1px solid #ddd;
        padding-top:15%;
    }
    </style>
    <div id="loading" class="loading-invisible">
        <p><img border="0" src="img/loading.gif"/></p>
    </div>
    -->
</head>
