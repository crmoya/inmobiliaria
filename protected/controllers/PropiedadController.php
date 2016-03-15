<?php

class PropiedadController extends Controller {

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
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('admin','getDepartamentos','getDepartamentosAll'),
                'roles' => array('propietario'),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('admin', 'create','delete','update', 'exportarXLS','view','getDepartamentos','getDepartamentosAll'),
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
        $model = Propiedad::model()->findByPk($id);
        
        if ($model->estaAsociadaAPropietario(Yii::app()->user->id) ||
                Yii::app()->user->rol == 'administrativo' ||
                Yii::app()->user->rol == 'superusuario') {
            $this->render('view', array(
                'model' => $model,
            ));
        } else {
            throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
        }
    }

    public function actionGetDepartamentos(){
        if(isset($_POST['Contrato']['propiedad_id'])){
            $propiedad_id = $_POST['Contrato']['propiedad_id'];
            $departamentos = Departamento::model()->getListWithoutContractProp($propiedad_id);
            echo "<option value=''>Seleccione un Departamento</option>";
            foreach($departamentos as $departamento){
                echo "<option value=".$departamento->id.">".$departamento->numero."</option>";
            }
        }
        if(isset($_POST['IngresosClienteForm']['propiedad_id'])){
            $propiedad_id = $_POST['IngresosClienteForm']['propiedad_id'];
            $departamentos = Departamento::model()->getListWithContractProp($propiedad_id);
            echo "<option value=''>Seleccione un Departamento</option>";
            foreach($departamentos as $departamento){
                echo "<option value=".$departamento->id.">".$departamento->numero."</option>";
            }
        }
        
        if(isset($_POST['ListadoPrestacionesForm']['propiedad_id'])){
            $propiedad_id = $_POST['ListadoPrestacionesForm']['propiedad_id'];
            $departamentos = Departamento::model()->getListWithContractProp($propiedad_id);
            echo "<option value=''>TODOS LOS DEPARTAMENTOS</option>";
            foreach($departamentos as $departamento){
                echo "<option value=".$departamento->id.">".$departamento->numero."</option>";
            }
        }
        
        if(isset($_POST['Egreso']['propiedad_id'])){
            $propiedad_id = $_POST['Egreso']['propiedad_id'];
            $departamentos = Departamento::model()->findAllByAttributes(array('propiedad_id'=>$propiedad_id));
            echo "<option value='-1'>Seleccione Departamento</option>";
            foreach($departamentos as $departamento){
                echo "<option value=".$departamento->id.">".$departamento->numero."</option>";
            }
        }
    }
    
    public function actionGetDepartamentosAll(){
        if(isset($_POST['Mueble']['propiedad_id'])){
            $propiedad_id = $_POST['Mueble']['propiedad_id'];
            $departamentos = Departamento::model()->findAllByAttributes(array('propiedad_id'=>$propiedad_id));
            echo "<option value=''>Seleccione un Departamento</option>";
            foreach($departamentos as $departamento){
                echo "<option value=".$departamento->id.">".$departamento->numero."</option>";
            }
        }
    }
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Propiedad;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Propiedad'])) {
            $model->attributes = $_POST['Propiedad'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }
        $propietarios = Propietario::model()->getPropietariosWithRut();
        $this->render('create', array(
            'model' => $model,
            'propietarios' => $propietarios,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Propiedad'])) {
            $model->attributes = $_POST['Propiedad'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }
        $propietarios = Propietario::model()->findAll(array('select' => 'id,rut'));
        $this->render('update', array(
            'model' => $model,
            'propietarios' => $propietarios,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        if (Yii::app()->user->rol == 'administrativo' ||
                Yii::app()->user->rol == 'superusuario') {
            $dataProvider = new CActiveDataProvider('Propiedad');
        }
        if (Yii::app()->user->rol == 'propietario') {
            $propietario_id = Propietario::model()->getId(Yii::app()->user->id);
            $dataProvider = new CActiveDataProvider('Propiedad', array(
                'criteria' => array(
                    'condition' => 'propietario_id=:propietarioID',
                    'params' => array(':propietarioID' => $propietario_id),
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
        $model = new Propiedad('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Propiedad'])){
            $model->attributes = $_GET['Propiedad'];
        }
        if(Yii::app()->user->rol == 'propietario'){
            $model->propietario_nom = Yii::app()->user->name;
        }
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
        $model = Propiedad::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'propiedad-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionExportarXLS() {
        // generate a resultset
        $data = Propiedad::model()->with('propietario')->findAll();
        $this->toExcel($data, array('propietario.rut', 'nombre', 'direccion', 'mt_construidos', 'mt_terreno', 'cant_estacionamientos', 'inscripcion'), 'Propiedades', array()
        );
    }

}
