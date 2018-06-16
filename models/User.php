<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @return string table name
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * Hashes password and set it to database
     *
     * @param $password
     */
    public function setPassword($password) {
        $this->password_hash = sha1($password);
    }

    /**
     * Generating authorization key for user
     */
    public function generateAuthKey() {
        try {
            $this->auth_key = Yii::$app->security->generateRandomString();
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return self::findOne(['username' => $username]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email) {
        return self::findOne(['email' => $email]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string first name
     */
    public function getFirstName() {
        return $this->first_name;
    }

    /**
     * @return string second name
     */
    public function getSecondName() {
        return $this->second_name;
    }

    /**
     * @return string email
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @return int status
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @return integer
     */
    public function getCreatedAt() {
        return $this->created_at;
    }

    /**
     * @return integer
     */
    public function getUpdatedAt() {
        return $this->updated_at;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password_hash === sha1($password);
    }
}
