<?php

/**
 * @var $user \app\models\User
 */

echo \yii\helpers\Url::to(['site/auth', 'auth_key' => $user->auth_key], true);