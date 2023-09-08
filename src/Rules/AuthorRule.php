<?php

namespace Buyandsell\Rules;

use yii\rbac\Rule;

// Проверям на соответствие user_id с текущим пользователем

class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    public function execute($idCurrent, $item, $params): bool
    {

        return isset($params['user_id']) ? $params['user_id'] == $idCurrent : false;
    }
}
