<?php

/**
 * Class SkyLab_Banner_Block_Adminhtml_Group_Grid
 */
class SkyLab_Banner_Block_Adminhtml_Group_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('banner_group_grid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare Collection
     *
     * @return this|void
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('skylab_banner/group')->getCollection();
        $collection->setFirstStoreFlag(true);
        $this->setCollection($collection);

        parent::_prepareCollection();
    }

    /**
     * Prepare Columns
     *
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header' => Mage::helper('skylab_banner')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'id',
        ));

        $this->addColumn('title', array(
            'header' => Mage::helper('skylab_banner')->__('Title'),
            'align' => 'left',
            'index' => 'title',
        ));

        $this->addColumn('identifier', array(
            'header' => Mage::helper('skylab_banner')->__('Identifier'),
            'align' => 'left',
            'index' => 'identifier',
        ));

        $this->addColumn('page', array(
            'header' => Mage::helper('skylab_banner')->__('Page'),
            'align' => 'left',
            'index' => 'page',
            'type' => 'options',
            'options' => Mage::getModel('skylab_banner/source_page')->toOptionArray()
        ));

        /**
         * Check is single store mode
         */
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header' => Mage::helper('cms')->__('Store View'),
                'index' => 'store_id',
                'type' => 'store',
                'store_all' => true,
                'store_view' => true,
                'sortable' => false,
                'filter_condition_callback'
                => array($this, '_filterStoreCondition'),
            ));
        }

        $this->addColumn('delay', array(
            'header' => Mage::helper('skylab_banner')->__('Delay (seconds)'),
            'align' => 'right',
            'index' => 'delay',
            'width' => '100px',
        ));

        $this->addColumn('position', array(
            'header' => Mage::helper('skylab_banner')->__('Position'),
            'align' => 'left',
            'width' => '100px',
            'index' => 'position',
        ));

        $this->addColumn('is_active', array(
            'header' => Mage::helper('skylab_banner')->__('Status'),
            'align' => 'left',
            'index' => 'is_active',
            'type' => 'options',
            'options' => Mage::getModel('skylab_banner/source_status')->toOptionArray(),
            'width' => '100px',
        ));

        return parent::_prepareColumns();
    }

    /**
     * After load
     *
     * @return $this|void
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    /**
     * Mass Actions
     *
     * @return $this|Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id');
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('tax')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete', array('' => '')),
            'confirm' => Mage::helper('tax')->__('Are you sure?')
        ));

        $statuses = Mage::getModel('skylab_banner/source_status')->toOptionArray();
        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('skylab_banner')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('skylab_banner')->__('Status'),
                    'values' => $statuses
                )
            )
        ));

        return $this;
    }

    /**
     * Row click url
     *
     * @param $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * Add store filter
     *
     * @param $collection
     * @param $column
     */
    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $collection->addStoreFilter($value);
    }

}
