<?php

/**
 * Class SkyLab_Banner_Model_Group
 */
class SkyLab_Banner_Model_Group extends Mage_Core_Model_Abstract
{

    /**
     * @var Filters
     */
    protected $_filters = array();

    /**
     * @var Banners Instance
     */
    protected $_bannersInstance = null;

    /**
     * @var Category Instance
     */
    protected $_categoryInstance = null;

    /**
     * @var Product Instance
     */
    protected $_productInstance = null;

    /**
     * @var Cms Page Instance
     */
    protected $_pagesInstance = null;

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('skylab_banner/group');
    }

    public function setFilters($filters)
    {
        $this->_filters = $filters;
    }

    public function getFilters()
    {
        return $this->_filters;
    }

    /**
     * Load object data
     *
     * @param mixed $id
     * @param string $field
     * @return SkyLab_Banner_Model_Group
     */
    public function load($id, $field=null)
    {
        return parent::load($id, $field);
    }

    /**
     * Get Current Group
     */
    protected function _getCurrentGroup()
    {
        Mage::registry('current_banner_group');
    }

    /**
     * Get Group Banners Instance
     *
     * @return Mage_Core_Model_Abstract
     */
    public function getBannersInstance()
    {
        if (!$this->_bannersInstance) {
            $this->_bannersInstance = Mage::getSingleton('skylab_banner/group_banner');
        }

        return $this->_bannersInstance;
    }

    /**
     * Get Selected Banners
     *
     * @return array
     */
    public function getSelectedBanners()
    {
        if (!$this->hasSelectedBanners()) {
            $banners = array();
            foreach ($this->getSelectedBannersCollection() as $banner) {
                $banners[] = $banner;
            }
            $this->setSelectedBanners($banners);
        }

        return $this->getData('selected_banners');
    }

    /**
     * Get Selected Banners Collection
     *
     * @return SkyLab_Banner_Model_Resource_Group_Banner_Collection
     */
    public function getSelectedBannersCollection()
    {
        $collection = $this->getBannersInstance()->getBannersCollection($this);

        return $collection;
    }

    /**
     * Get Group Category Instance
     *
     * @return Mage_Core_Model_Abstract
     */
    public function getCategoryInstance()
    {
        if (!$this->_categoryInstance) {
            $this->_categoryInstance = Mage::getSingleton('skylab_banner/group_category');
        }

        return $this->_categoryInstance;
    }

    /**
     * Get Selected Categories
     *
     * @return array
     */
    public function getSelectedCategories()
    {
        if (!$this->hasSelectedCategories()) {
            $categories = array();
            foreach ($this->getSelectedCategoriesCollection() as $category) {
                $categories[] = $category;
            }
            $this->setSelectedCategories($categories);
        }

        return $this->getData('selected_categories');
    }

    /**
     * Get Selected Categories Collection
     *
     * @return SkyLab_Banner_Model_Resource_Group_Category_Collection
     */
    public function getSelectedCategoriesCollection()
    {
        $collection = $this->getCategoryInstance()->getCategoryCollection($this);

        return $collection;
    }

    /**
     * Get Group Product Instance
     *
     * @return Mage_Core_Model_Abstract
     */
    public function getProductInstance()
    {
        if (!$this->_productInstance) {
            $this->_productInstance = Mage::getSingleton('skylab_banner/group_product');
        }

        return $this->_productInstance;
    }

    /**
     * Get Selected Products
     *
     * @return array
     */
    public function getSelectedProducts()
    {
        if (!$this->hasSelectedProducts()) {
            $products = array();
            foreach ($this->getSelectedProductsCollection() as $product) {
                $products[] = $product;
            }
            $this->setSelectedProducts($products);
        }

        return $this->getData('selected_products');
    }

    /**
     * Get Selected Products Collection
     *
     * @return SkyLab_Banner_Model_Resource_Group_Product_Collection
     */
    public function getSelectedProductsCollection()
    {
        $collection = $this->getProductInstance()->getProductCollection($this);

        return $collection;
    }

    /**
     * Get Group Cms Page Instance
     *
     * @return Mage_Core_Model_Abstract
     */
    public function getPagesInstance()
    {
        if (!$this->_pagesInstance) {
            $this->_pagesInstance = Mage::getSingleton('skylab_banner/group_cms');
        }

        return $this->_pagesInstance;
    }

    /**
     * Get Selected Cms Pages
     *
     * @return array
     */
    public function getSelectedPages()
    {
        if (!$this->hasSelectedPages()) {
            $pages = array();
            foreach ($this->getSelectedPagesCollection() as $page) {
                $pages[] = $page;
            }
            $this->setSelectedPages($pages);
        }

        return $this->getData('selected_pages');
    }

    /**
     * Get Selected Cms Pages Collection
     *
     * @return SkyLab_Banner_Model_Resource_Group_Cms_Collection
     */
    public function getSelectedPagesCollection()
    {
        $collection = $this->getPagesInstance()->getPagesCollection($this);

        return $collection;
    }

    /**
     * Get Group Banners
     *
     * @return object SkyLab_Banner_Model_Group_Resource_Collection
     */
//    public function getGroupBanners()
//    {
//        $collection = Mage::getModel('skylab_banner/group_banner')->getCollection();
//        $collection->addGroupFilter($this);
//
//        return $collection;
//    }

    /**
     * Get Group Categories
     *
     * @return object SkyLab_Banner_Model_Group_Resource_Collection
     */
//    public function getGroupCategories()
//    {
//        $collection = Mage::getModel('skylab_banner/group_category')->getCollection();
//        $collection->addGroupFilter($this);
//
//        return $collection;
//    }

    /**
     * Get Group Products
     *
     * @return object SkyLab_Banner_Model_Group_Resource_Collection
     */
//    public function getGroupProducts()
//    {
//        $collection = Mage::getModel('skylab_banner/group_product')->getCollection();
//        $collection->addGroupFilter($this);
//
//        return $collection;
//    }

    /**
     * Get Group Pages
     *
     * @return object SkyLab_Banner_Model_Group_Resource_Collection
     */
//    public function getGroupPages()
//    {
//        $collection = Mage::getModel('skylab_banner/group_cms')->getCollection();
//        $collection->addGroupFilter($this);
//
//        return $collection;
//    }

    /**
     * Get assigened group
     *
     * @return SkyLab_Banner_Model_Group|bool
     */
    public function getAssignedGroup()
    {
        $filters    = $this->getFilters();
        $collection = $this->getCollection();
        $collection->applyFilters($filters);

        $groupId = $collection->getFirstItem()->getId();
        if(!$groupId) {
            return false;
        }

        $this->load($groupId);

        return $this;
    }

}
