<?php
namespace app\models;

use yii;

/**
 * Class UserAuthLink
 * @package app\models
 *
 * var @this User
 */
trait UserAuthLink
{

    public function generate()
    {
        $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
    }

    public function sendAuthKey()
    {
        \Yii::$app->mailer->compose('@app/mail/authKey', ['user' => $this])
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($this->email)
            ->setSubject('Auth link')
            ->send();
    }
}