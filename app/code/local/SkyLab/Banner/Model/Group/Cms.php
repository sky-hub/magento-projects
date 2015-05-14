<?php

/**
 * Class SkyLab_Banner_Model_Group_Cms
 */
class SkyLab_Banner_Model_Group_Cms extends Mage_Core_Model_Abstract
{

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('skylab_banner/group_cms');
    }

    /**
     * Get Group Cms Page Collection
     *
     * @param $group
     * @return SkyLab_Banner_Model_Resource_Group_Cms_Collection
     */
    public function getPagesCollection($group)
    {
        $collection = Mage::getResourceModel('skylab_banner/group_cms_collection')
            ->addgroupFilter($group);

        return $collection;
    }

}
