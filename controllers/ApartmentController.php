<?php

namespace app\controllers;

use app\assets\AppAsset;
use app\models\Query;
use GuzzleHttp\Client;
use Yii;
use app\models\Apartment;
use app\models\search\ApartmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use keltstr\simplehtmldom\SimpleHTMLDom as SHD;

/**
 * ApartmentController implements the CRUD actions for Apartment model.
 */
class ApartmentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Apartment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApartmentSearch();
        $r = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($r);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Lists all Apartment models.
     * @return mixed
     */
    public function actionReload()
    {
        $r = Yii::$app->request->queryParams;
        $q = $this->findQuery(isset($r['ApartmentSearch']['query_id'])?$r['ApartmentSearch']['query_id']:null);
        $count = 0;
        $url = $q->url;
        $html = SHD::file_get_html($url);
        foreach($html->find('.offer') as $element){
            $link = $element->find(".link", 0);
            $price = $element->find(".price", 0);
            $image = $element->find("img", 0);
            $ap = Apartment::find()->where(['url' => $link->href])->one();
            if (!$ap) {
                $count++;
                $apartment = new Apartment();
                $apartment->url = $link->href;
                $apartment->title = $link->plaintext;
                $apartment->price = $price->plaintext;
                $apartment->query_id = $q->id;
                if($image)
                    $apartment->image_link = $image->src;
                $apartment->save();
            }

        }
        echo $count;
    }


    /**
     * Displays a single Apartment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Apartment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Apartment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Apartment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Apartment model.
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
     * Finds the Apartment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Apartment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apartment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findQuery($id)
    {
        if (($model = Query::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
