<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Login',
);
?>

<h1>Login</h1>


<div class="form">

   <?php
   $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
       'id' => 'login-form',
       'type' => 'horizontal',
       'enableClientValidation' => true,
       'clientOptions' => array(
           'validateOnSubmit' => true,
       ),
   ));
   ?>

   <p class="note">Campos con <span class="required">*</span> son obligatorios.</p>

   <?php echo $form->textFieldRow($model, 'username'); ?>

      <?php echo $form->passwordFieldRow($model, 'password'); ?>

   <div class="form-actions">
      <?php
      $this->widget('bootstrap.widgets.TbButton', array(
          'buttonType' => 'submit',
          'type' => 'primary',
          'label' => 'Login',
      ));
      ?>
   </div>
   <div>
      <p class="note">¿Olvidaste tu Clave? <?php echo CHtml::link('click aquí', CController::createUrl('/site/olvidaste')); ?></p>
   </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
