<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja">
<head>
<meta name="copyright" content="Copyright &copy; 2016 ITS http://infotese.com All Rights Reserved.">
<meta name="viewport" content="width=device-width">
<?php echo $this->Html->charset()."\n"; ?>
<title><?php echo $title_for_layout; ?> 不動産検索システム ebs3</title>
<?php
echo preg_replace('/><link/', ">\n<link", $this->fetch('css'))."\n".
	 preg_replace('/><script/', ">\n<script", $this->fetch('script'))."\n";
?>
</head>
<body>
<?php echo $this->fetch('content'); ?>
</body>
</html>
