<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cars".
 *
 * @property int $id
 * @property string $reg_number
 * @property int $owner_id
 *
 * @property User $owner
 * @property Violations[] $violations
 */
namespace app\models;

use Yii;

/**
 * This is the model class for table "cars".
 *
 * @property int $id
 * @property string $reg_number
 * @property int $owner_id
 *
 * @property User $owner
 * @property Violations[] $violations
 */
class Car extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cars';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reg_number', 'owner_id'], 'required'],
            [['owner_id'], 'integer'],
            [['reg_number'], 'string', 'max' => 10],
            [['reg_number'], 'unique'],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['owner_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reg_number' => 'Reg Number',
            'owner_id' => 'Owner ID',
        ];
    }

    /**
     * Gets query for [[Owner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::class, ['id' => 'owner_id']);
    }

    /**
     * Gets query for [[Violations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViolations()
    {
        return $this->hasMany(Violation::class, ['car_id' => 'id']);
    }

    /**
     * Finds a car by registration number or creates a new one.
     *
     * @param string $regNumber
     * @param int $ownerId
     * @return Car
     */
    public static function findOrCreateByRegNumber($regNumber, $ownerId)
    {
        $car = self::findOne(['reg_number' => $regNumber]);
        if (!$car) {
            $car = new self();
            $car->reg_number = $regNumber;
            $car->owner_id = $ownerId;
            $car->save();
        }
        return $car;
    }

    /**
     * Finds a car by registration number.
     *
     * @param string $regNumber
     * @return Car|null
     */
    public static function findByRegNumber($regNumber)
    {
        return self::findOne(['reg_number' => $regNumber]);
    }

    public function areAllViolationsPaid()
    {
        $violations = $this->getViolations()->where(['is_paid' => 0])->count();
        return $violations === 0;
    }

    public function deleteWithViolations()
    {
        // Сначала удаляем связанные нарушения
        foreach ($this->violations as $violation) {
            $violation->delete();
        }
        // Затем удаляем саму машину
        $this->delete();
    }
}
