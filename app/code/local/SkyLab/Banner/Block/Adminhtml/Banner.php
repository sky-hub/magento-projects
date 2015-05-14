<?php

/**
 * Class SkyLab_Banner_Block_Adminhtml_Banner
 */
class SkyLab_Banner_Block_Adminhtml_Banner extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * Default options
     */
    public function __construct()
    {
        $this->_blockGroup = 'skylab_banner';
        $this->_controller = 'adminhtml_banner';
        $this->_headerText = Mage::helper('skylab_banner')->__('Banners');

        parent::__construct();
    }

}
