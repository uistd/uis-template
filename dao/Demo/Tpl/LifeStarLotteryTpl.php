<?php

//以下代码由工具自动生成。 数据库发生改变时，在项目主目录运行 php tool/dao/dao.php 重新生成

namespace Uis\Dao\Demo\Tpl;

use Uis\Dao\Demo\Model\LifeStarLotteryModel;
use UiStd\Mysql\TplBase;

/**
 * Class LifeStarLotteryTpl
 */
abstract class LifeStarLotteryTpl extends TplBase
{

    const TABLE_NAME = "life_star_lottery";

    const MODEL_CLASS = "Uis\Dao\Demo\Model\LifeStarLotteryModel";

    /**
     * @var string 数据库配置
     */
    protected $mysql_config_name = 'main';

    /**
     * 插入一条记录
     * @param LifeStarLotteryModel$model
     */
    public function insert(LifeStarLotteryModel $model)
    {
        $data = $model->arrayPack();
        $this->getDb()->insert('life_star_lottery', $data);
    }

    /**
     * 主键 查找
     * @param int $id
     * @return null|LifeStarLotteryModel
     */
    public function get($id)
    {
        $db = $this->getDb();
        $sql = 'SELECT * FROM `life_star_lottery` WHERE `id`="' . $id . '"';
        /** @var LifeStarLotteryModel $result */
        $result = $db->getRow($sql, self::MODEL_CLASS);
        return $result;
    }

    /**
     * 主键 查找多条记录
     * @param int[] $id_list
     * @return LifeStarLotteryModel[]
     */
    public function getIn(array $id_list)
    {
        $db = $this->getDb();
        $sql = 'SELECT * FROM `life_star_lottery` WHERE `id` in ("' . join('","', $id_list) . '")';
        $result = $db->getMultiRow($sql, self::MODEL_CLASS);
        return $result;
    }

    /**
     * 主键 更新
     * @param LifeStarLotteryModel $model
     * @param array $append_where 附加的条件
     * @return int 影响条数
     * @throws \Exception
     */
    public function update(LifeStarLotteryModel $model, $append_where = null)
    {
        $db = $this->getDb();
        $data = $model->arrayPack();
        if (!isset($data["id"])) {
            throw new \Exception("Primary key id required.");
        }
        unset($data["id"]);
        $this->whereInit()->whereSet("id", $data["id"]);
        if (is_array($append_where)) {
            $this->whereAppend($append_where);
        }
        return $db->update(self::TABLE_NAME, $data, $this->whereDump());
    }

    /**
     * 主键 删除
     * @param int $id
     * @param array $append_where 附加的条件
     * @return int 影响条数
     */
    public function delete($id, $append_where = null)
    {
        $db = $this->getDb();
        $this->whereInit()->whereSet("id", $id);
        if (is_array($append_where)) {
            $this->whereAppend($append_where);
        }
        return $db->delete(self::TABLE_NAME, $this->whereDump());
    }
}
