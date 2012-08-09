<!--- main column starts-->
<div id="main">
	[:assign var="_page" value=$MODEL.pageObj:]
	<h1>[:$_page->getTitle():]</h1>
	<br/>			
	[:$_page->getContent():]
</div>
<!--- main column ends -->