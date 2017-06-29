<?php

namespace app\controllers;

use app\assets\AppAsset;
use app\models\Like;
use app\models\Query;
use app\models\search\QuerySearch;
use GuzzleHttp\Client;
use Yii;
use app\models\Apartment;
use app\models\search\ApartmentSearch;
use yii\filters\AccessControl;
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
        $r['view'] = in_array(isset($r['view']),['table','grid'])?$r['view']:'grid';

        $dataProvider = $searchModel->search($r);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'queries'=>QuerySearch::takeAll(),
            'view'=>$r['view'],
        ]);
    }

    public function actionMy()
    {
        $searchModel = new ApartmentSearch();
        $r = Yii::$app->request->queryParams;
        $r['ApartmentSearch']['like'] = 1;
        $dataProvider = $searchModel->search($r);
//        var_dump($dataProvider-)
//
        return $this->render('my', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLike($id){
        $apartment = $this->findModel($id);
        if($apartment){
//            $apartment->setlike();
//            $apartment->save();
//            if($apartment->like == 1){
            $like = new Like();
            $like->url = $apartment->url;
            $like->title = $apartment->title;
            $like->save();
            $like->link('apartment', $apartment);
//            }else{
//                $like = Like::findOne(['id'=>$apartment]);
//                $like->unlink('apartment', $apartment);
//            }

            return 'ok';
        }
        return 'error';
    }

    public function actionUnlike($id){
        $apartment = $this->findModel($id);
        if($apartment){
            $like = Like::findOne(['apartment_id'=>$apartment->id,'author_id'=>\Yii::$app->user->id]);
            if($like){
                $like->delete();
                return 'ok';
            }
//            $like->unlink('apartment', $apartment);
        }
        return 'error';
    }


    /**
     * Lists all Apartment models.
     * @return mixed
     */
    public function actionReload($id)
    {
        $q = $this->findQuery($id);
        echo $this->parseHtml($q->url, $q->id);
    }

    function parseHtml($url, $query_id){
        $html = SHD::file_get_html($url);
        $count = 0;
        foreach($html->find('#offers_table',0)->find('.offer') as $element) {
            try {
                $link       = $element->find(".link", 0);
                $price      = $element->find(".price", 0);
                $image      = $element->find("img", 0);
                $breadcrumb = $element->find('.breadcrumb span',0);
                $date       = $element->find('td[valign=bottom] p.x-normal',0);
                if(isset($link->href)) {
                    $ap = Apartment::find()->where(['url' => $link->href])->one();
                    if (!$ap) {
                        $count++;
                        $apartment = new Apartment();
                        $apartment->url         = $link->href;
                        $apartment->title       = trim($link->plaintext);
                        $apartment->address     = trim($breadcrumb->plaintext);
                        $apartment->price       = filter_var($price->plaintext, FILTER_SANITIZE_NUMBER_INT);
                        $apartment->currency    = trim(preg_replace('/\d+/u', '', $price->plaintext));
                        $apartment->query_id    = $query_id;
                        $apartment->date        = $this->parseDate(trim($date->plaintext));
                        if($image)
                            $apartment->image_link = $image->src;
                        $apartment->save();
                    }elseif(!Apartment::find()->where(['url' => $link->href])->andWhere(['query_id'=>$query_id])->one()){
                        $count++;
                        $apartment = clone $ap;
                        $apartment->query_id = $query_id;
                        $apartment->save();
                    }
                }
            }catch (\Exception $e){
                continue;
            }
        }
        return $count;
    }

    public function str_to_address($context) {
        $patern = '\d{1,10}( \w+){1,10}( ( \w+){1,10})?( \w+){1,10}[,.](( \w+){1,10}(,)? [A-Z]{2}( [0-9]{5})?)?';
        preg_match_all($patern,$context,$maches);
        $string = implode(' ', $maches);
        return $string;
    }

    public function parseDate($date)
    {
        $ru_month = array( 'янва', 'февр', 'март.', 'апре', 'май', 'июнь', 'июль', 'авгу', 'сент', 'октя', 'нояб', 'дека', 'Сегодня','Вчера');
        $en_month = array( 'January', 'February', 'March', 'May', 'June', 'July', 'August', 'September', 'Oktober', 'November', 'December','today','yesterday' );
        $date_array = date_parse( str_replace( $ru_month, $en_month, $date ) ) ;

        if (preg_match('/Вчера/',$date)) {
            $date_array['month'] = $date_array['month']?$date_array['month']:date('n');
            $date_array['day'] = $date_array['day']?$date_array['day']:date('j') - 1;
            $date_array['year'] = $date_array['year']?$date_array['year']:date('Y');
        }elseif (preg_match('/Сегодня/',$date)) {
            $date_array['month'] = $date_array['month']?$date_array['month']:date('n');
            $date_array['day'] = $date_array['day']?$date_array['day']:date('j');
            $date_array['year'] = $date_array['year']?$date_array['year']:date('Y');
        }
        return date('U', mktime(
            $date_array['hour']     ? $date_array['hour']   : date('H'),
            $date_array['minute']   ? $date_array['minute'] : date('i'),
            $date_array['second']   ? $date_array['second'] : date('s'),
            $date_array['month']    ? $date_array['month']  : date('n'),
            $date_array['day']      ? $date_array['day']    : date('j'),
            $date_array['year']     ? $date_array['year']   : date('Y')
        ));
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
     * Spam an existing Apartment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSpam($id)
    {
        $model = $this->findModel($id);
//        var_dump($model);
        for($i=0;$i<100;$i++){
            usleep(300000);
            $html = SHD::file_get_html($model->url);
        }
        $model->html = $html->find('.offercontentinner',0);
//            $model->description = $html->find('.offercontentinner',0);
//            $model->phones = $html->find('.offercontentinner',0);
//            $model->sows = $html->find('.offercontentinner',0);
//            $model->rooms = $html->find('.offercontentinner',0);
//            $model->rent_types = $html->find('.offercontentinner',0);
//            $model->images = $html->find('.offercontentinner',0);
//            $model->sows = $html->find('.offercontentinner',0);
//            $model->sows = $html->find('.offercontentinner',0);
        $model->save();


//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
    }

    /**
     * Deletes an existing Apartment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteall($id)
    {
        $q = $this->findQuery($id);
        foreach($q->apartments as $apartments){
            $this->findModel($apartments->id)->delete();
        }
//        return $this->redirect(['index',Yii::$app->request->queryParams]);
        return 'ok';
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
        return $this->redirect(['index',Yii::$app->request->queryParams]);
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

    /**
     * Displays a single Apartment model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetails($id)
    {
        $model = $this->findModel($id);

        if($model->html){
            return $this->renderPartial('details', [
                'model' => $model,
            ]);
        }else{
            $html = SHD::file_get_html($model->url);
            $model->html = $html->find('.offercontentinner',0);
//            $model->description = $html->find('.offercontentinner',0);
//            $model->phones = $html->find('.offercontentinner',0);
//            $model->sows = $html->find('.offercontentinner',0);
//            $model->rooms = $html->find('.offercontentinner',0);
//            $model->rent_types = $html->find('.offercontentinner',0);
//            $model->images = $html->find('.offercontentinner',0);
//            $model->sows = $html->find('.offercontentinner',0);
//            $model->sows = $html->find('.offercontentinner',0);
            $model->save();
            return $this->renderPartial('details', [
                'model' => $model,
            ]);
        }


    }
}
