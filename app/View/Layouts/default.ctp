<?php
$cakeDescription = 'Property Search';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja">
<head>
    <?php echo $this->Html->charset(); ?>
    <title><?php echo (!empty($title_for_layout) ? h($title_for_layout) . ' - ' : ''); ?><?php echo $cakeDescription; ?></title>
    <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('cake.generic');
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>
</head>
<body>
    <div id="container">
        <div id="header">
            <h1><?php echo $cakeDescription; ?></h1>
        </div>
        <div id="content">
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->fetch('content'); ?>
        </div>
        <div id="footer">
            <!-- フッターに何か書きたい場合はここに -->
        </div>
    </div>
</body>
</html>
