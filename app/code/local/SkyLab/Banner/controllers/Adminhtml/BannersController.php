<?php

/**
 * Class SkyLab_Banner_Adminhtml_BannersController
 */
class SkyLab_Banner_Adminhtml_BannersController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Retrieve adminhtml session model object
     *
     * @return Mage_Adminhtml_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('adminhtml/session');
    }

    /**
     * Retrieve base skylab_banner helper
     *
     * @return SkyLab_Banner_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('skylab_banner');
    }

    /**
     * Initialize action
     *
     * @return SkyLab_Banner_Adminhtml_BannersController
     */
    protected function _initAction()
    {
        $this->_title($this->__('CMS'))
            ->_title($this->__('Banners'))
            ->_title($this->__('Manage Banners'));

        $this->loadLayout()
            ->_setActiveMenu('cms')
            ->_addBreadcrumb($this->_getHelper()->__('CMS'), $this->_getHelper()->__('CMS'))
            ->_addBreadcrumb($this->_getHelper()->__('Banners'), $this->_getHelper()->__('Banners'))
            ->_addBreadcrumb(
                $this->_getHelper()->__('Manage Banners'), $this->_getHelper()->__('Manage Banners')
            );

        return $this;
    }

    /**
     * Initialize Banner
     *
     * @return SkyLab_Banner_Model_Banner
     */
    protected function _initBanner()
    {
        $id = Mage::app()->getRequest()->getParam('id');
        $model = Mage::getModel('skylab_banner/banner');
        if ($id) {
            $model->load($id);
        }

        Mage::register('current_banner', $model);

        return $model;
    }

    /**
     * Index Action
     */
    public function indexAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * New Action
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * Edit Action
     */
    public function editAction()
    {
        // get banner model
        $model = $this->_initBanner();

        // set model data
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('current_banner', $model, true);

        $this->_initAction();
        $this->_addBreadcrumb(
            $model->getId() ? $this->_getHelper()->__('Edit Banner') : $this->_getHelper()->__('New Banner'),
            $model->getId() ? $this->_getHelper()->__('Edit Banner') : $this->_getHelper()->__('New Banner')
        );
        $this->_title($model->getId() ? $model->getTitle() : $this->_getHelper()->__('New Banner'));
        $this->renderLayout();
    }

    /**
     * Save Action
     */
    public function saveAction()
    {
        $id = $this->getRequest()->getParam('id');
        if ($this->getRequest()->isPost()) {

            $data = $this->getRequest()->getParam('banner');
            $model = Mage::getModel('skylab_banner/banner');
            $helper = Mage::helper('skylab_banner');

            try {
                if ($id) {
                    $model->load($id);
                    $model->addData($data);
                } else {
                    $model->setData($data);
                    $model->setCreatedAt(Mage::getModel('core/date')->date('Y-m-d H:i:s'));
                }

                // check if image needs to be deleted
                if(isset($data['image']['delete']) && $data['image']['delete'] == 1) {
                    $helper->deleteImage($data['image']['value']);
                    $model->setImage('');
                }
                else {
                    $model->unsetData('image');
                }

                if (isset($_FILES['image']['name']) && $_FILES['image']['size'] > 0) {
                    if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                        try {
                            $file = $_FILES['image'];
                            $file['name'] = strtolower($data['title'] . '_' . $file['name']);
                            $upload = $helper->saveFile($file);
                            $model->setImage($upload['file']);
                        } catch (Exception $e) {
                            Mage::throwException($e->getMessage());
                        }
                    }
                } else {
                    // unset image when edit mode and new file is not selected (keep old file)
                    if ($id) {
                        $model->unsetData('image');
                    } else {
                        Mage::throwException(Mage::helper('skylab_banner')->__('File can not be empty.'));
                    }
                }

                $model->save();

                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('skylab_banner')->__('Error saving banner.'));
                }

                $this->_getSession()->addSuccess(Mage::helper('skylab_banner')->__('Banner was successfully saved.'));
                $this->_getSession()->setFormData(false);

                // The following line decides if it is a "save" or "save and continue"
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }

                $this->_redirect('*/*/');
                return;

            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()
                    ->addException($e, $this->_getHelper()->__('An error occurred while saving banner.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            return;
        }

        $this->_redirect('*/*/');
    }

    /**
     * Delete action
     */
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $model = Mage::getModel('skylab_banner/banner')->load($id);
            $model->delete();
        }
        $this->_getSession()->addSuccess('Banner deleted.');
        $this->_redirect('*/*/');
    }

    /**
     * Mass delete action
     */
    public function massDeleteAction()
    {
        $banners = $this->getRequest()->getParam('id');
        if (!is_array($banners)) {
            $this->_getSession()->addError(Mage::helper('skylab_banner')->__('Please select banner(s).'));
        } else {
            try {
                $model = Mage::getModel('skylab_banner/banner');
                foreach ($banners as $banner) {
                    $model->load($banner)->delete();
                }
                $this->_getSession()->addSuccess(
                    Mage::helper('skylab_banner')->__(
                        'Total of %d record(s) were deleted.', count($banners)
                    )
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }

    /**
     * Mass status action
     */
    public function massStatusAction()
    {
        $ids = $this->getRequest()->getParam('id');
        $status = $this->getRequest()->getParam('status') == 1 ? 1 : 0;
        if (!is_array($ids)) {
            $this->_getSession()->addError($this->__('Please select banner(s)'));
        } else {
            try {
                foreach ($ids as $id) {
                    Mage::getSingleton('skylab_banner/banner')
                        ->load($id)
                        ->setIsActive($status)
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($ids))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

}
