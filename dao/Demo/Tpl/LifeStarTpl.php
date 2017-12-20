<?php

//以下代码由工具自动生成。 数据库发生改变时，在项目主目录运行 php tool/dao/dao.php 重新生成

namespace Uis\Dao\Demo\Tpl;

use Uis\Dao\Demo\Model\LifeStarModel;
use UiStd\Mysql\TplBase;

/**
 * Class LifeStarTpl
 */
abstract class LifeStarTpl extends TplBase
{

    const TABLE_NAME = "life_star";

    const MODEL_CLASS = "Uis\Dao\Demo\Model\LifeStarModel";

    /**
     * @var string 数据库配置
     */
    protected $mysql_config_name = 'main';

    /**
     * 插入一条记录
     * @param LifeStarModel$model
     */
    public function insert(LifeStarModel $model)
    {
        $data = $model->arrayPack();
        $this->getDb()->insert('life_star', $data);
    }

    /**
     * 主键 查找
     * @param int $id
     * @return null|LifeStarModel
     */
    public function get($id)
    {
        $db = $this->getDb();
        $sql = 'SELECT * FROM `life_star` WHERE `id`="' . $id . '"';
        /** @var LifeStarModel $result */
        $result = $db->getRow($sql, self::MODEL_CLASS);
        return $result;
    }

    /**
     * 主键 查找多条记录
     * @param int[] $id_list
     * @return LifeStarModel[]
     */
    public function getIn(array $id_list)
    {
        $db = $this->getDb();
        $sql = 'SELECT * FROM `life_star` WHERE `id` in ("' . join('","', $id_list) . '")';
        $result = $db->getMultiRow($sql, self::MODEL_CLASS);
        return $result;
    }

    /**
     * 主键 更新
     * @param LifeStarModel $model
     * @param array $append_where 附加的条件
     * @return int 影响条数
     * @throws \Exception
     */
    public function update(LifeStarModel $model, $append_where = null)
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

    /**
     * 索引 puid 查找多条记录
     * @param string $puid
     * @param array|null $append_where 附加的条件
     * @return LifeStarModel[]
     */
    public function batchByPuid($puid, $append_where = null)
    {
        $db = $this->getDb();
        $this->whereInit();
        $this->whereSet("puid", $puid);
        if (is_array($append_where)) {
            $this->whereAppend($append_where);
        }
        $sql = 'SELECT * FROM `life_star` WHERE '.$this->whereDump();
        return $db->getMultiRow($sql, self::MODEL_CLASS);
    }

    /**
     * 索引 puid 单条更新
     * @param string $puid
     * @param array|null $append_where 附加的条件
     * @return LifeStarModel
     */
    public function getByPuid($puid, $append_where = null)
    {
        $db = $this->getDb();
        $this->whereInit();
        $this->whereSet("puid", $puid);
        if (is_array($append_where)) {
            $this->whereAppend($append_where);
        }
        $sql = 'SELECT * FROM `life_star` WHERE '.$this->whereDump() .' LIMIT 1';
        return $db->getRow($sql, self::MODEL_CLASS);
    }

    /**
     * 索引 puid 查找多条记录
     * @param string $puid
     * @param int $tag_id
     * @param array|null $append_where 附加的条件
     * @return LifeStarModel[]
     */
    public function batchByPuidTagId($puid, $tag_id, $append_where = null)
    {
        $db = $this->getDb();
        $this->whereInit();
        $this->whereSet("puid", $puid);
        $this->whereSet("tag_id", $tag_id);
        if (is_array($append_where)) {
            $this->whereAppend($append_where);
        }
        $sql = 'SELECT * FROM `life_star` WHERE '.$this->whereDump();
        return $db->getMultiRow($sql, self::MODEL_CLASS);
    }

    /**
     * 索引 puid 单条更新
     * @param string $puid
     * @param int $tag_id
     * @param array|null $append_where 附加的条件
     * @return LifeStarModel
     */
    public function getByPuidTagId($puid, $tag_id, $append_where = null)
    {
        $db = $this->getDb();
        $this->whereInit();
        $this->whereSet("puid", $puid);
        $this->whereSet("tag_id", $tag_id);
        if (is_array($append_where)) {
            $this->whereAppend($append_where);
        }
        $sql = 'SELECT * FROM `life_star` WHERE '.$this->whereDump() .' LIMIT 1';
        return $db->getRow($sql, self::MODEL_CLASS);
    }
}
