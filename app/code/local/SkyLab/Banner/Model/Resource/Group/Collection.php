<?php

/**
 * Class SkyLab_Banner_Model_Resource_Group_Collection
 */
class SkyLab_Banner_Model_Resource_Group_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    /**
     * Load data for preview flag
     *
     * @var bool
     */
    protected $_previewFlag;

    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('skylab_banner/group');
        $this->_map['fields']['group_id'] = 'main_table.group_id';
        $this->_map['fields']['store']    = 'banner_group_store.store_id';
        $this->_map['fields']['product']  = 'banner_group_product.product_id';
        $this->_map['fields']['category'] = 'banner_group_category.category_id';
        $this->_map['fields']['cms']      = 'banner_group_cms.page_id';
    }

    /**
     * Set first store flag
     *
     * @param bool $flag
     * @return SkyLab_Banner_Model_Resource_Group_Collection
     */
    public function setFirstStoreFlag($flag = false)
    {
        $this->_previewFlag = $flag;
        return $this;
    }

    /**
     * Perform operations after collection load
     *
     * @return SkyLab_Banner_Model_Resource_Group_Collection
     */
    protected function _afterLoad()
    {
        if ($this->_previewFlag) {
            $items = $this->getColumnValues('id');
            $connection = $this->getConnection();
            if (count($items)) {
                $select = $connection->select()
                    ->from(array('banner_group_store'=>$this->getTable('skylab_banner/group_store')))
                    ->where('banner_group_store.group_id IN (?)', $items);

                if ($result = $connection->fetchPairs($select)) {
                    foreach ($this as $item) {
                        if (!isset($result[$item->getData('id')])) {
                            continue;
                        }
                        if ($result[$item->getData('id')] == 0) {
                            $stores = Mage::app()->getStores(false, true);
                            $storeId = current($stores)->getId();
                            $storeCode = key($stores);
                        } else {
                            $storeId = $result[$item->getData('id')];
                            $storeCode = Mage::app()->getStore($storeId)->getCode();
                        }
                        $item->setData('_first_store_id', $storeId);
                        $item->setData('store_code', $storeCode);
                    }
                }
            }
        }

        return parent::_afterLoad();
    }

    /**
     * Add filter by store
     *
     * @param int|Mage_Core_Model_Store $store
     * @param bool $withAdmin
     *
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if (!$this->getFlag('store_filter_added')) {
            if ($store instanceof Mage_Core_Model_Store) {
                $store = array($store->getId());
            }

            if (!is_array($store)) {
                $store = array($store);
            }

            if ($withAdmin) {
                $store[] = Mage_Core_Model_App::ADMIN_STORE_ID;
            }

            $this->addFilter('store', array('in' => $store), 'public');
        }

        return $this;
    }

    /**
     * Add filter by product
     *
     * @param int|Mage_Catalog_Model_Product $product
     * @return $this
     */
    public function addProductFilter($product)
    {
        if (!$this->getFlag('product_filter_added')) {
            if ($product instanceof Mage_Catalog_Model_Product) {
                $product = array($product->getId());
            }

            if (!is_array($product)) {
                $product = array($product);
            }

            $this->addFilter('product', array('in' => $product), 'public');
        }

        return $this;
    }

    /**
     * Add filter by category
     *
     * @param int|Mage_Catalog_Model_Category $category
     * @return $this
     */
    public function addCategoryFilter($category)
    {
        if (!$this->getFlag('category_filter_added')) {
            if ($category instanceof Mage_Catalog_Model_Category) {
                $category = array($category->getId());
            }

            if (!is_array($category)) {
                $category = array($category);
            }

            $this->addFilter('category', array('in' => $category), 'public');
        }

        return $this;
    }

    /**
     * Add filter by cms page
     *
     * @param int|Mage_Cms_Model_Page $page
     * @return $this
     */
    public function addPageFilter($page)
    {
        if (!$this->getFlag('cms_filter_added')) {
            if ($page instanceof Mage_Cms_Model_Page) {
                $page = array($page->getId());
            }

            if (!is_array($page)) {
                $page = array($page);
            }

            $this->addFilter('cms', array('in' => $page), 'public');
        }

        return $this;
    }

    /**
     * Add filter by catalog search
     *
     * @return $this
     */
    public function addCatalogSearchFilter()
    {
        $this->addFilter('page', array('eq' => 'catalogsearch'), 'public');
    }

    /**
     * Join relation tables if filters are set
     */
    protected function _renderFiltersBefore()
    {
        // store filter
        if ($this->getFilter('store')) {
            $this->getSelect()->join(
                array('banner_group_store' => $this->getTable('skylab_banner/group_store')),
                'main_table.id = banner_group_store.group_id',
                array()
            );
        }

        //  product
        if ($this->getFilter('product')) {
            $this->getSelect()->join(
                array('banner_group_product' => $this->getTable('skylab_banner/group_product')),
                'main_table.id = banner_group_product.group_id',
                array()
            );
        }

        // category
        if ($this->getFilter('category')) {
            $this->getSelect()->join(
                array('banner_group_category' => $this->getTable('skylab_banner/group_category')),
                'main_table.id = banner_group_category.group_id',
                array()
            );
        }

        // pages
        if ($this->getFilter('cms')) {
            $this->getSelect()->join(
                array('banner_group_cms' => $this->getTable('skylab_banner/group_cms')),
                'main_table.id = banner_group_cms.group_id',
                array()
            );
        }

        $this->getSelect()->group('main_table.id');
        $this->_useAnalyticFunction = true;

        return parent::_renderFiltersBefore();
    }

    /**
     * @param $filters
     * @return SkyLab_Banner_Model_Resource_Group_Collection
     */
    public function applyFilters($filters)
    {
        $isPrimary = isset($filters['is_primary']) ? (int) $filters['is_primary'] : 0;
        $this->addFieldToFilter('is_primary', $isPrimary);

        if(isset($filters['store'])) {
            $this->addStoreFilter($filters['store']);
        }

        if(isset($filters['product'])) {
            $this->addProductFilter($filters['product']);
        }

        if(isset($filters['category'])) {
            $this->addCategoryFilter($filters['category']);
        }

        if(isset($filters['cms'])) {
            $this->addPageFilter($filters['cms']);
        }

        if(isset($filters['search'])) {
            $this->addCatalogSearchFilter();
        }

        return $this;
    }

    /**
     * Get SQL for get record count.
     * Extra GROUP BY strip added.
     *
     * @return Varien_Db_Select
     */
    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();

        $countSelect->reset(Zend_Db_Select::GROUP);

        return $countSelect;
    }

}
