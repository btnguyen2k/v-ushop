
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
	 <meta http-equiv="content-type" content="text/html; charset=utf-8" />
   	<base href="[:$MODEL.basehref:]" />
    <link rel="stylesheet" href="print/css/960.css" type="text/css" media="screen">
    <link rel="stylesheet" href="print/css/screen.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="print/css/print.css" type="text/css" media="print" />
    <link rel="stylesheet" href="print/css/print-preview.css" type="text/css" media="screen">
    <script src="http://cdn.jquerytools.org/1.2.5/full/jquery.tools.min.js"></script>    
    <script src="print/jquery.print-preview.js" type="text/javascript" charset="utf-8"></script>
     <script type="text/javascript">
            $(function() {
                /*
                 * Initialise example carousel
                 */
                $("#feature > div").scrollable({interval: 2000}).autoscroll();
                
                /*
                 * Initialise print preview plugin
                 */
                // Add link for print preview and intialise
               
                $('a.print-preview').printPreview();
                $('a.print-preview').click();
                
                // Add keybinding (not recommended for production use)
                $(document).bind('keydown', function(e) {
                    var code = (e.keyCode ? e.keyCode : e.which);
                    if (code == 80 && !$('#print-modal').length) {
                        $.printPreview.loadPrintPreview();
                        return false;
                    }            
                });
            });
    	</script>
</head>


<body>
	

	<div align="center" style="height: 1000px;" >
        <div  class="container_12" style="height: 100%;background: #fff"> 
        	<br/><br/><br/>
        	<a id="print" class="print-preview" ctyle><img src="images/icons/print.gif" alt="" /> In trang này</a>
        		<h1>MUALE.COM.VN</h1>
        	<br/><br/><br/>
        	<table class="talbe"  cellpadding="0" cellspacing="0" border="1" style="border-color: #DCDCDC;" align="center">
            	<thead class="table-header" style="font-weight: bold;">  
                	<tr> 
                		<th width="30px">[:$MODEL.language->getMessage('msg.stt'):]</th>
                		<th >[:$MODEL.language->getMessage('msg.item'):]</th>
                		<th width="60px">[:$MODEL.language->getMessage('msg.image'):]</th>
                		<th style="text-align: right;" >[:$MODEL.language->getMessage('msg.price'):]</th>            		
                		<th style="text-align: center;width: 80px">[:$MODEL.language->getMessage('msg.quantity'):]</th>
                		<th  style="text-align: right;">[:$MODEL.language->getMessage('msg.total'):]</th>
                	</tr>
                </thead>
                <tbody>
                [:foreach $MODEL.cart->getItems() as $item:]            	
                	[:if $item->getUrlThumbnail()=='':]
                        [:assign var="_urlThumbnail" value="images/img_general.jpg":]
                    [:else:]
                        [:assign var="_urlThumbnail" value=$item->getUrlThumbnail():]
                    [:/if:]
                	<tr class="[:if $item@index%2==0:]odd[:else:]even[:/if:] "> 
                		<td>[:$item@index+1:]</td>
                		<td style="white-space: normal;">[:$item->getCode()|escape:'html':]-[:$item->getTitle()|escape:'html':]</td>
                		<td> <img src="[:$_urlThumbnail:]" width="40px" style="padding: 2px" height="40px" alt=""> </td>
        				<td style="text-align: right;">[:$item->getPriceForDisplay():]</td>
                		<td style="text-align: center;">[:$item->getQuantity():]</td>
                		<td style="text-align: right;font-size: 14px">[:$item->getTotalForDisplay():]</td>
                	</tr>
                [:foreachelse:]
                    <tr>
                        <td colspan="7">[:call name=noData:]</td>
                    </tr>
                [:/foreach:]
                </tbody>
                <tfoot>  
                	<tr class="table-header">                		
                		<th colspan="5" style="text-align: right;font-size: 14px;font-weight: normal;">[:$MODEL.language->getMessage('msg.grandTotal'):] : </th>
                		<th style="text-align: right;font-size: 14px;font-weight: normal;" >[:$MODEL.cart->getGrandTotalForDisplay():]</th>
                		
                	</tr>
                </tfoot>
            </table>
        </div>
   	</div>
   
</body>
</html>