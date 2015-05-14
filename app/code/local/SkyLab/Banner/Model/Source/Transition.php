<?php

/**
 * Class SkyLab_Banner_Model_Source_Page
 */
class SkyLab_Banner_Model_Source_Transition
{

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toOptionArray()
    {
        $_helper = Mage::helper('skylab_banner');
        $transitions =  array(
            SkyLab_Banner_Helper_Data::CSS_TRANSITION_NONE => $_helper->__('none'),
            SkyLab_Banner_Helper_Data::CSS_TRANSITION_FADE => $_helper->__('fade'),
        );

        // if jQuery
        if($_helper->getUsedLibrary() == SkyLab_Banner_Helper_Data::BANNER_LIBRARY_JQUERY) {
            $transitions += array(
                SkyLab_Banner_Helper_Data::CSS_TRANSITION_BACKSLIDE => $_helper->__('backSlide'),
                SkyLab_Banner_Helper_Data::CSS_TRANSITION_GODOWN => $_helper->__('goDown'),
                SkyLab_Banner_Helper_Data::CSS_TRANSITION_FADEUP => $_helper->__('fadeUp')
            );
        }

        return $transitions;
    }

}
