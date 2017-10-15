<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/12
 * Time: 下午7:51
 */

namespace app\modules\app\actions;


use app\modules\app\components\AppAction;
use common\models\ar\UyeUserQuestion;
use components\Output;
use components\UException;
use frontend\models\DataBus;

class QuestionAction extends AppAction
{
    public function run()
    {
        try {
            $request = \Yii::$app->request;
            $uid = DataBus::get('uid');
            $org_id = $request->isPost ? $request->post('org_id') : $request->get('org_id');
            $question = $request->isPost ? $request->post('question') : $request->get('question');
            if (empty($org_id) || !is_numeric($org_id) || empty($question) || !is_array($question)) {
                throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
            }

            $userQuestion = UyeUserQuestion::find()->select('*')->where('uid=:uid AND org_id=:org_id', [':uid' => $uid, 'org_id' => $org_id])->asArray()->one();
            if (empty($userQuestion)) {
                UyeUserQuestion::_add(['uid' => $uid, 'org_id' => $org_id, 'question' => json_encode($question)]);
            } else {
                throw new UException(ERROR_USER_QUESTION_EXISTS_CONTENT, ERROR_USER_QUESTION_EXISTS);
            }
            Output::info(SUCCESS, SUCCESS_CONTENT);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }
}