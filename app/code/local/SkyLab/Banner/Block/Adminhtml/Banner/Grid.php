<?php

/**
 * Class SkyLab_Banner_Block_Adminhtml_Banner_Grid
 */
class SkyLab_Banner_Block_Adminhtml_Banner_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('banner_grid');
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
        $collection = Mage::getModel('skylab_banner/banner')->getCollection();
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
        $this->addColumn('image', array(
            'header' => Mage::helper('skylab_banner')->__('Image'),
            'align' => 'left',
            'index' => 'image',
        ));
        $this->addColumn('title', array(
            'header' => Mage::helper('skylab_banner')->__('Title'),
            'align' => 'left',
            'index' => 'title',
        ));
        $this->addColumn('content', array(
            'header' => Mage::helper('skylab_banner')->__('Content'),
            'align' => 'left',
            'index' => 'content',
        ));
        $this->addColumn('position', array(
            'header' => Mage::helper('skylab_banner')->__('Position'),
            'align' => 'left',
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
     * Mass Actions
     *
     * @return $this|Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id');
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('skylab_banner')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete', array('' => '')),
            'confirm' => Mage::helper('tax')->__('Are you sure?')
        ));

        $statuses = Mage::getModel('skylab_banner/source_status')->toOptionArray();
        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
            'label'=> Mage::helper('skylab_banner')->__('Change status'),
            'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
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

}