<?php


$this->Html->css('admin.img', null, array('inline' => false));
$this->Html->script('check_img',array( 'inline' => false ));
$imgArray = array('gaikan_img','madori_img',
	'syousai_img1','syousai_img2','syousai_img3','syousai_img4','syousai_img5',
	'syousai_img6','syousai_img7','syousai_img8','syousai_img9','syousai_img10');

$i_ind=0;
$imgAr = array();
foreach( $imgArray as $va ){
	if(!empty($this->request->data[$modelName][$va])){
		if($this->request->data[$modelName][$va] == 1){
			$imgAr[$va] = '<img src="../img/rent/gazou/'.$this->request->data[$modelName]['id'].'_'.$i_ind.
			'.jpg" width="200" border="0" />';
			$i_ind++;
		}else{
			$imgAr[$va] = '<img src="../img/rent/gazou/'.$this->request->data[$modelName]['id'].'_'.$i_ind.
			'.jpg" height="200" border="0" />';
			$i_ind++;
		}
	}else{
		$imgAr[$va] = '';
	}
}
if(!empty($this->request->data[$modelName]['siryou_img'])){
	if($this->request->data[$modelName]['siryou_img'] == 1){
		$imgAr['siryou_img'] = '<img src="./imgRoad?no='.$this->request->data[$modelName]['id'].'" width="200" border="0" />';
	}else{
		$imgAr['siryou_img'] = '<img src="./imgRoad?no='.$this->request->data[$modelName]['id'].'" height="200" border="0" />';
	}
}else{
	$imgAr['siryou_img'] = '';
}
$view = '';
?>
<script type="text/javascript">
function check_in1(formName){
	var re_in = true;
	if(document.getElementById(formName+"Img").value != ''){
		if(document.getElementById(formName+"Img").value.match(/\.jpg$/i)){
			document.getElementById('msg'+formName).innerHTML = '';
			document.getElementById(formName+"Img").style.backgroundColor = '';
		}else{
			document.getElementById('msg'+formName).innerHTML = '画像ファイルは[*.jpg]のみです<br />';
			document.getElementById(formName+"Img").style.backgroundColor = '#ffeeee';
			re_in = false;
		}
	}
	if(re_in){document.getElementById(formName).submit();}
}
</script>
<p id="page_title">不動産検索システム ebs3 管理 <font color="#FF0000">賃貸</font> 画像</p>
<div id="modoru">
  <table border="0" align="center">
    <tr>
      <td>
<input type="button" onclick="location.href='<?php echo $this->webroot.'AdminRent/search'.$this->request->data['page']; ?>'"value="戻る">
      </td>
      <td width="50">&nbsp;</td>
      <td><font size="-2">・画像はjpgのみで640*480に自動でサイズ変更されます。(資料画像は、サイズ変更されません)<br />
        ・登録後画像が変わらない場合再読み込みしてください。<br />
        （Internet Explorerの場合ブラウザーの最新の情報に更新が再読み込みです。）</font></td>
    </tr>
  </table>
</div>
<div id="img">
	<table border="0" align="center">
	  <tr>
	    <td width="200" id="border">
	    物件番号：<?php echo $this->request->data[$modelName]['id']; ?><br />
	    物件名：<?php echo $this->request->data[$modelName]['bukkenmei']; ?>
	    </td>
	  </tr>
	</table>
	<table border="0" align="center">
	  <tr>
	    <td align="center" valign="middle" id="border"><table border="0" align="center" class="imgtable">
	        <tr>
	          <td valign="top">外観画像</td>
	        </tr>
	        <tr>
	          <td width="200" height="200">
	          <?php echo $imgAr['gaikan_img']; ?>
	            <br />
	            <?php echo $this->request->data[$modelName]['gaikan_co']; ?></td>
	        </tr>
	        <tr>
	          <td class="input" id="outer111">
<?php echo $this->Form->create(false,array('name'=>'formg','id'=>'formg','type'=>'post','url'=>'imgAdd','enctype' => 'multipart/form-data'))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('img_syurui',array('value'=>'gaikan_img'))."\n"
.$this->Form->input('img', array('id'=>'formgImg','type'=>'file','label' => false,))."\n"
.'<span class="errmsg" id="msgformg"></span>コメント：'
.$this->Form->text($modelName.'.gaikan_co',array('style'=>'width:200px'))
.'<br /><br />
<input type="button" value="登録／変更" onClick="check_in1(\'formg\')">'
.$this->Form->end(); ?>
	            </td>
	        </tr>
	        <tr>
	          <td>
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'imgAdd','onSubmit'=>"return check('外観画像')"))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('del',array('value'=>1))."\n"
.$this->Form->hidden('img_syurui',array('value'=>'gaikan_img'))."\n"
.$this->Form->hidden($modelName.'.gaikan_img')."\n"
.$this->Form->hidden($modelName.'.gaikan_co',array('value'=>''))."\n"
.$this->Form->end(array('label'=>'削除','div'=>false)); ?>
	            </td>
	        </tr>
	      </table></td>
	    <td align="center" valign="middle" id="border"><table border="0" align="center" class="imgtable">
	        <tr>
	          <td valign="top">間取り画像</td>
	        </tr>
	        <tr>
	          <td width="200" height="200"><?php echo $imgAr['madori_img']; ?>
	            <br />
	            <?php echo $this->request->data[$modelName]['madori_co']; ?></td>
	        </tr>
	        <tr>
	          <td class="input" id="outer112">
<?php echo $this->Form->create(false,array('name'=>'formm','id'=>'formm','type'=>'post','url'=>'imgAdd','enctype' => 'multipart/form-data'))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('img_syurui',array('value'=>'madori_img'))."\n"
.$this->Form->input('img', array('id'=>'formmImg','type'=>'file','label' => false))."\n"
.'<span class="errmsg" id="msgformm"></span>コメント：'
.$this->Form->text($modelName.'.madori_co',array('style'=>'width:200px'))
.'<br /><br />
<input type="button" value="登録／変更" onClick="check_in1(\'formm\')">'
.$this->Form->end(); ?>
	            </td>
	        </tr>
	        <tr>
	          <td>
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'imgAdd','onSubmit'=>"return check('間取り画像')"))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('del',array('value'=>1))."\n"
.$this->Form->hidden('img_syurui',array('value'=>'madori_img'))."\n"
.$this->Form->hidden($modelName.'.madori_img')."\n"
.$this->Form->hidden($modelName.'.madori_co',array('value'=>''))."\n"
.$this->Form->end(array('label'=>'削除','div'=>false)); ?>
	            </td>
	        </tr>
	      </table></td>
	    <td align="center" valign="middle" id="border"><table border="0" align="center" class="imgtable">
	        <tr>
	          <td valign="top">資料画像</td>
	        </tr>
	        <tr>
	          <td width="200" height="200"><?php echo $imgAr['siryou_img']; ?>
	            <br />
	            <?php echo $this->request->data[$modelName]['siryou_co']; ?></td>
	        </tr>
	        <tr>
	          <td class="input" id="outer113">
<?php echo $this->Form->create(false,array('name'=>'forms','id'=>'forms','type'=>'post','url'=>'imgAdd','enctype' => 'multipart/form-data'))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('img_syurui',array('value'=>'siryou_img'))."\n"
.$this->Form->input('img', array('id'=>'formsImg','type'=>'file','label' => false))."\n"
.'<span class="errmsg" id="msgforms"></span>コメント：'
.$this->Form->text($modelName.'.siryou_co',array('style'=>'width:200px'))
.'<br /><br />
<input type="button" value="登録／変更" onClick="check_in1(\'forms\')">'
.$this->Form->end(); ?>
	            </td>
	        </tr>
	        <tr>
	          <td>
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'imgAdd','onSubmit'=>"return check('資料画像')"))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('del',array('value'=>1))."\n"
.$this->Form->hidden('img_syurui',array('value'=>'siryou_img'))."\n"
.$this->Form->hidden($modelName.'.siryou_img')."\n"
.$this->Form->hidden($modelName.'.siryou_co',array('value'=>''))."\n"
.$this->Form->end(array('label'=>'削除','div'=>false)); ?>
	            </td>
	        </tr>
	      </table></td>
	  </tr>
	</table>
	<table border="0" align="center">
	  <tr>
	    <td align="center" valign="middle" id="border"><a name="s" id="s"></a>
	      <table border="0" align="center" class="imgtable">
	        <tr>
	          <td id="2" valign="top">詳細１画像</td>
	        </tr>
	        <tr>
	          <td width="110" height="110"><?php echo $imgAr['syousai_img1']; ?>
	            <br />
	            <?php echo $this->request->data[$modelName]['syousai_co1']; ?></td>
	        </tr>
	        <tr>
	          <td class="input" id="outer11">
<?php echo $this->Form->create(false,array('name'=>'form1','id'=>'form1','type'=>'post','url'=>'imgAdd#2','enctype' => 'multipart/form-data'))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('img_syurui',array('value'=>'syousai_img1'))."\n"
.$this->Form->input('img', array('id'=>'form1Img','type'=>'file','label' => false))."\n"
.'<span class="errmsg" id="msgform1"></span>コメント：'
.$this->Form->text($modelName.'.syousai_co1',array('style'=>'width:200px'))
.'<br /><br />
<input type="button" value="登録／変更" onClick="check_in1(\'form1\')">'
.$this->Form->end(); ?>
	            </td>
	        </tr>
	        <tr>
	          <td>
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'imgAdd#2','onSubmit'=>"return check('詳細１画像')"))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('del',array('value'=>1))."\n"
.$this->Form->hidden('img_syurui',array('value'=>'syousai_img1'))."\n"
.$this->Form->hidden($modelName.'.syousai_img1')."\n"
.$this->Form->hidden($modelName.'.syousai_co1',array('value'=>''))."\n"
.$this->Form->end(array('label'=>'削除','div'=>false)); ?>
	            </td>
	        </tr>
	      </table></td>
	    <td align="center" valign="middle" id="border"><table border="0" align="center" class="imgtable">
	        <tr>
	          <td valign="top">詳細２画像</td>
	        </tr>
	        <tr>
	          <td width="110" height="110"><?php echo $imgAr['syousai_img2']; ?>
	            <br />
	            <?php echo $this->request->data[$modelName]['syousai_co2']; ?></td>
	        </tr>
	        <tr>
	          <td class="input" id="outer11">
<?php echo $this->Form->create(false,array('name'=>'form2','id'=>'form2','type'=>'post','url'=>'imgAdd#2','enctype' => 'multipart/form-data'))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('img_syurui',array('value'=>'syousai_img2'))."\n"
.$this->Form->input('img', array('id'=>'form2Img','type'=>'file','label' => false))."\n"
.'<span class="errmsg" id="msgform2"></span>コメント：'
.$this->Form->text($modelName.'.syousai_co2',array('style'=>'width:200px'))
.'<br /><br />
<input type="button" value="登録／変更" onClick="check_in1(\'form2\')">'
.$this->Form->end(); ?>
	            </td>
	        </tr>
	        <tr>
	          <td>
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'imgAdd#2','onSubmit'=>"return check('詳細２画像')"))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('del',array('value'=>1))."\n"
.$this->Form->hidden('img_syurui',array('value'=>'syousai_img2'))."\n"
.$this->Form->hidden($modelName.'.syousai_img2')."\n"
.$this->Form->hidden($modelName.'.syousai_co2',array('value'=>''))."\n"
.$this->Form->end(array('label'=>'削除','div'=>false)); ?>
	            </td>
	        </tr>
	      </table></td>
	    <td align="center" valign="middle" id="border"><table border="0" align="center" class="imgtable">
	        <tr>
	          <td valign="top">詳細３画像</td>
	        </tr>
	        <tr>
	          <td width="110" height="110"><?php echo $imgAr['syousai_img3']; ?>
	            <br />
	            <?php echo $this->request->data[$modelName]['syousai_co3']; ?></td>
	        </tr>
	        <tr>
	          <td class="input" id="outer11">
<?php echo $this->Form->create(false,array('name'=>'form3','id'=>'form3','type'=>'post','url'=>'imgAdd#2','enctype' => 'multipart/form-data'))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('img_syurui',array('value'=>'syousai_img3'))."\n"
.$this->Form->input('img', array('id'=>'form3Img','type'=>'file','label' => false))."\n"
.'<span class="errmsg" id="msgform3"></span>コメント：'
.$this->Form->text($modelName.'.syousai_co3',array('style'=>'width:200px'))
.'<br /><br />
<input type="button" value="登録／変更" onClick="check_in1(\'form3\')">'
.$this->Form->end(); ?>
	            </td>
	        </tr>
	        <tr>
	          <td>
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'imgAdd#2','onSubmit'=>"return check('詳細３画像')"))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('del',array('value'=>1))."\n"
.$this->Form->hidden('img_syurui',array('value'=>'syousai_img3'))."\n"
.$this->Form->hidden($modelName.'.syousai_img3')."\n"
.$this->Form->hidden($modelName.'.syousai_co3',array('value'=>''))."\n"
.$this->Form->end(array('label'=>'削除','div'=>false)); ?>
	            </td>
	        </tr>
	      </table></td>
	    <td align="center" valign="middle" id="border"><table border="0" align="center" class="imgtable">
	        <tr>
	          <td valign="top">詳細４画像</td>
	        </tr>
	        <tr>
	          <td width="110" height="110"><?php echo $imgAr['syousai_img4']; ?>
	            <br />
	            <?php echo $this->request->data[$modelName]['syousai_co4']; ?></td>
	        </tr>
	        <tr>
	          <td class="input" id="outer11">
<?php echo $this->Form->create(false,array('name'=>'form4','id'=>'form4','type'=>'post','url'=>'imgAdd#2','enctype' => 'multipart/form-data'))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('img_syurui',array('value'=>'syousai_img4'))."\n"
.$this->Form->input('img', array('id'=>'form4Img','type'=>'file','label' => false))."\n"
.'<span class="errmsg" id="msgform4"></span>コメント：'
.$this->Form->text($modelName.'.syousai_co4',array('style'=>'width:200px'))
.'<br /><br />
<input type="button" value="登録／変更" onClick="check_in1(\'form4\')">'
.$this->Form->end(); ?>
	            </td>
	        </tr>
	        <tr>
	          <td>
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'imgAdd#2','onSubmit'=>"return check('詳細４画像')"))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('del',array('value'=>1))."\n"
.$this->Form->hidden('img_syurui',array('value'=>'syousai_img4'))."\n"
.$this->Form->hidden($modelName.'.syousai_img4')."\n"
.$this->Form->hidden($modelName.'.syousai_co4',array('value'=>''))."\n"
.$this->Form->end(array('label'=>'削除','div'=>false)); ?>
	            </td>
	        </tr>
	      </table></td>
	    <td align="center" valign="middle" id="border"><table border="0" align="center" class="imgtable">
	        <tr>
	          <td valign="top">詳細５画像</td>
	        </tr>
	        <tr>
	          <td width="110" height="110"><?php echo $imgAr['syousai_img5']; ?>
	            <br />
	            <?php echo $this->request->data[$modelName]['syousai_co5']; ?></td>
	        </tr>
	        <tr>
	          <td class="input" id="outer11">
<?php echo $this->Form->create(false,array('name'=>'form5','id'=>'form5','type'=>'post','url'=>'imgAdd#2','enctype' => 'multipart/form-data'))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('img_syurui',array('value'=>'syousai_img5'))."\n"
.$this->Form->input('img', array('id'=>'form5Img','type'=>'file','label' => false))."\n"
.'<span class="errmsg" id="msgform5"></span>コメント：'
.$this->Form->text($modelName.'.syousai_co5',array('style'=>'width:200px'))
.'<br /><br />
<input type="button" value="登録／変更" onClick="check_in1(\'form5\')">'
.$this->Form->end(); ?>
	            </td>
	        </tr>
	        <tr>
	          <td>
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'imgAdd#2','onSubmit'=>"return check('詳細５画像')"))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('del',array('value'=>1))."\n"
.$this->Form->hidden('img_syurui',array('value'=>'syousai_img5'))."\n"
.$this->Form->hidden($modelName.'.syousai_img5')."\n"
.$this->Form->hidden($modelName.'.syousai_co5',array('value'=>''))."\n"
.$this->Form->end(array('label'=>'削除','div'=>false)); ?>
	            </td>
	        </tr>
	      </table></td>
	  </tr>
	  <tr>
	    <td align="center" valign="middle" id="border"><table border="0" align="center" class="imgtable">
	        <tr>
	          <td id="3" valign="top">詳細６画像</td>
	        </tr>
	        <tr>
	          <td width="110" height="110"><?php echo $imgAr['syousai_img6']; ?>
	            <br />
	            <?php echo $this->request->data[$modelName]['syousai_co6']; ?></td>
	        </tr>
	        <tr>
	          <td class="input" id="outer11">
<?php echo $this->Form->create(false,array('name'=>'form6','id'=>'form6','type'=>'post','url'=>'imgAdd#3','enctype' => 'multipart/form-data'))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('img_syurui',array('value'=>'syousai_img6'))."\n"
.$this->Form->input('img', array('id'=>'form6Img','type'=>'file','label' => false))."\n"
.'<span class="errmsg" id="msgform6"></span>コメント：'
.$this->Form->text($modelName.'.syousai_co6',array('style'=>'width:200px'))
.'<br /><br />
<input type="button" value="登録／変更" onClick="check_in1(\'form6\')">'
.$this->Form->end(); ?>
	            </td>
	        </tr>
	        <tr>
	          <td>
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'imgAdd#3','onSubmit'=>"return check('詳細６画像')"))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('del',array('value'=>1))."\n"
.$this->Form->hidden('img_syurui',array('value'=>'syousai_img6'))."\n"
.$this->Form->hidden($modelName.'.syousai_img6')."\n"
.$this->Form->hidden($modelName.'.syousai_co6',array('value'=>''))."\n"
.$this->Form->end(array('label'=>'削除','div'=>false)); ?>
	            </td>
	        </tr>
	      </table></td>
	    <td align="center" valign="middle" id="border"><table border="0" align="center" class="imgtable">
	        <tr>
	          <td valign="top">詳細７画像</td>
	        </tr>
	        <tr>
	          <td width="110" height="110"><?php echo $imgAr['syousai_img7']; ?>
	            <br />
	            <?php echo $this->request->data[$modelName]['syousai_co7']; ?></td>
	        </tr>
	        <tr>
	          <td class="input" id="outer11">
<?php echo $this->Form->create(false,array('name'=>'form7','id'=>'form7','type'=>'post','url'=>'imgAdd#3','enctype' => 'multipart/form-data'))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('img_syurui',array('value'=>'syousai_img7'))."\n"
.$this->Form->input('img', array('id'=>'form7Img','type'=>'file','label' => false))."\n"
.'<span class="errmsg" id="msgform7"></span>コメント：'
.$this->Form->text($modelName.'.syousai_co7',array('style'=>'width:200px'))
.'<br /><br />
<input type="button" value="登録／変更" onClick="check_in1(\'form7\')">'
.$this->Form->end(); ?>
	            </td>
	        </tr>
	        <tr>
	          <td>
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'imgAdd#3','onSubmit'=>"return check('詳細７画像')"))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('del',array('value'=>1))."\n"
.$this->Form->hidden('img_syurui',array('value'=>'syousai_img7'))."\n"
.$this->Form->hidden($modelName.'.syousai_img7')."\n"
.$this->Form->hidden($modelName.'.syousai_co7',array('value'=>''))."\n"
.$this->Form->end(array('label'=>'削除','div'=>false)); ?>
	            </td>
	        </tr>
	      </table></td>
	    <td align="center" valign="middle" id="border"><table border="0" align="center" class="imgtable">
	        <tr>
	          <td valign="top">詳細８画像</td>
	        </tr>
	        <tr>
	          <td width="110" height="110"><?php echo $imgAr['syousai_img8']; ?>
	            <br />
	            <?php echo $this->request->data[$modelName]['syousai_co8']; ?></td>
	        </tr>
	        <tr>
	          <td class="input" id="outer11">
<?php echo $this->Form->create(false,array('name'=>'form8','id'=>'form8','type'=>'post','url'=>'imgAdd#3','enctype' => 'multipart/form-data'))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('img_syurui',array('value'=>'syousai_img8'))."\n"
.$this->Form->input('img', array('id'=>'form8Img','type'=>'file','label' => false))."\n"
.'<span class="errmsg" id="msgform8"></span>コメント：'
.$this->Form->text($modelName.'.syousai_co8',array('style'=>'width:200px'))
.'<br /><br />
<input type="button" value="登録／変更" onClick="check_in1(\'form8\')">'
.$this->Form->end(); ?>
	            </td>
	        </tr>
	        <tr>
	          <td>
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'imgAdd#3','onSubmit'=>"return check('詳細８画像')"))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('del',array('value'=>1))."\n"
.$this->Form->hidden('img_syurui',array('value'=>'syousai_img8'))."\n"
.$this->Form->hidden($modelName.'.syousai_img8')."\n"
.$this->Form->hidden($modelName.'.syousai_co8',array('value'=>''))."\n"
.$this->Form->end(array('label'=>'削除','div'=>false)); ?>
	            </td>
	        </tr>
	      </table></td>
	    <td align="center" valign="middle" id="border"><table border="0" align="center" class="imgtable">
	        <tr>
	          <td valign="top">詳細９画像</td>
	        </tr>
	        <tr>
	          <td width="110" height="110"><?php echo $imgAr['syousai_img9']; ?>
	            <br />
	            <?php echo $this->request->data[$modelName]['syousai_co9']; ?></td>
	        </tr>
	        <tr>
	          <td class="input" id="outer11">
<?php echo $this->Form->create(false,array('name'=>'form9','id'=>'form9','type'=>'post','url'=>'imgAdd#3','enctype' => 'multipart/form-data'))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('img_syurui',array('value'=>'syousai_img9'))."\n"
.$this->Form->input('img', array('id'=>'form9Img','type'=>'file','label' => false))."\n"
.'<span class="errmsg" id="msgform9"></span>コメント：'
.$this->Form->text($modelName.'.syousai_co9',array('style'=>'width:200px'))
.'<br /><br />
<input type="button" value="登録／変更" onClick="check_in1(\'form9\')">'
.$this->Form->end(); ?>
	            </td>
	        </tr>
	        <tr>
	          <td>
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'imgAdd#3','onSubmit'=>"return check('詳細９画像')"))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('del',array('value'=>1))."\n"
.$this->Form->hidden('img_syurui',array('value'=>'syousai_img9'))."\n"
.$this->Form->hidden($modelName.'.syousai_img9')."\n"
.$this->Form->hidden($modelName.'.syousai_co9',array('value'=>''))."\n"
.$this->Form->end(array('label'=>'削除','div'=>false)); ?>
	            </td>
	        </tr>
	      </table></td>
	    <td align="center" valign="middle" id="border"><table border="0" align="center" class="imgtable">
	        <tr>
	          <td valign="top">詳細１０画像</td>
	        </tr>
	        <tr>
	          <td width="110" height="110"><?php echo $imgAr['syousai_img10']; ?>
	            <br />
	            <?php echo $this->request->data[$modelName]['syousai_co10']; ?></td>
	        </tr>
	        <tr>
	          <td class="input" id="outer11">
<?php echo $this->Form->create(false,array('name'=>'form10','id'=>'form10','type'=>'post','url'=>'imgAdd#3','enctype' => 'multipart/form-data'))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('img_syurui',array('value'=>'syousai_img10'))."\n"
.$this->Form->input('img', array('id'=>'form10Img','type'=>'file','label' => false))."\n"
.'<span class="errmsg" id="msgform10"></span>コメント：'
.$this->Form->text($modelName.'.syousai_co10',array('style'=>'width:200px'))
.'<br /><br />
<input type="button" value="登録／変更" onClick="check_in1(\'form10\')">'
.$this->Form->end(); ?>
	            </td>
	        </tr>
	        <tr>
	          <td>
<?php echo $this->Form->create(false,array('type'=>'post','url'=>'imgAdd#3','onSubmit'=>"return check('詳細１０画像')"))."\n"
.$this->Form->hidden('page')."\n"
.$this->Form->hidden($modelName.'.id')."\n"
.$this->Form->hidden('del',array('value'=>1))."\n"
.$this->Form->hidden('img_syurui',array('value'=>'syousai_img10'))."\n"
.$this->Form->hidden($modelName.'.syousai_img10')."\n"
.$this->Form->hidden($modelName.'.syousai_co10',array('value'=>''))."\n"
.$this->Form->end(array('label'=>'削除','div'=>false)); ?>
	            </td>
	        </tr>
	      </table></td>
	  </tr>
	</table>
	<br /><br /><br /><br />
</div>
<div class="copyright">
	<hr width="950" size="1" />
	不動産検索システム ebs3 Copyright(C) <a href="http://infotese.com" target="_blank">ITS</a>
</div>
