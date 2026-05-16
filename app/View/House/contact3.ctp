<?php echo $this->element('top_content'); ?>
<?php


$this->Html->css('home', null, array('inline' => false));
$this->Html->script(
		array('jquery-1.7.2.min','jquery-accordion'),
		array( 'inline' => false )
);
?>
<style type="text/css">
td {
	padding-left: 5px;
	padding-right: 5px;
	border-bottom-width: 1px;
	border-bottom-style: dotted;
	border-bottom-color: #CCCCCC;
}
pre {
	font-family: "メイリオ";
}
</style>
<!-- コンテンツ -->
<div id="content">
<p>&nbsp;</p>
<div class="post">
<table width="600" align="center">
  <tr>
    <td height="300" colspan="10" align=center valign="middle">
Sent!<br /><br />
Inquiry is sent.<br />
（Sent the copy to your email as well.）<br /><br />
    <a href="<?php echo $toppage; ?>">Top page</a>
    </td>
  </tr>
</table>
</div>
<?php echo $this->element('bottom_content'); ?>

