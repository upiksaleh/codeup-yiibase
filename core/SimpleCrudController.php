<?php
/**
 * CodeUP Framework using Yii Framework
 * @author Upik Saleh <upxsal@gmail.com>
 * @license MIT
 */

namespace codeup\core;
use Yii;
use yii\base\ViewNotFoundException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class SimpleCrudController extends USController
{
    /** @var \codeup\core\ActiveRecord main model*/
    public $model;

    /** @var array query params untuk edit view */
    public $queryParams = [];

    /** @var array options pada datatable */
    public $datatableOptions = [];

    /** @var array options detail view pada view action */
    public $detailViewOptions = [];

    /** */
    public $field_upload = [];
    public $codeup_rules = [];
    /**
     * @var array role yang diijinkan untuk mengakses controller
     */
    public $codeup_role_field = ['system'];

    /**
     * @var bool|array mengatur apakah bisa melakukan insert. jika array maka akan diseleksi role user
     */
    public $role_can_insert = true;

    /**
     * @var bool|array mengatur apakah bisa melakukan update. jika array maka akan diseleksi role user
     */
    public $role_can_update = true;

    /**
     * @var bool|array mengatur apakah bisa melakukan hapus. jika array maka akan diseleksi role user
     */
    public $role_can_delete = true;


    /**
     * @var bool|array mengatur tombol aksi pada datatable, jika array maka akan diseleksi role user
     */
    public $dt_aksi = true;

    public $find_where = [];
    public $find_order = [];

    public function behaviors()
    {
        $this->codeup_role_field = array_merge(['system'],$this->codeup_role_field);
        $rules = [
            ['allow' => true, 'codeup_role_field'=>$this->codeup_role_field]
        ];
        if(!empty($this->codeup_rules))
            $rules = $this->codeup_rules;
        return [
            'access' => [
                'class' => 'codeup\filters\AccessControl',
                'rules' =>
                    array_merge($this->codeup_rules,
                        [
                            ['allow' => true, 'actions'=>['index','print','view','update','delete','create','datatable'],'codeup_role_field'=>$this->codeup_role_field]
                        ]),
            ],
            'verbs' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function init()
    {
        parent::init();
    }

    // --------------------------------------------------------------------

    /**
     * @param  string $view nama file view
     * @return string full path view dengan extensi
     */
    public function getViewFile($view){
        $viewFile = $this->getViewPath() . '/' . $view . '.'. $this->view->defaultExtension;
        if (is_readable($viewFile)) {
            return $viewFile;
        }else{
            return Yii::getAlias('@app/views/_simplecrud/') . $view . '.'.$this->view->defaultExtension;
        }
    }

    // --------------------------------------------------------------------

    public function render($view, $params = [])
    {
        try{
            return parent::render($view, $params);
        }catch(ViewNotFoundException $e){
            return parent::render('@app/views/_simplecrud/'.$view, $params);
        }
    }
    // --------------------------------------------------------------------
    public function renderAjax($view, $params = [])
    {
        try{
            return parent::renderAjax($view, $params);
        }catch(ViewNotFoundException $e){
            return parent::renderAjax('@app/views/_simplecrud/'.$view, $params);
        }
    }
    // --------------------------------------------------------------------
    public function actions()
    {
        $model = $this->model;
        if(!empty($this->find_where))
            $model = $model::find()->where($this->find_where);
        else
            $model = $model::find();
        if(!empty($this->find_order))
            $model->orderBy($this->find_order);
        return [
            'datatable' => [
                'class' => 'codeup\widgets\datatable\DataTableAction',
                'query' => $model

            ],
        ];
    }
    // --------------------------------------------------------------------
    public function actionIndex(){
        $model = new $this->model();
        return $this->render('index', [
            'model' => $model
        ]);
    }
    // --------------------------------------------------------------------
    public function actionView(){
        $id = Yii::$app->request->getQueryParams();
        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                'model' => $this->findModel($id)
            ]);
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    // --------------------------------------------------------------------

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate(){
        $this->view->params['titleDesc'] =Yii::t('app','Tambah');
        /** @var $model \codeup\core\ActiveRecord */
        $model = new $this->model();
        $model->scenario = 'create';
        $model->loadDefaultValues();
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                if(!empty($this->field_upload)){
                    $field_db_value = [];
                    foreach($this->field_upload as $field => $field_options) {
                        //$model->{$field} = ;
                        foreach(UploadedFile::getInstances($model, $field) as $file){
                            $format_date = Yii::$app->formatter->asDate('now','php:Y-m-d_His');
                            $file_path = $field_options['dir'] . $format_date . '.' . $file->extension;
                            if($file->saveAs($file_path)){
                                $field_db_value[$field_options['field_db']][] = $file_path;
                            }
                        }
                    }
                    foreach($field_db_value as $field => $value){
                        $model->{$field} = json_encode($value);
                    }
                }

                if($model->save(false)) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Berhasil Tambah.!'));
                    return $this->redirect(['index']);
                }
            }
            Yii::$app->session->setFlash('danger', Yii::t('app', 'Gagal Menambah.!'));
            foreach($model->getErrors() as $attribute => $err){
                Yii::$app->session->setFlash('danger', implode('<br/>', $err));
            }
            return $this->render('create', [
                'model' => $model,
                'viewForm' => $this->getViewFile('_form')
            ]);
        }elseif (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'viewForm' => $this->getViewFile('_form')
            ]);
        }
    }
    // --------------------------------------------------------------------
    public function actionUpdate(){
        $this->view->params['titleDesc'] =Yii::t('app','Update');
        $id = Yii::$app->request->getQueryParams();
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                if(!empty($this->field_upload)){
                    $field_db_value = [];
                    foreach($this->field_upload as $field => $field_options) {
                        //$model->{$field} = ;
                        foreach(UploadedFile::getInstances($model, $field) as $file){
                            $format_date = Yii::$app->formatter->asDate('now','php:Y-m-d_His');
                            $file_path = $field_options['dir'] . $format_date . '.' . $file->extension;
                            if($file->saveAs($file_path)){
                                $field_db_value[$field_options['field_db']][] = $file_path;
                            }
                        }
                    }
                    foreach($field_db_value as $field => $value){
                        $model->{$field} = json_encode($value);
                    }
                }

                if($model->save(false)) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Berhasil Update.!'));
                    return $this->redirect(['index']);
                }
            }
            Yii::$app->session->setFlash('danger', Yii::t('app', 'Gagal Update.!'));
            foreach($model->getErrors() as $attribute => $err){
                Yii::$app->session->setFlash('danger', implode('<br/>', $err));
            }
            return $this->render('update', [
                'model' => $model,
                'viewForm' => $this->getViewFile('_form')
            ]);
        }elseif (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'viewForm' => $this->getViewFile('_form')
            ]);
        }
    }

    // --------------------------------------------------------------------
    public function actionDelete(){
        $id = Yii::$app->request->getQueryParams();
        try {
            if ($this->findModel($id)->delete()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Berhasil Hapus.!'));
            }
        } catch (\Throwable $e) {
        }
        return $this->redirect(['index']);
    }

    // --------------------------------------------------------------------

    /**
     * @param $id
     * @return null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if(!empty($this->find_where))
            $id = array_merge($id, $this->find_where);
        $model = $this->model;
        if (($model = $model::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}