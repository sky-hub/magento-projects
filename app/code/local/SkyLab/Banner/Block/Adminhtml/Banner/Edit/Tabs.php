<?php

/**
 * Class SkyLab_Banner_Block_Adminhtml_Banner_Edit_Tabs
 */
class SkyLab_Banner_Block_Adminhtml_Banner_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    /**
     * Set Tab Id and Title
     */
    public function __construct()
    {
        parent::__construct();

        $this->setId('banner_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('skylab_banner')->__('Banner Information'));
    }

}
