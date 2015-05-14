<?php

/**
 * Class SkyLab_Banner_Block_Adminhtml_Banner_Edit_Tab_General
 */
class SkyLab_Banner_Block_Adminhtml_Banner_Edit_Tab_General
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    /**
     * Prepare Form
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        if (Mage::getSingleton('adminhtml/session')->getCurrentBanner()) {
            $data = Mage::getSingleton('adminhtml/session')->getCurrentBanner();
            Mage::getSingleton('adminhtml/session')->setCurrentBanner(null);
        } else if (Mage::registry('current_banner')) {
            $data = Mage::registry('current_banner')->getData();
        } else {
            $data = array();
        }

        // update form fields
        $data = $this->_updateFormFields($data);

        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('banner_');
        $form->setFieldNameSuffix('banner');

        $fieldset = $form->addFieldset('banner_form', array(
            'legend' => Mage::helper('skylab_banner')->__('General Information'),
            'class' => 'fieldset'
        ));

        $fieldset->addField('title', 'text', array(
            'name' => 'title',
            'label' => Mage::helper('skylab_banner')->__('Title'),
            'required' => true,
        ));

        $fieldset->addField('url', 'text', array(
            'name' => 'url',
            'label' => Mage::helper('skylab_banner')->__('Url'),
            'required' => true,
            'note' => Mage::helper('skylab_banner')->__('Example: http://www.example.com, http://example.com')
        ));

        $fieldset->addField('url_target', 'select', array(
            'label' => Mage::helper('skylab_banner')->__('Target'),
            'name' => 'url_target',
            'required' => true,
            'options' => array(
                '_blank' => Mage::helper('skylab_banner')->__('New Page'),
                '_self' => Mage::helper('skylab_banner')->__('Same Page'),
            ),
            'note' => Mage::helper('skylab_banner')->__('Action to perform on banner click.')
        ));

        $fieldset->addField('button', 'select', array(
            'name' => 'button',
            'label' => Mage::helper('skylab_banner')->__('Button'),
            'required' => true,
            'options' => Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
            'note' => Mage::helper('skylab_banner')->__('Use button to navigate to banner url.')
        ));

        $fieldset->addField('button_text', 'text', array(
            'name' => 'button_text',
            'label' => Mage::helper('skylab_banner')->__('Button Text'),
            'required' => false,
            'note' => Mage::helper('skylab_banner')->__('Text to assign to button.')
        ));

        $configSettings = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
            array(
                'add_widgets' => false,
                'add_variables' => false,
                'add_images' => false,
                'files_browser_window_url' => $this->getBaseUrl() . 'admin/cms_wysiwyg_images/index/',
            )
        );

        $fieldset->addField('content', 'editor', array(
            'name' => 'content',
            'label' => Mage::helper('skylab_banner')->__('Banner Content'),
            'style' => 'width: 500px; height: 200px;',
            'wysiwyg' => true,
            'required' => false,
            'config' => $configSettings
        ));

        $fieldset->addField('image', 'image', array(
            'label' => Mage::helper('skylab_banner')->__('Image'),
            'required' => true,
            'name' => 'image',
        ));

        $fieldset->addField('is_active', 'select', array(
            'name' => 'is_active',
            'label' => Mage::helper('skylab_banner')->__('Status'),
            'required' => true,
            'options' => Mage::getModel('skylab_banner/source_status')->toOptionArray(),
            'note' => Mage::helper('skylab_banner')->__('Set banner as enabled or disabled')
        ));

        $fieldset->addField('position', 'text', array(
            'name' => 'position',
            'label' => Mage::helper('skylab_banner')->__('Position'),
            'required' => false,
            'note' => Mage::helper('skylab_banner')->__('Banner position in banner group.')
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

    /**
     * Update form fields
     *
     * @param $data
     * @return array
     */
    protected function _updateFormFields($data)
    {
        $model = Mage::registry('current_banner');
        if($model instanceof SkyLab_Banner_Model_Banner && $model->getId()) {
            $data['image'] = Mage::helper('skylab_banner')->getDirectory() . DS . $model->getImage();
        }
        return $data;
    }

}
