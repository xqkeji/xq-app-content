<?php
$this->setMainView("admin");
$params=xqkeji\App::getActionParams();
?>
<div id="xqkeji-form">
  <h5 class="card-header bg-success">
    <?=$pageTitle?> 
  </h5>
  <div id="xqkeji-form-body">
    <?php
    $this->outputFlash();
    echo $form;
    ?>
  </div>
</div>