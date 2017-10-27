<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/22
 * Time: 下午3:54
 */

namespace e\components;

use common\models\ar\UyeOrg;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class EController extends Controller
{
    public $org_id;
    public $org;
    public $user;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->checkRight();
        $this->org_id = Yii::$app->user->identity->org_id;
        $this->org = $this->getOrgInfo();

    }

    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        } else {
            return true;
        }
    }
    

    public function checkRight()
    {
        $user = RbacUtil::checkUserRight(Yii::$app->user->identity->id);
        if (empty($user)) {
            throw new BadRequestHttpException("权限不足");
        } else {
            Yii::$app->params['userInfo'] = $user;
            $this->user = $user;
        }
    }

    /**
     * @param string $key
     * @return array|mixed
     */
    public function getParams($key = '')
    {
        $request = Yii::$app->request;

        $method = strtolower($request->method);
        switch ($method) {
            case 'get':
                return $request->get($key);
                break;
            case 'post':
                return $request->post($key);
                break;
            default:
                return '';
                break;
        }
    }

    public function getOrgInfo()
    {
        $orgInfo = UyeOrg::findOne($this->org_id)->getAttributes();
        if (empty($orgInfo)) {
            throw new NotFoundHttpException(ERROR_ORG_NOT_EXISTS_CONTENT, ERROR_ORG_NOT_EXISTS);
        }
        return $orgInfo;
    }

}