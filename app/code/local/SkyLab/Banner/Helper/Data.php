<?php

/**
 * Class SkyLab_Banner_Helper_Data
 */
class SkyLab_Banner_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Default config path.
     */
    const CONFIG_PATH = 'SkyLab_Banner/';

    /**
     * Banners directory
     */
    const BANNER_DIRECTORY = 'skylab/banners';

    /**
     * Banner libraries
     */
    const BANNER_LIBRARY_FOUNDATION = 0;
    const BANNER_LIBRARY_JQUERY = 1;

    /**
     * Banner page types
     */
    const BANNER_TYPE_CMS = 'cms';
    const BANNER_TYPE_CATEGORY = 'category';
    const BANNER_TYPE_PRODUCT = 'product';
    const BANNER_TYPE_CATALOGSEARCH = 'catalogsearch';

    /**
     * CSS3 transitions
     */
    const CSS_TRANSITION_NONE = 0;
    const CSS_TRANSITION_FADE = 1;
    const CSS_TRANSITION_BACKSLIDE = 2;
    const CSS_TRANSITION_GODOWN = 3;
    const CSS_TRANSITION_FADEUP = 4;

    /**
     * Status
     */
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;

    /**
     * @var array CSS3 transitions
     */
    protected $_cssTransitions = array(
        1 => 'fade',
        2 => 'backSlide',
        3 => 'goDown',
        4 => 'fadeUp'
    );

    /**
     * Get module config.
     *
     * @param string $path
     * @param int $storeId
     * @return string
     */
    public function getConfig($path, $storeId = 0)
    {
        return Mage::getStoreConfig(self::CONFIG_PATH . $path, $storeId);
    }

    /**
     * Check if banners are enabled.
     *
     * @param $storeId
     * @return bool
     */
    public function isActive($storeId = 0)
    {
        return (int)$this->getConfig('settings/enabled', $storeId);
    }

    /**
     * Get used library
     *
     * @param int $storeId
     * @return int
     */
    public function getUsedLibrary($storeId = 0)
    {
        return (int)$this->getConfig('settings/library', $storeId);
    }

    /**
     * Load jQuery library
     *
     * @param int $storeId
     * @return int
     */
    public function loadJquery($storeId = 0)
    {
        return (int)$this->getConfig('settings/load_jquery', $storeId);
    }

    /**
     * Use Ltr display mode; for arabic websites
     *
     * @param int $storeId
     * @return int
     */
//    public function useLtr($storeId = 0)
//    {
//        return (int)$this->getConfig('settings/use_ltr', $storeId);
//    }

    /**
     * Get CSS3 transitions
     *
     * @param $transition
     * @return string
     */
    public function getCssTransition($transition)
    {
        return $this->_cssTransitions[$transition];
    }

    /**
     * Media subdirectory name
     *
     * @return string
     */
    public function getDirectory()
    {
        return self::BANNER_DIRECTORY;
    }

    /**
     * Base disk directory where files are stored
     *
     * @return string
     */
    public function getBaseDir()
    {
        return Mage::getBaseDir('media') . DS . $this->getDirectory();
    }

    /**
     * Base frontend url
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return Mage::getBaseUrl('media') . $this->getDirectory() . DS;
    }

    /**
     * Upload file and move it
     *
     * @param string $file
     * @return bool|void
     */
    public function saveFile($file)
    {
        $uploader = new Varien_File_Uploader($file);
        $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
        $uploader->addValidateCallback('validate_image', Mage::helper('catalog/image'), 'validateUploadFile');
        $uploader->setAllowRenameFiles(true);
        $uploader->setFilesDispersion(false);
        $result = $uploader->save($this->getBaseDir());

        return $result;
    }

    /**
     * Get image url
     *
     * @param string $filename
     * @return string
     */
    public function getImageUrl($filename)
    {
        return Mage::getBaseUrl('media') . DS . $this->getDirectory() . DS . $filename;
    }

    /**
     * Get image info
     *
     * @param type $fileName
     * @return \Varien_Image
     */
    public function getImageInfo($fileName)
    {
        $filePath = Mage::getBaseDir('media') . DS . $this->getDirectory() . DS . $fileName;
        if (file_exists($filePath)) {
            return new Varien_Image($filePath);
        }

        return false;
    }

    /**
     * Delete file
     *
     * @param $fileName
     */
    public function deleteImage($fileName)
    {
        $filePath = Mage::getBaseDir('media') . DS . $fileName;
        if(file_exists($filePath)) {
            unlink($filePath);
        }
    }

}
