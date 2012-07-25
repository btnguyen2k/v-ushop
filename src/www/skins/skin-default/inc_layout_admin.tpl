[:include file='inc_functions.tpl':][:include file='fragment_html_header.tpl':]
<body>
    <div id="wrap">
        [:include file='fragment_page_header_admin.tpl':]

        [:if !isset($DISABLE_COLUMN_LEFT):]
            [:include file='inc_column_left_admin.tpl':]
        [:/if:]

        [:if !isset($DISABLE_COLUMN_RIGHT):]
            [:include file='inc_column_right_admin.tpl':]
        [:/if:]

        <!-- MIDDLE COLUMN -->
        [:if isset($CONTENT):][:include file=$CONTENT:][:/if:]

        [:include file='fragment_page_footer.tpl':]
    </div>
</body>
</html>