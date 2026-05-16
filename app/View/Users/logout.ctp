<?php
echo $this->Html->css('menu');
$this->Html->script( array('close'), array( 'inline' => false ) );
echo '<br /><br /><br /><div id="UserLoginForm">ログアウトしました。<br /><br />'."\n".
'<a href="../menu">メニューへ</a></div>';
?>