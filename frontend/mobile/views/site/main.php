<?php
$this->title = '会员管理平台';
require(yii::$app->getBasePath(). '/views/_base.php');
?>
<div class="content-block-title">系统公告</div>
<?php foreach ($model as $item) { $item = (object)$item;?>
<div class="card" onclick="window.open('/news/info?id=<?=$item->ArticleID?>', '_self')">
  <div class="card-content">
    <div class="card-content-inner"><?=$item->title?></div>
  </div>
  <div class="card-footer"><?=$item->UpdateTime?></div>
</div>         
<?php } ?>
