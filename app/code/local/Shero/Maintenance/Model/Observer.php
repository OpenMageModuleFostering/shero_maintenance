<?php
class Shero_Maintenance_Model_Observer extends Varien_Event_Observer
{
    public function switchStoreToMaintenance()
    {
        $myIp = $_SERVER['REMOTE_ADDR'];

        $maintenanceOff = MAGENTO_ROOT . '/maintenance.off';

        $isEnable = Mage::helper('shero_maintenance')->isEnabeled();
        $allowedIps = Mage::helper('shero_maintenance')->getAllowIpsArray();
        $redirectUrl = Mage::helper('shero_maintenance')->getRedirectUrl();
        $isSetupPageEnabled = Mage::helper('shero_maintenance')->setupPageEnabled();
        $redirectImage = Mage::helper('shero_maintenance')->getRedirectImage();
        $maintenanceMessage = Mage::helper('shero_maintenance')->maintenanceMessage();

        if ($isEnable === true && !in_array($myIp, $allowedIps) && !file_exists($maintenanceOff)) {

            if($isSetupPageEnabled === true && ($redirectImage!=false || $maintenanceMessage!=false)){
                echo '<div style="margin: auto; width: 800px;">
                       <div><img style="display: block; margin-left: auto; margin-right: auto" src='.$redirectImage.'></div>
                       <div style="font-size: 20px; display: block; margin-left: 165px; margin-right: auto;" >'.$maintenanceMessage.'</div>
                     </div>';
                exit;
            }
            else
            {
                if($redirectUrl != false )
                {
                    header("location: $redirectUrl");
                    exit;
                }
                else
                {
                    echo '<div style="margin: auto; width: 800px; padding-top: 20px;">
                       <div style="margin: auto; width: 800px; font-size: 15px" ><h3>Our website is down for required maintenance right now, but you should be able to get back on shortly.</h3></div>
                       <div style="font-size: 18px; display: block; margin-left: 165px; margin-right: auto;">Thanks for your patience as we improve the website.</div>
                     </div>';
                    exit;
                }
            }
        }
    }
}