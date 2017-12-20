<?php

//以下代码由工具自动生成。 数据库发生改变时，在项目主目录运行 php tool/dao/dao.php 重新生成

namespace Uis\Dao\Demo\Tpl;

use Uis\Dao\Demo\Model\LifeStarRecordModel;
use UiStd\Mysql\TplBase;

/**
 * Class LifeStarRecordTpl
 */
abstract class LifeStarRecordTpl extends TplBase
{

    const TABLE_NAME = "life_star_record";

    const MODEL_CLASS = "Uis\Dao\Demo\Model\LifeStarRecordModel";

    /**
     * @var string 数据库配置
     */
    protected $mysql_config_name = 'main';

    /**
     * 插入一条记录
     * @param LifeStarRecordModel$model
     */
    public function insert(LifeStarRecordModel $model)
    {
        $data = $model->arrayPack();
        $this->getDb()->insert('life_star_record', $data);
    }

    /**
     * 主键 查找
     * @param int $id
     * @return null|LifeStarRecordModel
     */
    public function get($id)
    {
        $db = $this->getDb();
        $sql = 'SELECT * FROM `life_star_record` WHERE `id`="' . $id . '"';
        /** @var LifeStarRecordModel $result */
        $result = $db->getRow($sql, self::MODEL_CLASS);
        return $result;
    }

    /**
     * 主键 查找多条记录
     * @param int[] $id_list
     * @return LifeStarRecordModel[]
     */
    public function getIn(array $id_list)
    {
        $db = $this->getDb();
        $sql = 'SELECT * FROM `life_star_record` WHERE `id` in ("' . join('","', $id_list) . '")';
        $result = $db->getMultiRow($sql, self::MODEL_CLASS);
        return $result;
    }

    /**
     * 主键 更新
     * @param LifeStarRecordModel $model
     * @param array $append_where 附加的条件
     * @return int 影响条数
     * @throws \Exception
     */
    public function update(LifeStarRecordModel $model, $append_where = null)
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
     * 索引 blog_id 查找多条记录
     * @param int $blog_id
     * @param array|null $append_where 附加的条件
     * @return LifeStarRecordModel[]
     */
    public function batchByBlogId($blog_id, $append_where = null)
    {
        $db = $this->getDb();
        $this->whereInit();
        $this->whereSet("blog_id", $blog_id);
        if (is_array($append_where)) {
            $this->whereAppend($append_where);
        }
        $sql = 'SELECT * FROM `life_star_record` WHERE '.$this->whereDump();
        return $db->getMultiRow($sql, self::MODEL_CLASS);
    }

    /**
     * 索引 blog_id 单条更新
     * @param int $blog_id
     * @param array|null $append_where 附加的条件
     * @return LifeStarRecordModel
     */
    public function getByBlogId($blog_id, $append_where = null)
    {
        $db = $this->getDb();
        $this->whereInit();
        $this->whereSet("blog_id", $blog_id);
        if (is_array($append_where)) {
            $this->whereAppend($append_where);
        }
        $sql = 'SELECT * FROM `life_star_record` WHERE '.$this->whereDump() .' LIMIT 1';
        return $db->getRow($sql, self::MODEL_CLASS);
    }
}
