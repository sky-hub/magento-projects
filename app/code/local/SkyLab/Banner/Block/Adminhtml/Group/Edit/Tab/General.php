<?php

class SkyLab_Banner_Block_Adminhtml_Group_Edit_Tab_General
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Prepare form
     *
     * @return \Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $_helper = Mage::helper('skylab_banner');

        if (Mage::getSingleton('adminhtml/session')->getCurrentBannerGroup()) {
            $data = Mage::getSingleton('adminhtml/session')->getCurrentBannerGroup();
            Mage::getSingleton('adminhtml/session')->setCurrentBannerGroup(null);
        } else if (Mage::registry('current_banner_group')) {
            $data = Mage::registry('current_banner_group')->getData();
        } else {
            $data = array();
        }

        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('banner_group_');
        $form->setFieldNameSuffix('banner_group');

        $fieldset = $form->addFieldset('banner_group_form', array(
            'legend' => Mage::helper('skylab_banner')->__('General Information'),
            'class' => 'fieldset'
        ));

        $fieldset->addField('title', 'text', array(
            'name' => 'title',
            'label' => Mage::helper('skylab_banner')->__('Title'),
            'required' => true,
        ));

        $fieldset->addField('identifier', 'text', array(
            'name' => 'identifier',
            'label' => Mage::helper('skylab_banner')->__('Identifier'),
            'required' => true,
        ));

        $fieldset->addField('page', 'select', array(
            'name' => 'page',
            'label' => Mage::helper('skylab_banner')->__('Show In'),
            'required' => true,
            'options' => Mage::getModel('skylab_banner/source_page')->toOptionArray(),
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'multiselect', array(
                'name'     => 'stores[]',
                'label'    => Mage::helper('poll')->__('Visible In'),
                'required' => true,
                'values'   => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            ));
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name' => 'stores[]',
                'value' => Mage::app()->getStore(true)->getId()
            ));
            $data['store_id'] = Mage::app()->getStore(true)->getId();
        }

        $fieldset->addField('delay', 'text', array(
            'name' => 'delay',
            'label' => Mage::helper('skylab_banner')->__('Delay'),
            'required' => true,
            'note' => Mage::helper('skylab_banner')->__('in seconds')
        ));

        $fieldset->addField('css_transition', 'select', array(
            'name' => 'css_transition',
            'label' => Mage::helper('skylab_banner')->__('CSS3 Transition'),
            'required' => true,
            'options' => Mage::getModel('skylab_banner/source_transition')->toOptionArray(),
            'note' => Mage::helper('skylab_banner')->__('Use CSS3 transition to switch between banners. Works only in modern browsers that support CSS3 translate3d methods')
        ));

        $fieldset->addField('show_pagination', 'select', array(
            'name' => 'show_pagination',
            'label' => Mage::helper('skylab_banner')->__('Show Pagination'),
            'required' => true,
            'options' => Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
            'note' => Mage::helper('skylab_banner')->__('Show pagination bullets')
        ));

        if($_helper->getUsedLibrary() == SkyLab_Banner_Helper_Data::BANNER_LIBRARY_JQUERY) {
            $fieldset->addField('lazy_load', 'select', array(
                'name' => 'lazy_load',
                'label' => Mage::helper('skylab_banner')->__('Lazy Load'),
                'required' => true,
                'options' => Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
                'note' => Mage::helper('skylab_banner')->__('Delays loading of images')
            ));
        }

        $fieldset->addField('prev_next', 'select', array(
            'name' => 'prev_next',
            'label' => Mage::helper('skylab_banner')->__('Show Prev/Next'),
            'required' => true,
            'options' => Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
            'note' => Mage::helper('skylab_banner')->__('Show Prev/Next buttons')
        ));

        $fieldset->addField('is_primary', 'select', array(
            'name' => 'is_primary',
            'label' => Mage::helper('skylab_banner')->__('Is Primary'),
            'required' => true,
            'options' => Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
            'note' => Mage::helper('skylab_banner')->__('Banner Group will be inserted automatically in page content.')
        ));

        $fieldset->addField('is_active', 'select', array(
            'name' => 'is_active',
            'label' => Mage::helper('skylab_banner')->__('Status'),
            'required' => true,
            'options' => Mage::getModel('skylab_banner/source_status')->toOptionArray(),
            'note' => Mage::helper('skylab_banner')->__('Set as enabled or disabled')
        ));

        $this->setForm($form);
        $form->setValues($data);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('skylab_banner')->__('General');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('skylab_banner')->__('General');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }

}
