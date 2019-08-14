<?php
class QS_Fee_Model_Validation_Code extends Mage_Core_Model_Config_Data{
    public function save()
    {
        $activation_code = $this->getValue(); //get the value from our config
        $tier = Mage::getModel('fee/tiers')->getCollection()->addFieldToFilter('code',$activation_code)->getData();
        if($tier||($activation_code ==''))  {
            return parent::save();
        } else {
            Mage::throwException("Activation Code failed!");
        }
    }
}
