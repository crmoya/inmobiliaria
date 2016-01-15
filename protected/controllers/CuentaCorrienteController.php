<?php

class CuentaCorrienteController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    public function behaviors() {
        return array(
            'eexcelview' => array(
                'class' => 'ext.eexcelview.EExcelBehavior',
            ),
        );
    }

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array( 'view'),
                'roles' => array('propietario', 'superusuario', 'cliente', 'administrativo'),
            ),
            array('allow',
                'actions' => array('admin','view','update', 'exportarXLS'),
                'roles' => array('propietario', 'administrativo', 'superusuario'),
            ),
            array('allow',
                'actions' => array('delete', 'admin'),
                'roles' => array('superusuario'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        // Determino si ese usuario debe ver esta cuenta corriente o no
        if(Yii::app()->user->rol == 'propietario'){
            if (CuentaCorriente::model()->isOwnerProp(Yii::app()->user->id, $id)) {
                $this->render('view', array(
                    'model' => $this->loadModel($id),
                ));
            } else {
                throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
            }
        }
        
        if(Yii::app()->user->rol == 'cliente'){
            if (CuentaCorriente::model()->isOwnerClient(Yii::app()->user->id, $id)) {
                $this->render('view', array(
                    'model' => $this->loadModel($id),
                ));
            } else {
                throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
            }
        }
        
        if(Yii::app()->user->rol == 'superusuario' || Yii::app()->user->rol == 'administrativo'){
            $this->render('view', array(
                'model' => $this->loadModel($id),
            ));
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
       //@todo: Propietario debe poder crear nuevas cuentas ESTA FALLANDO
        $model = new CuentaCorriente;
        $modelProp = new CuentaCorrientePropietario;
        $prop_id = -1;
        if (Yii::app()->user->rol == 'propietario') {
                $prop_id = Propietario::model()->find('usuario_id=:id', array(':id' => Yii::app()->user->id))->id;
            }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CuentaCorriente'], $_POST['CuentaCorrientePropietario'])) {
            $model->attributes = $_POST['CuentaCorriente'];
            $modelProp->attributes = $_POST['CuentaCorrientePropietario'];
            if (Yii::app()->user->rol == 'propietario') {
                $modelProp->propietario_id = $prop_id;
            }

            $modelProp->cuenta_corriente_id = -1; // valor temporal para pasar la validacion


            $valid = $model->validate();
            $valid = $modelProp->validate() && $valid;
            if ($valid) {

                $model->save(false);
                $modelProp->cuenta_corriente_id = $model->id;
                $modelProp->save(false);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $propietarios = Propietario::model()->getPropietariosWithRut();
        $this->render('create', array(
            'model' => $model,
            'propModel' => $modelProp,
            'propietarios' => $propietarios,
            'prop' => $prop_id,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        // Determino si ese usuario debe ver esta cuenta corriente o no
        if (CuentaCorrientePropietario::model()->isOwner(Yii::app()->user->id, $id) ||
                Yii::app()->user->rol == 'superusuario') {
            $model = $this->loadModel($id);
            $modelProp = CuentaCorrientePropietario::model()->find('cuenta_corriente_id=:cc_id', array('cc_id' => $id));
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if($modelProp!=null){
                if (isset($_POST['CuentaCorriente'], $_POST['CuentaCorrientePropietario'])) {
                    
                    $model->attributes = $_POST['CuentaCorriente'];
                    $modelProp->attributes = $_POST['CuentaCorrientePropietario'];

                    $valid = $model->validate();
                    $valid = $modelProp->validate() && $valid;
                    
                    if ($valid) {

                        $model->save(false);
                        $modelProp->save(false);
                        $this->redirect(array('view', 'id' => $model->id));
                    }
                }
            }
            

            $propietarios = Propietario::model()->getPropietariosWithRut();
            
            $this->render('create', array(
                'model' => $model,
                'propModel' => $modelProp,
                'propietarios' => $propietarios,
            ));
        } else {
            throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        // Determino si ese usuario debe ver esta cuenta corriente o no
        if (CuentaCorrientePropietario::model()->isOwner(Yii::app()->user->id, $id) ||
                Yii::app()->user->rol == 'superusuario') {
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else {
            throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        // @todo: ver que pasa en el caso del rol administrativo
        // Se selecciona el dataProvider adecuado para cada rol
        if (Yii::app()->user->rol == 'propietario') { // propietario
            $prop_id = Propietario::model()->getId(Yii::app()->user->id);
            $dataProvider = new CActiveDataProvider('CuentaCorriente', array(
                'criteria' => array(
                    'join' => 'JOIN cuenta_corriente_propietario ON cuenta_corriente_propietario.cuenta_corriente_id = t.id',
                    'condition' => 'cuenta_corriente_propietario.propietario_id=:propID',
                    'params' => array(':propID' => $prop_id),
                )
            ));
        }
        if (Yii::app()->user->rol == 'superusuario' ||
                Yii::app()->user->rol == 'administrativo') { // superusuario o administrativo
            $dataProvider = new CActiveDataProvider('CuentaCorriente');
        }
        if (Yii::app()->user->rol == 'cliente') { // cliente
            $client_id = Cliente::model()->getId(Yii::app()->user->id);
            $dataProvider = new CActiveDataProvider('CuentaCorriente', array(
                'criteria' => array(
                    'join' => 'JOIN cuenta_corriente_cliente ccc ON ccc.cuenta_corriente_id = t.id JOIN contrato c ON ccc.contrato_id = c.id',
                    'condition' => 'c.cliente_id=:clienteID',
                    'params' => array(':clienteID' => $client_id),
                )
            ));
        }

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new CuentaCorriente('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CuentaCorriente']))
            $model->attributes = $_GET['CuentaCorriente'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = CuentaCorriente::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'cuenta-corriente-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionExportarXLS() {
        // generate a resultset
        $data = Contrato::model()->findAll();
        $this->toExcel($data, array('id', 'saldo_inicial'), 'Cuenta Corriente', array()
        );
    }

}
