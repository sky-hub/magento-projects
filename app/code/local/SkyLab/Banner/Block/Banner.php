<?php

/**
 * Class SkyLab_Banner_Block_Banner
 */
class SkyLab_Banner_Block_Banner extends Mage_Core_Block_Template
{

    /**
     * @var SkyLab_Banner_Helper_Data
     */
    protected $_helper;

    /**
     * Retrieve base skylab_banner helper
     *
     * @return SkyLab_Banner_Helper_Data
     */
    protected function _getHelper()
    {
        if (!$this->_helper) {
            $this->_helper = Mage::helper('skylab_banner');
        }

        return $this->_helper;
    }

    /**
     * Get current product
     *
     * @return mixed
     */
    protected function _getCurrentProduct()
    {
        return Mage::registry('current_product');
    }

    /**
     * Get current category
     *
     * @return mixed
     */
    protected function _getCurrentCategory()
    {
        return Mage::registry('current_category');
    }

    /**
     * Initialize Banner
     */
    public function _construct()
    {
        // check if banners are disabled for current store
        if(!$this->_getHelper()->isActive(Mage::app()->getStore()->getId())) {
            return false;
        }

        parent::_construct();

        $_helper = $this->_getHelper();
        if ($_helper->getUsedLibrary() == SkyLab_Banner_Helper_Data::BANNER_LIBRARY_JQUERY) {
            $this->setTemplate('skylab/banner/jquery.phtml');
        }
        else if ($_helper->getUsedLibrary() == SkyLab_Banner_Helper_Data::BANNER_LIBRARY_FOUNDATION) {
            $this->setTemplate('skylab/banner/foundation.phtml');
        }
    }

    /**
     * Get filters
     *
     * @return mixed
     * @throws Exception
     */
    protected function _getFilters()
    {
        $filters['store']      = Mage::app()->getStore();
        $filters['identifier'] = $this->getIdentifier();

        // product page
        if($this->_getCurrentProduct()) {
            $filters['product'] = $this->_getCurrentProduct();
        }

        // category page
        if($this->_getCurrentCategory() && !$this->_getCurrentProduct()) {
            $filters['category'] = $this->_getCurrentCategory();
        }

        // cms page but not homepage
        if($this->getRequest()->getRouteName() == 'cms') {
            $filters['cms'] = Mage::getSingleton('cms/page');
        }

        // catalog search
        if($this->getPageType() == 'catalogsearch') {
            $filters['search'] = true;
        }

        // is primary banner group
        if($this->getIsPrimary()) {
            $filters['is_primary'] = (int) $this->getIsPrimary();
        }

        return $filters;
    }

    /**
     * Get group by identifier
     *
     * @return bool|SkyLab_Banner_Model_Group
     */
    public function getGroup()
    {
        $filters = $this->_getFilters();

        $model = Mage::getModel('skylab_banner/group');
        $model->setFilters($filters);

        $group = $model->getAssignedGroup();
        if(!$group) {
            return false;
        }

        /**
         * Do not show group if block is_primary attribute is different than group is_primary attribute
         * Avoid showing primary banner group in different places than the one defined in layout xml
         */
        if((int)$this->getIsPrimary() != (int)$group->getIsPrimary()) {
            return false;
        }

        return $group;
    }

}
