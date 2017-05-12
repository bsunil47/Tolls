<?php
namespace tollbackend\controllers;


use api\models\Tripdetails;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

use tollbackend\models\LoginForm;
use yii\filters\VerbFilter;
use tollbackend\models\TollUsers;
use tollbackend\models\TollSearch;
use tollbackend\models\TollUserSearch;
use tollbackend\models\MasterVechicalTypes;
use tollbackend\models\Tolls;
use tollbackend\models\HistoryDateWithvechicaltypes;
use tollbackend\models\HistoryOfPayments;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    const STATUS_ACTIVE = 10;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','report','reports','vreport'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new TollSearch();
        $dataProvider = $searchModel->search(Yii::$app->user->identity);
//         $searchModel = new TollUserSearch();
//         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);//
        //print_r(Yii::$app->user->identity->toll_id); exit;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    public function actionReports(){
        $select ="";
        for ($i = 0; $i <= 12; $i++) {
            // $data['month_options'][]= ['name'=>date("Y-m", strtotime(date('Y-m-01') . " -$i months")),'value'=>date("M/Y", strtotime(date('Y-m-01') . " -$i months"))];
            $data['month_options'][]= ['name'=>$i,'value'=>date("M/Y", strtotime(date('Y-m-01') . " -$i months"))];

        }
        $params = Yii::$app->request->post();
        $data['vehical_types'] = (array)MasterVechicalTypes::find()->where(['country_id'=> 105])->all();
        foreach ($data['vehical_types'] as $value){
            $select .= ", SUM(amount_{$value->vechical_types_id}) as amount_{$value->vechical_types_id}, SUM(counter_{$value->vechical_types_id}) as counter_{$value->vechical_types_id}";
        }
        foreach ($data['vehical_types'] as $value){
            $vehical_type_id = $value->vechical_types_id;
            if(empty($sum_amounts)){

                $sum_amounts = "IFNULL(`amount_$vehical_type_id`,0)";
                $sum_counter = "IFNULL(`counter_$vehical_type_id`,0)";
            }else{
                $sum_amounts .= " + IFNULL(`amount_$vehical_type_id`,0) ";
                $sum_counter .= " + IFNULL(`counter_$vehical_type_id`,0) ";
            }
        }
        $amounts = "SUM($sum_amounts)";
        $counter = "SUM($sum_counter)";
        $data['history'] = HistoryDateWithvechicaltypes::find()->select("*, $select")->where("`date` BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW()")->groupBy('date')->all();
        $data['counter']  = HistoryDateWithvechicaltypes::find()->select(["$amounts as sum_amount", "$counter as sum_counter"])->where("`date` BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW()")->orderBy('date DESC')->asArray()->one();

        $data['count'] = COUNT($data['history']);
        //print_r($data); exit;
        //print_r($sample); exit;
        return $this->render('report',$data);
    }

    public function actionReport($id){
        $select ="";
        for ($i = 0; $i <= 12; $i++) {
            // $data['month_options'][]= ['name'=>date("Y-m", strtotime(date('Y-m-01') . " -$i months")),'value'=>date("M/Y", strtotime(date('Y-m-01') . " -$i months"))];
            $data['month_options'][]= ['name'=>$i,'value'=>date("M/Y", strtotime(date('Y-m-01') . " -$i months"))];

        }
        $params = Yii::$app->request->post();
        $data['vehical_types'] = (array)MasterVechicalTypes::find()->where(['country_id'=> 105])->all();
        foreach ($data['vehical_types'] as $value){
            $select .= ", SUM(amount_{$value->vechical_types_id}) as amount_{$value->vechical_types_id}, SUM(counter_{$value->vechical_types_id}) as counter_{$value->vechical_types_id}";
        }
        foreach ($data['vehical_types'] as $value){
            $vehical_type_id = $value->vechical_types_id;
            if(empty($sum_amounts)){

                $sum_amounts = "IFNULL(`amount_$vehical_type_id`,0)";
                $sum_counter = "IFNULL(`counter_$vehical_type_id`,0)";
            }else{
                $sum_amounts .= " + IFNULL(`amount_$vehical_type_id`,0) ";
                $sum_counter .= " + IFNULL(`counter_$vehical_type_id`,0) ";
            }
        }
        $amounts = "SUM($sum_amounts)";
        $counter = "SUM($sum_counter)";
        $data['toll_details'] = Tolls::find()->where(['toll_id'=>$id])->one();
        //print_r($data['toll_details']); exit;
        $data['history'] = HistoryDateWithvechicaltypes::find()->where("`date` BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() AND toll_id=$id")->all();
        $data['vehical_types'] = (array)MasterVechicalTypes::find()->where(['country_id'=> 105])->all();
        $data['counter']  = HistoryDateWithvechicaltypes::find()->select(["$amounts as sum_amount", "$counter as sum_counter"])->where("`date` BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() AND toll_id=$id")->orderBy('date DESC')->asArray()->one();
        $data['count'] = COUNT($data['history']);
        return $this->render('report',$data);
    }

    public function actionVreport($id){
        //echo 'saam'; exit;
        $select ="";
        for ($i = 0; $i <= 12; $i++) {
            // $data['month_options'][]= ['name'=>date("Y-m", strtotime(date('Y-m-01') . " -$i months")),'value'=>date("M/Y", strtotime(date('Y-m-01') . " -$i months"))];
            $data['month_options'][]= ['name'=>$i,'value'=>date("M/Y", strtotime(date('Y-m-01') . " -$i months"))];

        }
        $params = Yii::$app->request->post();
        $data['vehical_types'] = (array)MasterVechicalTypes::find()->where(['country_id'=> 105])->all();
        foreach ($data['vehical_types'] as $value){
            $select .= ", SUM(amount_{$value->vechical_types_id}) as amount_{$value->vechical_types_id}, SUM(counter_{$value->vechical_types_id}) as counter_{$value->vechical_types_id}";
        }
        foreach ($data['vehical_types'] as $value){
            $vehical_type_id = $value->vechical_types_id;
            if(empty($sum_amounts)){

                $sum_amounts = "IFNULL(`amount_$vehical_type_id`,0)";
                $sum_counter = "IFNULL(`counter_$vehical_type_id`,0)";
            }else{
                $sum_amounts .= " + IFNULL(`amount_$vehical_type_id`,0) ";
                $sum_counter .= " + IFNULL(`counter_$vehical_type_id`,0) ";
            }
        }
        $amounts = "SUM($sum_amounts)";
        $counter = "SUM($sum_counter)";
        $data['toll_details'] = Tolls::find()->where(['toll_id'=>$id])->one();
        //print_r($data['toll_details']); exit;
        $data['history'] = HistoryDateWithvechicaltypes::find()->where("`date` BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() AND toll_id=$id")->all();
        $data['vehical_types'] = (array)MasterVechicalTypes::find()->where(['country_id'=> 105])->all();
        $data['counter']  = HistoryDateWithvechicaltypes::find()->select(["$amounts as sum_amount", "$counter as sum_counter"])->where("`date` BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() AND toll_id=$id")->orderBy('date DESC')->asArray()->one();
        $data['count'] = COUNT($data['history']);
        $data['vechicals'] = Tripdetails::find()->where("toll_id = $id AND DATE(created_on) >= CURDATE() - 2")->all();
        //print_r($data); exit;
        return $this->render('vreport',$data);
    }


    public function actionLogout()
    {
        //echo 'asda'; exit;
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
