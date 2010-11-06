<html>
<head>
<title><?=PAGE_TITLE?> - DevSite</title>
<link rel="stylesheet" type="text/css" href="<?=THEME_PATH?>main.css" />
<style type="text/css" media="all">
body,td,table,tr {
	margin: 0px 0px 0px 0px;
	padding: 0px 0px 0px 0px;	/* for opera */
	font-family: Verdana, Tahoma, Arial, sans-serif;
	font-size: 8pt;
	color: #000000;
}

table.menu {
	padding: 0px 0px 0px 0px;
	border-width: 0pt;
	margin: 0px 0px 0px 0px;
}

td.menu_content {
	background-image: url('<?=THEME_PATH?>images/left_menu_slice.jpg');
	text-align: center;
	vertical-align: top;
}
div.menu_content {
	width:130px;
	overflow: hidden;
}

table.tbl1 {
    border: solid 1pt #000000;
    padding: 5px 5px 5px 5px;
	border-collapse: collapse;
	/*border-spacing: 0px;*/
	margin-left:auto;
	margin-right:auto;
}

td.tbl1_header {
    text-align: center;
    background-color: #99CCFF;
    border-bottom: solid 1pt #000000;
    font-weight: bold;
    padding: 5px 5px 5px 5px;
}

td.tbl1_cell {
    padding: 5px 5px 5px 5px;
	background-color: #F2F2F2;
	text-align: left;
}

td.tbl1_footer {
    text-align: center;
    background-color: #C0C0C0;
    border-top: solid 1pt #000000;
    padding: 5px 5px 5px 5px;
}
</style>
</head>
<body>

<!-- HEAD -->
<table cellspacing="0" cellpadding="0" border="0" style="padding:0px 0px 0px 0px; border: solid 0pt #000000; margin:0px 0px 0px 0px;">
<tr>
<td style="background-image:url('<?=THEME_PATH?>images/header_slice.jpg')"><img src="<?=THEME_PATH?>images/header_left.jpg" alt="DevSite" style="border-width:0px" /></td>
<td style="background-image:url('<?=THEME_PATH?>images/header_slice.jpg'); padding-top:15px; width:100%;">
<b>
<?php @include(TEMP_MAINMENU); ?>
</b>
</td>
</tr>
</table>

<br />

<table cellpadding="0" cellspacing="0" border="0" style="padding:0px 0px 0px 0px; border: solid 0pt #000000; margin:0px 0px 0px 0px;">

<tr>
<!-- Left Menu -->
<td style="vertical-align:top; padding-left:10px">
	<table cellpadding="0" cellspacing="0" border="0" class="menu">
	<tr><td><img src="<?=THEME_PATH?>images/project_menu_title.jpg" alt="" style="border-width:0px" /></td></tr>
	<tr><td class="menu_content">
	<div class="menu_content">
	<?php @include(TEMP_PROJECTMENU); ?>
	</div>
	</td></tr>
	<tr><td><img src="<?=THEME_PATH?>images/left_menu_bottom.jpg" alt="" style="border-width:0px" /></td></tr>
	</table>

	<br />
	<br />

	<table cellpadding="0" cellspacing="0" border="0" class="menu">
	<tr><td><img src="<?=THEME_PATH?>images/team_menu_title.jpg" alt="" style="border-width:0px" /></td></tr>
	<tr><td class="menu_content">
	<div class="menu_content">
	<?php @include(TEMP_TEAMMENU); ?>
	</div>
	</td></tr>
	<tr><td><img src="<?=THEME_PATH?>images/left_menu_bottom.jpg" alt="" style="border-width:0px" /></td></tr>
	</table>

	<br />
	<br />

	<table cellpadding="0" cellspacing="0" border="0" class="menu">
	<tr><td><img src="<?=THEME_PATH?>images/info_menu_title.jpg" alt="" style="border-width:0px" /></td></tr>
	<tr><td class="menu_content">
	<div class="menu_content">
	<?php @include(TEMP_INFOSNIPPET); ?>
	</div>
	</td></tr>
	<tr><td><img src="<?=THEME_PATH?>images/left_menu_bottom.jpg" alt="" style="border-width:0px" /></td></tr>
	</table>

	<br />
	<br />

	<table cellpadding="0" cellspacing="0" border="0" class="menu">
	<tr><td><img src="<?=THEME_PATH?>images/bmarks_menu_title.jpg" alt="" style="border-width:0px" /></td></tr>
	<tr><td class="menu_content">
	<div class="menu_content">
	<?php @include(TEMP_BOOKMARKS); ?>
	</div>
	</td></tr>
	<tr><td><img src="<?=THEME_PATH?>images/left_menu_bottom.jpg" alt="" style="border-width:0px" /></td></tr>
	</table>

	<br />
	<br />

	<table cellpadding="0" cellspacing="0" border="0" class="menu">
	<tr><td><img src="<?=THEME_PATH?>images/powered_by.jpg" alt="" style="border-width:0px" /></td></tr>
	<tr><td class="menu_content">
	<br />
	<a href="http://www.php.net"><img src="<?=THEME_PATH?>images/poweredbyphp.gif" alt="Powered by PHP" style="border:solid 1pt #C0C0C0" /></a>
	<br /><br />
	<a href="http://www.mysql.com"><img src="<?=THEME_PATH?>images/poweredbymysql.png" alt="Powered by MySQL" style="border:solid 1pt #C0C0C0" /></a>
	<br />
	</td></tr>
	<tr><td><img src="<?=THEME_PATH?>images/left_menu_bottom.jpg" alt="" style="border-width:0px" /></td></tr>
	</table>
</td>

<!-- Content -->
<td style="text-align:left; vertical-align:top; padding:0px 20px 20px 20px; width:100%;">
<?php @include(TEMP_CONTENTPAGE); ?>
&nbsp;
</td>
</tr>

</table>
</body>
</html>