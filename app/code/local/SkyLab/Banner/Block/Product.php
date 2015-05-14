<?php

/**
 * Class SkyLab_Banner_Block_Product
 */
class SkyLab_Banner_Block_Product extends Mage_Catalog_Block_Product_Abstract
{

    /**
     * Get carousel products
     *
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
    public function getProducts()
    {
        /** @var $collection Mage_Catalog_Model_Resource_Product_Collection */
        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('type_id', array('eq' => Mage_Catalog_Model_Product_Type::TYPE_BUNDLE))
            ->addAttributeToFilter('status', array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED));

        $collection->getSelect()->orderRand('e.entity_id');

        return $collection;
    }

}
