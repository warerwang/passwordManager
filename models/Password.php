<?php
/**
 * Created by PhpStorm.
 * User: yadongwang
 * Date: 16/6/30
 * Time: 上午12:52
 */
namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

class Password extends PasswordBase
{
    public $password;

    public function rules ()
    {
        $rules = parent::rules();
        return array_merge(
            [
                ['password', 'safe']
            ],
            $rules
        );
    }

    public function search($params)
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider(
            [
                'query'      => $query,
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]
        );
        $this->load($params);
        $query->andFilterWhere(['uid' => $this->uid]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'account', $this->account]);
        $query->andFilterWhere(['like', 'webLink', $this->webLink]);

        return $dataProvider;
    }

    public function searchByKeyword($k)
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider(
            [
                'query'      => $query,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]
        );
        $query->andFilterWhere(['uid' => $this->uid]);
        $query->andFilterWhere(['like', 'name', $k]);
        $query->orFilterWhere(['like', 'account', $k]);
        $query->orFilterWhere(['like', 'webLink', $k]);

        return $dataProvider;
    }

    public function beforeValidate ()
    {
        if(parent::beforeValidate()){
            if($this->password){
                /** @var User $user */
                $user = $this->user;
                $this->encryptPassword = Yii::$app->password->EncryptWithPublicKey($this->password, $user->publicKey);
            }
            return true;
        }
        return false;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }
}