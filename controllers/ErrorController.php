<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

/**
 * Class ErrorController
 * Custom error handler
 */
class ErrorController extends Controller
{
  /**
   * @return bool|string
   */
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            $statusCode = $exception->statusCode;
            $name = $exception->getName();
            $message = $exception->getMessage();
        // При необходимости меняем шаблон
                //$this->layout = 'custom-error-layout';
                // error/fault
                return $this->render('error', [
            'exception' => $exception,
            'statusCode' => $statusCode,
            'name' => $name,
            'message' => $message
                ]);
        }
        return false;
    }
}
