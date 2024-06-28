<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "violations".
 *
 * @property int $id
 * @property int $car_id
 * @property string $violation_date
 * @property string $violation_time
 * @property string $violation_type
 * @property float $fine_amount
 * @property int $is_paid
 *
 * @property Car $car
 */
class Violation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'violations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['violation_date', 'violation_time', 'violation_type', 'fine_amount', 'is_paid'], 'required'],
            [['car_id', 'is_paid'], 'integer'],
            [['violation_date', 'violation_time'], 'safe'],
            [['fine_amount'], 'number'],
            [['violation_type'], 'string', 'max' => 255],
            [['car_id'], 'exist', 'skipOnError' => true, 'targetClass' => Car::class, 'targetAttribute' => ['car_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'car_id' => 'Car ID',
            'violation_date' => 'Violation Date',
            'violation_time' => 'Violation Time',
            'violation_type' => 'Violation Type',
            'fine_amount' => 'Fine Amount',
            'is_paid' => 'Is Paid',
        ];
    }

    /**
     * Gets query for [[Car]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCar()
    {
        return $this->hasOne(Car::class, ['id' => 'car_id']);
    }
}
