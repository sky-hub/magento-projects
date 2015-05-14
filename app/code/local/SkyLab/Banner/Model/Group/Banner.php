<?php

/**
 * Class SkyLab_Banner_Model_Group_Banner
 */
class SkyLab_Banner_Model_Group_Banner extends Mage_Core_Model_Abstract
{

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('skylab_banner/group_banner');
    }

    /**
     * Get Group Banners Collection
     *
     * @param $group
     * @return SkyLab_Banner_Model_Resource_Group_Banner_Collection
     */
    public function getBannersCollection($group)
    {
        $collection = Mage::getModel('skylab_banner/banner')->getCollection();
        $collection->getSelect()
            ->reset(Zend_Db_Select::COLUMNS)
            ->columns('id')
            ->columns('title')
            ->columns('content')
            ->columns('url')
            ->columns('url_target')
            ->columns('image')
            ->columns('is_active')
            ->columns('button')
            ->columns('button_text')
            ->columns('group_banner.position');

        $collection->addFieldToFilter('main_table.is_active', 1);
        $collection->addgroupFilter($group);
        $collection->setOrder('group_banner.position', 'ASC');

        return $collection;
    }

    /**
     * Get Group Banners
     *
     * @param $group
     * @return array
     */
    public function getGroupBanners($group)
    {
        $collection = Mage::getModel('skylab_banner/group_banner')->getCollection();
        $collection->addFieldToFilter('group_id', $group->getId());

        return $collection->getColumnValues('banner_id');
    }

}
