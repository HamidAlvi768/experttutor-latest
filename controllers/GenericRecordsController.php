<?php

namespace app\controllers;

use app\models\GenericRecords;
use app\models\GenericRecordsSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GenericRecordsController implements the CRUD actions for GenericRecords model.
 */
class GenericRecordsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all GenericRecords models.
     *
     * @return string
     */
    public function actionIndex22()
    {
        $RecordType = GenericRecords::find()->where(['parent_id' => NULL])->all();

        $this->layout = 'admin_layout';
        return $this->render('main_index', [
            'RecordType' => $RecordType,
        ]);
    }


    public function actionIndex()
    {
        $parentId = null;
        $searchModel = new GenericRecordsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $parentId);
        $dataProvider->query->orderBy(['created_at' => SORT_DESC]);


        $this->layout = 'admin_layout';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'parentId' => $parentId
        ]);
    }

    public function actionGenericType()
    {
        $parentId = Yii::$app->request->get("id");
        $searchModel = new GenericRecordsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $parentId);
        $dataProvider->query->orderBy(['created_at' => SORT_DESC]);

        $this->layout = 'admin_layout';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'parentId' => $parentId,
        ]);
    }

    /**
     * Displays a single GenericRecords model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = 'admin_layout';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new GenericRecords model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // public function actionCreate()
    // {
    //     $model = new GenericRecords();

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post()) && $model->save()) {
    //             return $this->redirect(['view', 'id' => $model->id]);
    //         }
    //     } else {
    //         $model->loadDefaultValues();
    //     }

    //     $this->layout = 'admin_layout';
    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }
    public function actionCreate()
    {
        $model = new GenericRecords();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                // If existing parent type selected
                if ($model->parent_id) {
                    $parent = GenericRecords::findOne($model->parent_id);
                    if ($parent) {
                        $model->type = $parent->type;
                    }
                } else {
                    $model->parent_id = null;
                }

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Record created successfully.');
                    return $this->redirect([$model->parent_id?'generic-type':'index', 'id' => $model->parent_id??null]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        $this->layout = 'admin_layout';
        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing GenericRecords model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     $this->layout = 'admin_layout';
    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
 $parentId = $model->parent_id;

        if ($this->request->isPost && $model->load($this->request->post())) {

            if ($model->parent_id) {
                $parent = GenericRecords::findOne($model->parent_id);
                if ($parent) {
                    $model->type = $parent->type;
                }
            } else {
                $model->parent_id = null;
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Record updated successfully.');
                return $this->redirect([$model->parent_id ? 'generic-type' : 'index', 'id' => $model->parent_id ?? null]);
            }
        }

        $this->layout = 'admin_layout';
        return $this->render('update', [
            'model' => $model,
             'parentId' => $parentId
        ]);
    }


    /**
     * Deletes an existing GenericRecords model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Record deleted successfully.');

        return $this->redirect(['index']);
    }

    /**
     * Finds the GenericRecords model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return GenericRecords the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GenericRecords::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
