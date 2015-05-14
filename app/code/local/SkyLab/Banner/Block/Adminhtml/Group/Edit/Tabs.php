<?php

/**
 * Class SkyLab_Banner_Block_Adminhtml_Group_Edit_Tabs
 */
class SkyLab_Banner_Block_Adminhtml_Group_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    /**
     * Set Tab Id and Title
     */
    public function __construct()
    {
        parent::__construct();

        $this->setId('banner_group_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('skylab_banner')->__('Banner Group Information'));
    }

    public function _beforeToHtml()
    {
        $model = Mage::registry('current_banner_group');

        $this->addTab('banners', array(
            'label' => Mage::helper('skylab_banner')->__('Banners'),
            'title' => Mage::helper('skylab_banner')->__('Banners'),
            'url'   => $this->getUrl('*/*/banners', array('_current' => true)),
            'class' => 'ajax',
        ));

        // Add specific tab if edit mode
        if ($model instanceof SkyLab_Banner_Model_Group) {
            if ($model->getPage() == "category") {
                $this->addTab('category', array(
                    'label' => Mage::helper('skylab_banner')->__('Categories'),
                    'title' => Mage::helper('skylab_banner')->__('Categories'),
                    'url'   => $this->getUrl('*/*/category', array('_current' => true)),
                    'class' => 'ajax',
                ));
            } else if ($model->getPage() == "product") {
                $this->addTab('product', array(
                    'label' => Mage::helper('skylab_banner')->__('Products'),
                    'title' => Mage::helper('skylab_banner')->__('Products'),
                    'url'   => $this->getUrl('*/*/product', array('_current' => true)),
                    'class' => 'ajax',
                ));
            } else if ($model->getPage() == "cms") {
                $this->addTab('cms', array(
                    'label' => Mage::helper('skylab_banner')->__('Pages'),
                    'title' => Mage::helper('skylab_banner')->__('Pages'),
                    'url'   => $this->getUrl('*/*/cms', array('_current' => true)),
                    'class' => 'ajax',
                ));
            }
        }

        parent::_beforeToHtml();
    }

}
