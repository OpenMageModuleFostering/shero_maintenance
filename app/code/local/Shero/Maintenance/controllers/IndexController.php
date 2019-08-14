<?php
class Shero_Maintenance_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $alertEnabled = Mage::helper('shero_maintenance')->isAlertEnabled();
        $alertMessage = Mage::helper('shero_maintenance')->getAlertMessage();
        $alertBackgroundColor = Mage::helper('shero_maintenance')->getBackgroundColor();
        $alertTextColor = Mage::helper('shero_maintenance')->getTextColor();

        $send = $alertMessage.",".$alertBackgroundColor.",".$alertTextColor;

        if($alertEnabled == true && $alertMessage != false){
          $this->getResponse()->setBody($send);
        }
        else{
            echo "inactive";
        }
    }
}