<?php

/**
 * Class SkyLab_Banner_Model_Group_Category
 */
class SkyLab_Banner_Model_Group_Category extends Mage_Core_Model_Abstract
{

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('skylab_banner/group_category');
    }

    /**
     * Get Group Categories Collection
     *
     * @param $group
     * @return SkyLab_Banner_Model_Resource_Group_Category_Collection
     */
    public function getCategoryCollection($group)
    {
        $collection = Mage::getResourceModel('skylab_banner/group_category_collection')
            ->addgroupFilter($group);

        return $collection;
    }

}
