<?php

/**
 * Class SkyLab_Banner_Model_Resource_Group
 */
class SkyLab_Banner_Model_Resource_Group extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Store model
     *
     * @var null|Mage_Core_Model_Store
     */
    protected $_store  = null;

    /**
     * Set main entity table name and primary key field name
     */
    protected function _construct()
    {
        $this->_init('skylab_banner/group', 'id');
    }

    /**
     * Process page data before deleting
     *
     * @param Mage_Core_Model_Abstract $object
     * @return \Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _beforeDelete(Mage_Core_Model_Abstract $object)
    {
        $condition = array(
            'group_id = ?' => (int) $object->getId(),
        );

        $this->_getWriteAdapter()->delete($this->getTable('skylab_banner/group_store'), $condition);

        return parent::_beforeDelete($object);
    }

    /**
     * Process page data before saving
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Mage_Cms_Model_Resource_Page
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if($this->_pagePrimaryBannerGroupExists($object)){
            Mage::throwException(Mage::helper('skylab_banner')->__('There is already a primary banner group for selected page.'));
        }

        if (!$this->getIsUniquePageToStores($object)) {
            Mage::throwException(Mage::helper('skylab_banner')->__('Group identifier already exists for specified store.'));
        }

        if (!$this->isValidPageIdentifier($object)) {
            Mage::throwException(Mage::helper('skylab_banner')->__('Group identifier contains capital letters or disallowed symbols.'));
        }

        if ($this->isNumericPageIdentifier($object)) {
            Mage::throwException(Mage::helper('skylab_banner')->__('Group identifier cannot consist only of numbers.'));
        }

        return parent::_beforeSave($object);
    }

    /**
     * Assign page to store views
     *
     * @param Mage_Core_Model_Abstract $object
     * @return \Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        $this->_saveGroupStores($object);
        $this->_saveGroupBanners($object);
        $this->_saveGroupProducts($object);
        $this->_saveGroupCategories($object);
        $this->_saveGroupPages($object);

        return parent::_afterSave($object);
    }

    /**
     * Save stores
     *
     * @param $object
     */
    protected function _saveGroupStores($object)
    {
        $oldStores = $this->lookupStoreIds($object->getId());
        $newStores = (array)$object->getStores();
        if (empty($newStores)) {
            $newStores = (array)$object->getStoreId();
        }
        $table  = $this->getTable('skylab_banner/group_store');
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);

        if ($delete) {
            $where = array(
                'group_id = ?'     => (int) $object->getId(),
                'store_id IN (?)' => $delete
            );

            $this->_getWriteAdapter()->delete($table, $where);
        }

        if ($insert) {
            $data = array();

            foreach ($insert as $storeId) {
                $data[] = array(
                    'group_id'  => (int) $object->getId(),
                    'store_id' => (int) $storeId
                );
            }

            $this->_getWriteAdapter()->insertMultiple($table, $data);
        }
    }

    /**
     * Save Group Banners
     *
     * @param $object Mage_Core_Model_Abstract
     * @return bool
     */
    public function _saveGroupBanners($object)
    {
        if(is_null($object->getBannersData())) {
            return false;
        }

        $data = $object->getBannersData();
        if (!is_array($data)) {
            $data = array();
        }

        $table = $this->getTable('skylab_banner/group_banner');
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('group_id=?', $object->getId());
        $this->_getWriteAdapter()->delete($table, $deleteCondition);

        foreach ($data as $bannerId => $position) {
            if (!empty($bannerId)) {
                $this->_getWriteAdapter()->insert($table, array(
                    'group_id' => $object->getId(),
                    'banner_id' => $bannerId,
                    'position' => $position['position']
                ));
            }
        }

        return true;
    }

    /**
     * Save Group Products
     *
     * @param $object Mage_Core_Model_Abstract
     * @return bool
     */
    public function _saveGroupProducts($object)
    {
        if(is_null($object->getProductsData())) {
            return false;
        }

        $data = $object->getProductsData();
        if (!is_array($data)) {
            $data = array();
        }

        $table = $this->getTable('skylab_banner/group_product');
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('group_id=?', $object->getId());
        $this->_getWriteAdapter()->delete($table, $deleteCondition);

        foreach ($data as $productId => $position) {
            if (!empty($productId)) {
                $this->_getWriteAdapter()->insert($table, array(
                    'group_id' => $object->getId(),
                    'product_id' => $productId,
                    'position' => $position['position']
                ));
            }
        }

        return true;
    }

    /**
     * Save Group Categories
     *
     * @param $object Mage_Core_Model_Abstract
     * @return bool
     */
    public function _saveGroupCategories($object)
    {
        if(is_null($object->getCategoriesData())) {
            return false;
        }

        $data = $object->getCategoriesData();
        if (!is_array($data)) {
            $data = array();
        }

        $table = $this->getTable('skylab_banner/group_category');
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('group_id=?', $object->getId());
        $this->_getWriteAdapter()->delete($table, $deleteCondition);

        foreach ($data as $categoryId) {
            if (!empty($categoryId)) {
                $this->_getWriteAdapter()->insert($table, array(
                    'group_id' => $object->getId(),
                    'category_id' => $categoryId,
                ));
            }
        }

        return true;
    }

    /**
     * Save Group Cms Pages
     *
     * @param $object Mage_Core_Model_Abstract
     * @return bool
     */
    public function _saveGroupPages($object)
    {
        if(is_null($object->getPagesData())) {
            return false;
        }

        $data = $object->getPagesData();
        if (!is_array($data)) {
            $data = array();
        }

        $table = $this->getTable('skylab_banner/group_cms');
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('group_id=?', $object->getId());
        $this->_getWriteAdapter()->delete($table, $deleteCondition);

        foreach ($data as $pageId => $position) {
            if (!empty($pageId)) {
                $this->_getWriteAdapter()->insert($table, array(
                    'group_id' => $object->getId(),
                    'page_id' => $pageId,
                    'position' => $position['position']
                ));
            }
        }

        return true;
    }

    /**
     * Perform operations after object load
     *
     * @param Mage_Core_Model_Abstract $object
     * @return \Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        if ($object->getId()) {
            $stores = $this->lookupStoreIds($object->getId());
            $object->setData('store_id', $stores);

            $banners = $this->getBannersCollection($object);
            $object->setData('banners', $banners);
        }

        return parent::_afterLoad($object);
    }

    /**
     * Retrieve select object for load object data
     *
     * @param string $field
     * @param mixed $value
     * @param Mage_Core_Model_Abstract $object
     * @return Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);

        if ($object->getStoreId()) {
            $storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, (int)$object->getStoreId());
            $select->join(
                array('group_store' => $this->getTable('skylab_banner/group_store')),
                $this->getMainTable() . '.id = group_store.group_id',
                array())
                ->where('is_active = ?', 1)
                ->where('group_store.store_id IN (?)', $storeIds)
                ->order('group_store.store_id DESC')
                ->limit(1);
        }

        return $select;
    }

    /**
     * Check if there is a primary banner group for selected page type
     *
     * @param $object
     * @return bool
     */
    protected function _pagePrimaryBannerGroupExists($object)
    {
        if(!$object->getIsPrimary()) {
            return false;
        }

        $collection = Mage::getModel('skylab_banner/group')
            ->getCollection()
            ->addFieldToFilter('id', array('neq' => $object->getId()))
            ->addFieldToFilter('page', array('eq' => $object->getPage()))
            ->addFieldToFilter('is_primary', array('eq' => 1));

        if($collection->getSize()) {
            return true;
        }

        return false;
    }

    /**
     *  Check whether group identifier is numeric
     *
     * @param Mage_Core_Model_Abstract $object
     * @return bool
     */
    protected function isNumericPageIdentifier(Mage_Core_Model_Abstract $object)
    {
        return preg_match('/^[0-9]+$/', $object->getData('identifier'));
    }

    /**
     *  Check whether group identifier is valid
     *
     *  @param    Mage_Core_Model_Abstract $object
     *  @return   bool
     */
    protected function isValidPageIdentifier(Mage_Core_Model_Abstract $object)
    {
        return preg_match('/^[a-z0-9][a-z0-9_\/-]+(\.[a-z0-9_-]+)?$/', $object->getData('identifier'));
    }



    /**
     * Check if group identifier exist for specific store
     * return group id if group exists
     *
     * @param string $identifier
     * @param int $storeId
     * @return int
     */
    public function checkIdentifier($identifier, $storeId)
    {
        $stores = array(Mage_Core_Model_App::ADMIN_STORE_ID, $storeId);
        $select = $this->_getLoadByIdentifierSelect($identifier, $stores, 1);
        $select->reset(Zend_Db_Select::COLUMNS)
            ->columns('group.id')
            ->order('group_store.store_id DESC')
            ->limit(1);

        return $this->_getReadAdapter()->fetchOne($select);
    }

    /**
     * Retrieve load select with filter by identifier, store and activity
     *
     * @param string $identifier
     * @param int|array $store
     * @param int $isActive
     * @return Varien_Db_Select
     */
    protected function _getLoadByIdentifierSelect($identifier, $store, $isActive = null)
    {
        $select = $this->_getReadAdapter()->select()
            ->from(array('group' => $this->getMainTable()))
            ->join(
                array('group_store' => $this->getTable('skylab_banner/group_store')),
                'group.id = group_store.group_id',
                array())
            ->where('group.identifier = ?', $identifier)
            ->where('group_store.store_id IN (?)', $store);

        if (!is_null($isActive)) {
            $select->where('group.is_active = ?', $isActive);
        }

        return $select;
    }

    /**
     * Check for unique of identifier of page to selected store(s).
     *
     * @param Mage_Core_Model_Abstract $object
     * @return bool
     */
    public function getIsUniquePageToStores(Mage_Core_Model_Abstract $object)
    {
        if (Mage::app()->isSingleStoreMode() || !$object->hasStores()) {
            $stores = array(Mage_Core_Model_App::ADMIN_STORE_ID);
        } else {
            $stores = (array)$object->getData('stores');
        }

        $select = $this->_getLoadByIdentifierSelect($object->getData('identifier'), $stores);

        if ($object->getId()) {
            $select->where('group_store.group_id <> ?', $object->getId());
        }

        if ($this->_getWriteAdapter()->fetchRow($select)) {
            return false;
        }

        return true;
    }

    /**
     * Get store ids to which specified item is assigned
     *
     * @param int $groupId
     * @return array
     */
    public function lookupStoreIds($groupId)
    {
        $adapter = $this->_getReadAdapter();

        $select  = $adapter->select()
            ->from($this->getTable('skylab_banner/group_store'), 'store_id')
            ->where('group_id = ?',(int)$groupId);

        return $adapter->fetchCol($select);
    }

    /**
     * Get banners to which specified item is assigned
     *
     * @param Mage_Core_Model_Abstract $group
     * @return $object
     */
    public function getBannersCollection($group)
    {
        $collection = Mage::getModel('skylab_banner/group_banner')->getBannersCollection($group);

        return $collection;
    }

    /**
     * Set store model
     *
     * @param Mage_Core_Model_Store $store
     * @return SkyLab_Banner_Model_Resource_Group
     */
    public function setStore($store)
    {
        $this->_store = $store;
        return $this;
    }

    /**
     * Retrieve store model
     *
     * @return Mage_Core_Model_Store
     */
    public function getStore()
    {
        return Mage::app()->getStore($this->_store);
    }

}
