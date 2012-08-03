
<div class="main" align="center">
    <div id="error" class="standard_error" align="left">
        <h2 class="blockhead">[:$MODEL.language->getMessage('msg.error'):]</h2>
    	<form  class="vbform" style="text-align: center;" method="post"> 
            <br/>  
            <ul>      
             [:foreach $MODEL.errorMessages as $msg:]
           	 	<li>[:$msg:]</li>
        	[:/foreach:]
        	</ul>  
        </form>
       
    </div>
</div>
<script>
	jumpTo('error');
</script>