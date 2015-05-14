<?php

/**
 * Class SkyLab_Banner_Model_Resource_Group_Cms
 */
class SkyLab_Banner_Model_Resource_Group_Cms extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Resource initialization
     */
    protected function  _construct()
    {
        $this->_init('skylab_banner/group_cms', 'page_id');
    }

    /**
     * Save Group Cms Pages
     *
     * @param $group
     * @param $data
     * @return SkyLab_Banner_Model_Resource_Group_Cms
     */
    public function saveGroupPages($group, $data)
    {
        if (!is_array($data)) {
            $data = array();
        }
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('group_id=?', $group->getId());
        $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

        foreach ($data as $pageId => $position) {
            if (!empty($pageId)) {
                $this->_getWriteAdapter()->insert($this->getMainTable(), array(
                    'group_id' => $group->getId(),
                    'page_id' => $pageId,
                    'position' => $position['position']
                ));
            }
        }

        return $this;
    }

}
