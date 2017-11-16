<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/12
 * Time: 下午7:51
 */

namespace app\modules\app\actions;


use app\modules\app\components\AppAction;
use common\models\ar\UyeConfig;
use common\models\ar\UyeUserQuestion;
use components\Output;
use components\UException;
use frontend\models\DataBus;

class QuestionAction extends AppAction
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->checkLogin();
    }

    public function run()
    {
        try {
            $org_id = $this->getParams('org_id');
            $question = $this->getParams('question');
            if (empty($org_id) || !is_numeric($org_id) || empty($question)) {
                throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
            }

            $questionArr = json_decode($question, true);
            if (!is_array($questionArr)) {
                throw new UException(ERROR_SYS_PARAMS_CONTENT . ":数据格式无法json解析", ERROR_SYS_PARAMS);
            }

            $questionConfig = UyeConfig::getConfig('question');

            if (count($questionConfig) != count($questionArr)) {
                throw new UException(ERROR_SYS_PARAMS_CONTENT . ":请填写完整", ERROR_SYS_PARAMS);
            }

            foreach ($questionArr as $item) {
                if (empty($item['id']) || empty($item['answer'])) {
                    throw new UException(ERROR_SYS_PARAMS_CONTENT . ":请填写完整", ERROR_SYS_PARAMS);
                }
            }

            $userQuestion = UyeUserQuestion::getByUidAndOrgID($this->uid, $org_id);
            if (empty($userQuestion)) {
                UyeUserQuestion::_add(['uid' => $this->uid, 'org_id' => $org_id, 'question' => $question]);
            }
            Output::info(SUCCESS, SUCCESS_CONTENT);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }
}