<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/19
 * Time: 下午2:26
 */

namespace common\models\ar;

/**
 * This is the model class for table "uye_app_version".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $version_code
 * @property string $version_name
 * @property string $desp
 * @property string $url
 * @property integer $size
 * @property integer $force_update
 * @property integer $status
 * @property integer $created_time
 */
class UyeAppVersion extends UActiveRecord
{
    const TABLE_NAME = 'uye_app_version';

    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'version_code', 'size', 'force_update', 'status', 'created_time'], 'integer'],
            [['desp'], 'required'],
            [['desp'], 'string'],
            [['version_name', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '客户端',
            'version_code' => '版本号',
            'version_name' => '版本名称',
            'desp' => '描述',
            'url' => 'Url',
            'size' => '安卓版大小',
            'force_update' => '更新',
            'status' => '状态',
            'created_time' => '创建时间',
        ];
    }


    /**
     * 获取app版本信息
     * @param string $version
     * @param int $type
     * @param int $p
     * @param int $ps
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getVersion($version = '', $type = 2, $p = 1, $ps = 1)
    {
        $sql = self::find()
            ->select('*')
            ->from(self::TABLE_NAME)
            ->where('type=:type AND status=:status', [':type' => $type, ':status' => 0]);
        if (!empty($version)) {
            $sql->andWhere('version=:version', [':version' => $version]);
        }

        $result = $sql->orderBy("id DESC")
            ->limit($ps)
            ->offset(($p - 1) * $ps)
            ->asArray()
            ->all();

        return $result;
    }

    public static function checkForceUpdate($versionCode, $type = 2)
    {
        $res = $sql = self::find()
            ->select('*')
            ->from(self::TABLE_NAME)
            ->where('version_code=:version_code AND type=:type', [':version_code' => intval($versionCode), ':type' => $type])
            ->asArray()
            ->all();
        if ($res) {
            return empty($res[0]['force_update']) ? false : true;
        } else {
            return true;
        }
    }
}