<?php echo $this->element('top_content'); ?>
<?php

$this->Html->css('home', null, array('inline' => false));
$this->Html->script(
		array('jquery-1.7.2.min','jquery-accordion','check_contact'),
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
<h2 style="margin-bottom: 0px;"> Inquiry</h2>
</div>
<div class="post">
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'contact2','name'=>'formCo','id'=>'formCo'))."\n"; ?>
<table align="center">
<tr><td>
<table class="contact_item"><tr><td class="bkco bu" align="center">Property</td></tr></table>
<table class="contact_input"><tr><td class="bu"><pre><?php echo $this->request->data['bukken']."\n"; ?></pre></td></tr></table>
<table class="contact_item"><tr><td class="bkco" align="center">Name</td></tr></table>
<table class="contact_input"><tr><td><?php echo $this->request->data['fname']."\n"; ?></td></tr></table>

<table class="contact_item"><tr><td class="bkco" align="center">E-mail </td></tr></table>
<table class="contact_input"><tr><td><?php echo $this->request->data['fmail']."\n"; ?></td></tr></table>
<table class="contact_item"><tr><td class="bkco" align="center">Tel</td></tr></table>
<table class="contact_input"><tr><td><?php echo $this->request->data['ftel']."\n"; ?>&nbsp;</td></tr></table>
<table class="contact_item"><tr><td class="bkco bu" align="center">Content</td></tr></table>
<table class="contact_input"><tr><td class="bu"><pre><?php echo $this->request->data['fnaiyou']."\n"; ?></pre></td></tr></table>
<table class="contact_submit"><tr>
<td height="50" colspan=2 align="center" valign="middle">
<?php echo $this->Form->hidden('id')."\n".
$this->Form->hidden('bukken')."\n".
$this->Form->hidden('fname')."\n".
$this->Form->hidden('fkana')."\n".
$this->Form->hidden('fmail')."\n".
$this->Form->hidden('fmailcopy')."\n".
$this->Form->hidden('ftel')."\n".
$this->Form->hidden('fkibou')."\n".
$this->Form->hidden('fteltime')."\n".
$this->Form->hidden('fnaiyou')."\n"; ?>
<input type="button" id="busub1" value="　Back　" onClick="check_in1()">　　　
<input type="button" id="busub2" value="　Send　" onClick="check_in2()">
</td>
</tr></table>
</td>
</tr>
</table>
<?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('bottom_content'); ?>

