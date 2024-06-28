<?php

namespace app\controllers;

use Yii;
use app\models\Violation;
use app\models\Car;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ViolationController implements the CRUD actions for Violation model.
 */
class ViolationController extends Controller
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
     * Lists all Violation models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Violation::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Violation model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Violation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($carId = null)
    {
        $model = new Violation();
        $car = null;

        if ($this->request->isPost) {
            $regNumber = $this->request->post('Car')['reg_number'];
            $ownerId = Yii::$app->user->id;

            $car = Car::findByRegNumber($regNumber);
            if (!$car) {
                $car = new Car();
                $car->reg_number = $regNumber;
                $car->owner_id = $ownerId;
                $car->save();
            }

            $model->load($this->request->post());
            $model->car_id = $car->id;

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось сохранить нарушение.');
            }
        } else {
            $model = new Violation();
            $model->loadDefaultValues();
            $car = new Car();
        }

        return $this->render('create', [
            'model' => $model,
            'car' => $car,
        ]);
    }

    /**
     * Updates an existing Violation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $car = $model->car;

        return $this->render('update', [
            'model' => $model,
            'car' => $car,
        ]);
    }

    public function actionPay($id)
    {
        $model = $this->findModel($id);
        $car = $model->car;
        $model->is_paid = 1;

        if ($model->save()) {
            // Проверяем, все ли нарушения для машины оплачены
            if ($car->areAllViolationsPaid()) {
                // Удаляем машину и связанные с ней нарушения
                $car->deleteWithViolations();
            }
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'Не удалось оплатить штраф.');
            return $this->redirect(['update', 'id' => $model->id]);
        }
    }

    /**
     * Deletes an existing Violation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Violation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Violation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Violation::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
