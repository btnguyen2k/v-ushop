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
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/dojo/1.7.2/dijit/themes/claro/document.css"/>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/dojo/1.7.2/dijit/themes/claro/claro.css"/>
    <style type="text/css">
        @import "http://ajax.googleapis.com/ajax/libs/dojo/1.7.2/dojox/grid/resources/Grid.css";
        @import "http://ajax.googleapis.com/ajax/libs/dojo/1.7.2/dojox/grid/resources/claroGrid.css";
        .dojoxGrid table {
            margin: 0;
        }
    </style>
    <link rel="stylesheet" href="fullscreen.css"/>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/dojo/1.7.2/dojo/dojo.js" djConfig="parseOnLoad: true, isDebug: false"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/dojo/1.7.2/dijit/dijit.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/dojo/1.7.2/dijit/dijit-all.js" charset="utf-8"></script>

    <script type="text/javascript">
        dojo.require('dojox.timing');
        dojo.require('dojox.grid.DataGrid');
        dojo.require('dojo.data.ItemFileWriteStore');
        dojo.require('dojo.parser');

        dojo.require("dijit.form.Button");
        dojo.require("dijit.form.CheckBox");
        dojo.require("dijit.form.TextBox");
        dojo.require("dijit.form.ValidationTextBox");
        dojo.require("dijit.form.Form");

        dojo.require("dijit.Dialog");

        dojo.require("dijit.MenuBar");
        dojo.require("dijit.PopupMenuBarItem");
        dojo.require("dijit.Menu");
        dojo.require("dijit.MenuItem");
        dojo.require("dijit.PopupMenuItem");

        dojo.require("dijit.layout.BorderContainer");
        dojo.require("dijit.layout.TabContainer");
        dojo.require("dijit.layout.ContentPane");
    </script>
</head>
