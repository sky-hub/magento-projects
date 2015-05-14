<?php

/**
 * Class SkyLab_Banner_Block_Adminhtml_Group_Edit
 */
class SkyLab_Banner_Block_Adminhtml_Group_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    /**
     * Configure Tab
     */
    public function __construct()
    {
        $this->_objectId   = 'id';
        $this->_blockGroup = 'skylab_banner';
        $this->_controller = 'adminhtml_group';

        parent::__construct();

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('block_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'block_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'block_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * Get edit form container header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_banner_group')->getId()) {
            return Mage::helper('skylab_banner')->__("Edit Banner Group '%s'", $this->htmlEscape(Mage::registry('current_banner_group')->getTitle()));
        }
        else {
            return Mage::helper('skylab_banner')->__('Add New Banner Group');
        }
    }

}
