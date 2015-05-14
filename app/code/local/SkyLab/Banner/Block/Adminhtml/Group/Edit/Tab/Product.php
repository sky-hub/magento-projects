<?php

/**
 * Class SkyLab_Banner_Block_Adminhtml_Group_Edit_Tab_Product
 */
class SkyLab_Banner_Block_Adminhtml_Group_Edit_Tab_Product extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * Set grid params
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('productGrid');
        $this->setUseAjax(true);
        $this->setDefaultSort('entity_id');
        $this->setDefaultFilter(array(
            'in_products' => 1,
            'status' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED
            )
        );
        $this->setSaveParametersInSession(false);
    }

    /**
     * Retrieve currently edited banner group
     *
     * @return SkyLab_Banner_Model_Group
     */
    protected function _getCurrentGroup()
    {
        return Mage::registry('current_banner_group');
    }

    /**
     * Prepare collection
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection->addAttributeToSelect('id');
        $collection->addAttributeToSelect('name');
        $collection->addAttributeToSelect('status');
        $collection->getSelect()->joinLeft(
            array('group_product' => Mage::getSingleton('core/resource')->getTableName('skylab_banner/group_product')),
            "group_product.product_id = e.entity_id AND group_id = '" . $this->_getCurrentGroup()->getId() . "'",
            array('position')
        );

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Add filter
     *
     * @param object $column
     * @return SkyLab_Banner_Block_Adminhtml_Group_Edit_Tab_Product
     */
    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in products flag
        if ($column->getId() == 'in_products') {
            $ids = $this->_getSelectedProducts();
            if (empty($ids)) {
                $ids = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$ids));
            } else {
                if($ids) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$ids));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * Prepare columns
     *
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn('in_products', array(
            'header_css_class'  => 'a-center',
            'type'              => 'checkbox',
            'name'              => 'in_products',
            'values'            => $this->_getSelectedProducts(),
            'align'             => 'center',
            'index'             => 'entity_id'
        ));
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('skylab_banner')->__('ID'),
            'sortable'  => true,
            'width'     => 60,
            'index'     => 'entity_id'
        ));
        $this->addColumn('sku', array(
            'header'    => Mage::helper('skylab_banner')->__('SKU'),
            'width'     => 80,
            'index'     => 'sku'
        ));
        $this->addColumn('name', array(
            'header'    => Mage::helper('skylab_banner')->__('Name'),
            'index'     => 'name'
        ));
        $this->addColumn('type', array(
            'header'    => Mage::helper('skylab_banner')->__('Type'),
            'width'     => 100,
            'index'     => 'type_id',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        ));
        $this->addColumn('status', array(
            'header'    => Mage::helper('skylab_banner')->__('Status'),
            'align'     => 'center',
            'width'     => 90,
            'index'     => 'status',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_status')->getOptionArray(),
        ));
        $this->addColumn('position', array(
            'header'            => Mage::helper('skylab_banner')->__('Position'),
            'name'              => 'position',
            'width'             => 60,
            'type'              => 'number',
            'validate_class'    => 'validate-number',
            'index'             => 'position',
            'editable'          => true,
            'edit_only'         => true
        ));

        return parent::_prepareColumns();
    }

    /**
     * Get Grid Url
     *
     * @return mixed|string
     */
    public function getGridUrl()
    {
        return $this->_getData('grid_url')
            ? $this->_getData('grid_url')
            : $this->getUrl('*/*/productgrid', array('_current'=>true));
    }

    /**
     * Get Selected Banners
     *
     * @return array
     */
    protected function _getSelectedProducts()
    {
        $products = $this->getGroupProducts();
        if (!is_array($products)) {
            $products = array_keys($this->getSelectedProducts());
        }

        return $products;
    }

    /**
     * Get Selected Banners
     *
     * @return array
     */
    public function getSelectedProducts()
    {
        $products = array();
        foreach ($this->_getCurrentGroup()->getSelectedProducts() as $product) {
            $products[$product->getProductId()] = array('position' => $product->getPosition());
        }

        return $products;
    }

}
