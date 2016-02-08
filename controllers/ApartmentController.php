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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        $links = [];
        $q = Query::find()->all();
        foreach($q as $v){
            $url = $v->url;
            echo $v->url;
            echo '<br>';
        }

//        $client = new Client();
//        $res = $client->request('GET', $url);
//        echo $res->getStatusCode();

        $html = SHD::file_get_html($url);

        // Find all images
//        foreach($html->find('img') as $element)
//            echo $element->src . '<br>';

// Find all links
        foreach($html->find('.offer') as $element){
//            $model = new Apartment();
//            $e =  $element->find('a');
            var_dump($element->outertext);
        }


//            var_dump( $element) . '<hr>';


// Send an asynchronous request.
//        $request = new \GuzzleHttp\Psr7\Request('GET', $url);
//        $promise = $client->sendAsync($request)->then(function ($response) {
//            echo 'I completed! ' . $response->getStatusCode();
//        });
//
//        $promise->wait();


//        $searchModel = new ApartmentSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
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
}
