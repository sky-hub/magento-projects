<?php

/**
 * Class SkyLab_Banner_Model_Resource_Group_Banner_Collection
 */
class SkyLab_Banner_Model_Resource_Group_Banner_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    /**
     * @var bool
     */
    protected $_joinedFields = false;

    /**
     * Initialize resource
     */
    protected function _construct()
    {
        $this->_init('skylab_banner/banner');
    }

    /**
     * Join Fields
     *
     * @return SkyLab_Banner_Model_Resource_Group_Category_Collection
     */
    public function joinFields()
    {
        if (!$this->_joinedFields) {
            $this->getSelect()->join(
                array('group' => $this->getTable('skylab_banner/group')),
                'group.id = main_table.group_id',
                null
            );
            $this->_joinedFields = true;
        }

        return $this;
    }

    /**
     * Add Group Filter
     *
     * @param $group
     * @return SkyLab_Banner_Model_Resource_Group_Banner_Collection
     */
    public function addGroupFilter($group)
    {
        if ($group instanceof SkyLab_Banner_Model_Group) {
            $group = $group->getId();
        }
        if (!$this->_joinedFields) {
            $this->joinFields();
        }
        $this->getSelect()->where('group.id = ?', $group);

        return $this;
    }

}
