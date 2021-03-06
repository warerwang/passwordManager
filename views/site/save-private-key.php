<?php
/**
 * Created by PhpStorm.
 * User: warerwang
 * Date: 16-7-19
 * Time: 下午11:16
 *
 * @var View $this
 *
 */
use yii\bootstrap\ActiveForm;

use yii\helpers\Html;
use yii\web\View;
/**
 * @var \app\models\User $user
 * @var ActiveForm $form
 */
?>
<form>
    <div class="form-group field-user-privatekey">
        <label class="control-label" for="user-privatekey">Private Key</label>
        <textarea id="user-privatekey" class="form-control pkey" name="User[privatekey]" rows="10"></textarea>

        <p class="help-block help-block-error"></p>
    </div>
    <button class="btn btn-primary" type="button" id="save-key"><?= Yii::t('view', 'Save') ?></button>
</form>

<?= Html::a(Yii::t('view', 'Generate'), ['site/generate-private-key']); ?>

<?php
$this->registerJs(<<<EOF
    if(localStorage.privateKey){
        try{
            var privateKey = atob(localStorage.privateKey);
        }catch(e){
            console.error(e);
        }
        $("#user-privatekey").val(privateKey);
    }
    $('#save-key').click(function(){
        if(window.localStorage && window.btoa){
            localStorage.privateKey = btoa($('#user-privatekey').val());
            alert('保存公钥成功');
        }else{
            alert('请换一个浏览器。');
        }
        return false;
    });
EOF
)

?>