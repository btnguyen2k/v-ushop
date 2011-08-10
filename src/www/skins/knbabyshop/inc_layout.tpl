[:include file='inc_functions.tpl':][:include file='fragment_html_header.tpl':]
<body>
    <div id="wrap">
        [:include file='fragment_page_header.tpl':]

        [:if !isset($DISABLE_COLUMN_LEFT):]
            [:include file='inc_column_left.tpl':]
        [:/if:]

        [:if !isset($DISABLE_COLUMN_RIGHT):]
            [:include file='inc_column_right.tpl':]
        [:/if:]

        <!-- MIDDLE COLUMN -->
        [:if isset($CONTENT):][:include file=$CONTENT:][:/if:]

        [:include file='fragment_page_footer.tpl':]
    </div>
</body>
</html>