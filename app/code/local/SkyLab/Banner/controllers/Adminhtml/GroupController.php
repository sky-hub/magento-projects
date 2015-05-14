<?php

/**
 * Class SkyLab_Banner_Adminhtml_GroupController
 */
class SkyLab_Banner_Adminhtml_GroupController extends Mage_Adminhtml_Controller_Action
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
     * @return SkyLab_Banner_Adminhtml_GroupController
     */
    protected function _initAction()
    {
        $this->_title($this->__('CMS'))
            ->_title($this->__('Banners'))
            ->_title($this->__('Manage Banner Groups'));

        $this->loadLayout()
            ->_setActiveMenu('cms')
            ->_addBreadcrumb($this->_getHelper()->__('CMS'), $this->_getHelper()->__('CMS'))
            ->_addBreadcrumb($this->_getHelper()->__('Banners'), $this->_getHelper()->__('Banners'))
            ->_addBreadcrumb(
                $this->_getHelper()->__('Manage Banner Groups'), $this->_getHelper()->__('Manage Banner Groups')
            );

        return $this;
    }

    /**
     * Initialize Group
     *
     * @return SkyLab_Banner_Model_Group
     */
    protected function _initBannerGroup()
    {
        $id = Mage::app()->getRequest()->getParam('id');
        $model = Mage::getModel('skylab_banner/group');
        if ($id) {
            $model->load($id);
        }

        Mage::register('current_banner_group', $model);

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
        // get banner group model
        $model = $this->_initBannerGroup();

        // set model data
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('current_banner_group', $model, true);

        $this->_initAction();
        $this->_addBreadcrumb(
            $model->getId() ? $this->_getHelper()->__('Edit Banner Group') : $this->_getHelper()->__('New Banner Group'),
            $model->getId() ? $this->_getHelper()->__('Edit Banner Group') : $this->_getHelper()->__('New Banner Group')
        );
        $this->_title($model->getId() ? $model->getTitle() : $this->_getHelper()->__('New Banner Group'));
        $this->renderLayout();
    }

    /**
     * Save Action
     */
    public function saveAction()
    {
        $id = $this->getRequest()->getParam('id');
        if ($this->getRequest()->isPost()) {

            $data = $this->getRequest()->getParam('banner_group');
            $model = Mage::getModel('skylab_banner/group');

            try {
                if ($id) {
                    $model->load($id);
                    $model->addData($data);
                } else {
                    $model->setData($data);
                    $model->setCreatedAt(Mage::getModel('core/date')->date('Y-m-d H:i:s'));
                }

                // assign banners
                $banners = $this->getRequest()->getPost('banners', -1);
                if ($banners != -1) {
                    $model->setBannersData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($banners));
                }

                // assign products
                $products = $this->getRequest()->getPost('products', -1);
                if ($products != -1) {
                    $model->setProductsData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($products));
                }

                // assign pages
                $pages = $this->getRequest()->getPost('pages', -1);
                if ($pages != -1) {
                    $model->setPagesData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($pages));
                }

                // assign categories
                $categories = $this->getRequest()->getPost('category_ids', -1);
                if ($categories != -1) {
                    $categories = explode(',', $categories);
                    $categories = array_unique($categories);
                    $model->setCategoriesData($categories);
                }

                $model->save();

                if (!$model->getId()) {
                    Mage::throwException($this->_getHelper()->__('Error saving banner group.'));
                }

                $this->_getSession()->addSuccess($this->_getHelper()->__('Banner group was successfully saved.'));
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
                    ->addException($e, $this->_getHelper()->__('An error occurred while saving banner group.'));
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
            $model = Mage::getModel('skylab_banner/group')->load($id);
            $model->delete();
        }
        $this->_getSession()->addSuccess('Banner group deleted.');
        $this->_redirect('*/*/');
    }

    /**
     * Mass delete action
     */
    public function massDeleteAction()
    {
        $banners = $this->getRequest()->getParam('id');
        if (!is_array($banners)) {
            $this->_getSession()->addError($this->_getHelper()->__('Please select banner group(s).'));
        } else {
            try {
                $model = Mage::getModel('skylab_banner/group');
                foreach ($banners as $banner) {
                    $model->load($banner)->delete();
                }
                $this->_getSession()->addSuccess(
                    $this->_getHelper()->__(
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
            $this->_getSession()->addError($this->__('Please select banner group(s).'));
        } else {
            try {
                foreach ($ids as $id) {
                    Mage::getSingleton('skylab_banner/group')
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

    /**
     *  Banners
     */
    public function bannersAction()
    {
        $this->_initBannerGroup();
        $this->loadLayout();
        $this->getLayout()->getBlock('banner_group_edit_tab_banners')
            ->setGroupBanners($this->getRequest()->getPost('group_banners', null));
        $this->renderLayout();
    }

    /**
     *  Banners Grid
     */
    public function bannersgridAction()
    {
        $banners = $this->getRequest()->getPost('group_banners', array(0));

        $this->_initBannerGroup();
        $this->loadLayout();
        $this->getLayout()->getBlock('banner_group_edit_tab_banners')
            ->setGroupBanners($banners);
        $this->renderLayout();
    }

    /**
     *  Categories
     */
    public function categoryAction()
    {
        $this->_initBannerGroup();
        $this->loadLayout();
        $this->renderLayout();
    }

    public function categoriesJsonAction()
    {
        $this->_initBannerGroup();
        $this->getResponse()
            ->setBody(
                $this->getLayout()
                    ->createBlock('skylab_banner/adminhtml_group_edit_tab_category')
                    ->getCategoryChildrenJson($this->getRequest()->getParam('category'))
            );
    }

    /**
     *  Products
     */
    public function productAction()
    {
        $this->_initBannerGroup();
        $this->loadLayout();
        $this->getLayout()->getBlock('banner_group_edit_tab_product')
            ->setGroupProducts($this->getRequest()->getPost('group_products', null));
        $this->renderLayout();
    }

    /**
     *  Products Grid
     */
    public function productgridAction()
    {
        $products = $this->getRequest()->getPost('group_products', array(0));

        $this->_initBannerGroup();
        $this->loadLayout();
        $this->getLayout()->getBlock('banner_group_edit_tab_product')
            ->setGroupProducts($products);
        $this->renderLayout();
    }

    /**
     *  Cms Pages
     */
    public function cmsAction()
    {
        $this->_initBannerGroup();
        $this->loadLayout();
        $this->getLayout()->getBlock('banner_group_edit_tab_cms')
            ->setGroupPages($this->getRequest()->getPost('group_pages', null));
        $this->renderLayout();
    }

    /**
     *  Cms Pages Grid
     */
    public function cmsgridAction()
    {
        $pages = $this->getRequest()->getPost('group_pages', array(0));

        $this->_initBannerGroup();
        $this->loadLayout();
        $this->getLayout()->getBlock('banner_group_edit_tab_cms')
            ->setGroupPages($pages);
        $this->renderLayout();
    }

}
