[:include file='inc_functions.tpl':][:include file='fragment_html_header.tpl':]
<body >
	<div id="wrap">
    [:include file='fragment_page_header.tpl':]  
    	<div id="left-column" >	
    		[:if !isset($DISABLE_COLUMN_LEFT):]                
        		[:include file='inc_column_left.tpl':]
			[:/if:]
		</div>
		
		<div id="content-wrap" >
    		[:if isset($CONTENT):][:include file=$CONTENT:][:/if:]
    	</div>
    	<div id="right-column">	
    		[:if !isset($DISABLE_COLUMN_RIGHT):]                
        		[:include file='inc_column_right.tpl':]
			[:/if:]
  		</div>
    [:include file='fragment_page_footer.tpl':]
    </div>
</body>
</html>
