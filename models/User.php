<?php

namespace app\models;

use yii\redis\ActiveRecord;
use Yii;


/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $email
 * @property string $auth_key
 * @property string $access_token
 * @property string $oauth_client
 * @property string $oauth_client_user_id
 * @property string $publicIdentity
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $logged_at
 * @property string $password write-only password
 *
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;
    const ROLE_USER = 'user';
    const ROLE_MANAGER = 'manager';
    const ROLE_ADMINISTRATOR = 'administrator';
    const EVENT_AFTER_SIGNUP = 'afterSignup';
    const EVENT_AFTER_LOGIN = 'afterLogin';
//
//    public $id;
//    public $username;
//    public $password;
//    public $authKey;
//    public $accessToken;

    public function rules()
    {
//        return [
//            [['username', 'email'], 'unique'],
//            ['status', 'default', 'value' => self::STATUS_NOT_ACTIVE],
//            ['status', 'in', 'range' => self::statuses()],
//            [['username'],'filter','filter'=>'\yii\helpers\Html::encode']
//        ];
        return
            [
                [['username','email'], 'required'],
                [[
                    'id','username','password_hash','email','auth_key',
                    'access_token','oauth_client','oauth_client_user_id',
                    'publicIdentity','status','created_at','updated_at','logged_at','password'
                ],'safe']
            ];
    }


//    public function attributes()
//    {
//        return ['id',
//            'username', 'password', 'email', 'status','authKey','accessToken','created_at','updated_at'];
//    }
//

    public function attributes(){
        return [
         'id','username','password_hash','email','auth_key',
            'access_token','oauth_client','oauth_client_user_id',
            'publicIdentity','status','created_at','updated_at','logged_at','password'
        ];
    }

//    private static $users = [
//        '100' => [
//            'id' => '100',
//            'username' => 'admin',
//            'password' => 'admin',
//            'authKey' => 'test100key',
//            'accessToken' => '100-token',
//        ],
//        '101' => [
//            'id' => '101',
//            'username' => 'demo',
//            'password' => 'demo',
//            'authKey' => 'test101key',
//            'accessToken' => '101-token',
//        ],
//    ];

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::find()
//            ->active()
            ->andWhere(['id' => $id])
            ->one();
//        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()
//            ->active()
            ->andWhere(['access_token' => $token, 'status' => 1])
            ->one();
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()
//            ->active()
            ->andWhere(['username' => $username])
            ->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }
    /**
     * Returns user statuses list
     * @return array|mixed
     */
    public static function statuses()
    {
        return [
            self::STATUS_NOT_ACTIVE => Yii::t('yii', 'Not Active'),
            self::STATUS_ACTIVE => Yii::t('yii', 'Active'),
            self::STATUS_DELETED => Yii::t('yii', 'Deleted')
        ];
    }
}
