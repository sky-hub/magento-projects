<?php

/**
 * Class SkyLab_Banner_Model_Group_Product
 */
class SkyLab_Banner_Model_Group_Product extends Mage_Core_Model_Abstract
{

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('skylab_banner/group_product');
    }

    /**
     * Get Group Product Collection
     *
     * @param $group
     * @return SkyLab_Banner_Model_Resource_Group_Product_Collection
     */
    public function getProductCollection($group)
    {
        $collection = Mage::getResourceModel('skylab_banner/group_product_collection')
            ->addgroupFilter($group);

        return $collection;
    }

}
