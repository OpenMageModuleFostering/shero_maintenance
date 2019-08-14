<?php
class Shero_Maintenance_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function isEnabeled ()
    {
        $enabel = Mage::getStoreConfig('shero/maintenance_settings/maintenance_enable');
        return $enabel == 1 ? true : false;
    }

    public function getAllowIpsArray()
    {
        $ipArray = array();
        $string = Mage::getStoreConfig('shero/maintenance_settings/allow_ips');
        if (isset($string)) {
            $ipArray = explode(',', $string);
        }
        return $ipArray;
    }

    public function getRedirectUrl()
    {
        $string = Mage::getStoreConfig('shero/maintenance_settings/redirect_to');
        if(!isset($string))
        {
            return false;
        }
        return $string;
    }

    public function setupPageEnabled()
    {
        $enabel = Mage::getStoreConfig('shero/maintenance_settings/setup_maintenance_enable');
        return $enabel == 1 ? true : false;
    }

    public function getRedirectImage()
    {
        $image = Mage::getStoreConfig('shero/maintenance_settings/redirect_image');
        $maxWidth = 750;
        $maxHeight = 750;
        if(!isset($image))
        {
            return false;
        }
        $basePath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . "maintenance" .DS . $image;
        $newPath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . "maintenance" . DS . "resized" . DS . $image;


        $imageObj = new Varien_Image($basePath);
        $imageObj->constrainOnly(TRUE);
        $imageObj->keepAspectRatio(FALSE);
        $imageObj->keepFrame(FALSE);
        $origwidth = $imageObj->getOriginalWidth();
        $origheight = $imageObj->getOriginalHeight();

        if($origwidth <= 400 && $origheight <= 400){
            return Mage::getBaseUrl('media') . "maintenance/" . $image;
        }
        else if (!file_exists($newPath) && ($origheight > 400 || $origwidth > 400)) {

            $scale = $origwidth/$origheight;
            if(($maxWidth/$maxHeight) > $scale){
                $maxWidth = $maxHeight * $scale;
            }else
            {
                $maxHeight = $maxWidth / $scale;
            }
            $imageObj->resize($maxWidth, $maxHeight);
            $imageObj->save($newPath);
            //unlink($basePath);
            return Mage::getBaseUrl('media') . "maintenance/resized/" . $image;
        }else{
            return Mage::getBaseUrl('media') . "maintenance/resized/" . $image;
        }
    }

    public function maintenanceMessage()
    {
        $string = Mage::getStoreConfig('shero/maintenance_settings/maintenance_message');
        if(!isset($string))
        {
            return false;
        }
        return $string;
    }
    
    
    //alert settings
    public function isAlertEnabled()
    {
        $enabled = Mage::getStoreConfig('shero/maintenance_alert/alert_enabled');
        return $enabled == 1 ? true : false;
    }

    public function getAlertMessage()
    {
        $string = Mage::getStoreConfig('shero/maintenance_alert/alert_message');
        if(!isset($string))
        {
            return false;
        }
        return $string;
    }

    public function getBackgroundColor()
    {
        $color = Mage::getStoreConfig('shero/maintenance_alert/alert_color');
        return $color;
    }

    public function getTextColor()
    {
        $color = Mage::getStoreConfig('shero/maintenance_alert/alert_text_color');
        return $color;
    }
    
}