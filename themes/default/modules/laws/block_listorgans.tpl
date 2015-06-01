<!-- BEGIN: main -->
<!-- BEGIN: tree -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}js/jquery/jquery.treeview.css" />
<script src="{NV_BASE_SITEURL}js/jquery/jquery.cookie.js" type="text/javascript"></script>
<script src="{NV_BASE_SITEURL}js/jquery/jquery.treeview.min.js" type="text/javascript"></script>
<!-- END: tree -->
<div class="divscroll">
    <ul id="browser_{id}" class="filetree">
        <!-- BEGIN: loop -->
        <li><span class="folder"><a href="{ROW.link}">{ROW.title}</a></span></li>
        <!-- END: loop -->
    </ul>
</div>
<script type="text/javascript">
	$("#browser_{id}").treeview({
		persist: "cookie",
		collapsed: true,
		animated:"normal",
		unique: true
	});
</script>
<!-- END: main -->
