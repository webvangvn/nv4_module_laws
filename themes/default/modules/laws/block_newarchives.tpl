<!-- BEGIN: main -->
<style type="text/css">
ul.block_archives_news {
	/* required styles */
	display: block;
	position: relative;
	overflow: hidden;
	width: 100%;
	height: {height}px;
}
ul.block_archives_news li {
	position: absolute;
	top: -999em;
	right: 10px;
	height:{height}px;
	display:block;
	padding:10px;
}
ul.block_archives_news li h2{
	color:#000
}
ul.block_archives_news li span{
	color:#666;
	font-size:11px;
}
ul.block_archives_news li p{
	text-align:justify
}
ul.block_archives_news li span strong{
	color:#F60
}
</style>
<script src="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/laws/jquery.marquee.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function (){
  $("#marquee{id}").marquee({yScroll: "bottom"});
});
</script>
<ul class="block_archives_news" id="marquee{id}">
	<!-- BEGIN: loop -->
	<li>
    	<h3><font color="#FF3300">Văn bản:</font>{ROW.title}</h3>
        <p>
        	<a href="{ROW.linkview}">{ROW.hometext}</a>
            <!-- BEGIN: img --><img src="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/laws/new.gif" /><!-- END: img -->
        </p>
        <span>view : <strong>{ROW.view}</strong> | down : <strong>{ROW.down}</strong> </span>
    </li>
    <!-- END: loop -->
</ul>
<!-- END: main -->
