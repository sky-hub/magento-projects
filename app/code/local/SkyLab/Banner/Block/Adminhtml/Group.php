<?php

/**
 * Class SkyLab_Banner_Block_Adminhtml_Group
 */
class SkyLab_Banner_Block_Adminhtml_Group extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * Default options
     */
    public function __construct()
    {
        $this->_blockGroup = 'skylab_banner';
        $this->_controller = 'adminhtml_group';
        $this->_headerText = Mage::helper('skylab_banner')->__('Manage Banner Groups');

        parent::__construct();
    }

}
