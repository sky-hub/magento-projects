<?php

/**
 * Class SkyLab_Banner_Model_Resource_Group_Category
 */
class SkyLab_Banner_Model_Resource_Group_Category extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Resource initialization
     */
    protected function  _construct()
    {
        $this->_init('skylab_banner/group_category', 'category_id');
    }

    /**
     * Save Group Categories
     *
     * @param $group
     * @param $data
     * @return SkyLab_Banner_Model_Resource_Group_Category
     */
    public function saveGroupCategories($group, $data)
    {
        if (!is_array($data)) {
            $data = array();
        }
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('group_id=?', $group->getId());
        $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

        foreach ($data as $categoryId) {
            if (!empty($categoryId)) {
                $this->_getWriteAdapter()->insert($this->getMainTable(), array(
                    'group_id' => $group->getId(),
                    'category_id' => $categoryId,
                ));
            }
        }
        return $this;
    }

}
