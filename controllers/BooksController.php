<?php

namespace app\controllers;

use Yii;
use app\models\Books;
use app\models\BooksSearch;
use app\models\Authors;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * BooksController implements the CRUD actions for Books model.
 */
class BooksController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Books models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BooksSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $authors = $this->getAuthors();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'authors' => $authors
        ]);
    }

    /**
     * Displays a single Books model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Books model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Books();

        if ($model->load(Yii::$app->request->post())){
            $file = UploadedFile::getInstance($model, 'preview');
            if ($file && $file->tempName) {
                $model->preview = $file;
                if ($model->validate(['preview'])) {
                    $dir = Yii::$app->basePath.'/web/uploads/';
                    $fileName = $model->preview->baseName . '.' . $model->preview->extension;
                    $model->preview->saveAs($dir . $fileName);
                    $model->preview = $fileName;
                }
            }

            $model->date_create = date('Y-m-d H:i:s');
            $model->date_update = date('Y-m-d H:i:s');

            if($model->save()) {
                return $this->redirect(Yii::$app->request->referrer);
            }
        } 

        $authors = $this->getAuthors();

        return $this->renderAjax('create', [
            'model' => $model,
            'authors' => $authors
        ]); 
    }

    private function getAuthors(){
        $authors = array('' => 'Автор');
        foreach (Authors::find()->all() as $author) {
            $authors[$author->id] = $author->firstname.' '.$author->lastname;
        }
        return $authors;
    }


    /**
     * Updates an existing Books model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $preview = $model->preview;

        if ($model->load(Yii::$app->request->post())){

            $file = UploadedFile::getInstance($model, 'preview');
            if ($file && $file->tempName) {
                $model->preview = $file;
                if ($model->validate(['preview'])) {
                    $dir = Yii::$app->basePath.'/web/uploads/';
                    $fileName = $model->preview->baseName . '.' . $model->preview->extension;
                    $model->preview->saveAs($dir . $fileName);
                    $model->preview = 'uploads/'.$fileName;
                }
            }else{
                $model->preview = $preview;
            }

            $model->date_update = date('Y-m-d H:i:s');

            if($model->save()) {
                return $this->redirect(Yii::$app->request->referrer);
            }  
        } 

        $authors = $this->getAuthors();
        return $this->renderAjax('create', [
            'model' => $model,
            'authors' => $authors
        ]); 
    }

    /**
     * Deletes an existing Books model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Books model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Books the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Books::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
