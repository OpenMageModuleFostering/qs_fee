<?php
class QS_Fee_Block_Insurance extends Mage_Core_Block_Template{

    public function __construct(){
        $this->registerInsuranceConfigurationStatus();
        $this->registerInsuranceDefaultStatus();
        $this->registerStatusAllowedCountry();
        parent::__construct();
    }

    function registerInsuranceConfigurationStatus(){

        $activation_code = Mage::getStoreConfig('upic/general/activation_code');
        $policy_number = Mage::getStoreConfig('upic/general/policy_number');

        if (($activation_code !='')&&($policy_number !='')){
            Mage::register('insurance_configuration',1);
        } else {
            Mage::register('insurance_configuration',0);
        }
    }

    function registerInsuranceDefaultStatus(){
        $insurance_as_default = Mage::getStoreConfig('upic/general/insurance_as_default');
        Mage::register('insurance_as_default',$insurance_as_default);
    }

    function registerStatusAllowedCountry(){
	
        $quote = Mage::getModel('checkout/session')->getQuote();
		$adress = $quote->getShippingAddress();
        $country_id = $adress->getCountryId();

        $excluded_counntries = array('AF','DZ','AO','BY','BA','MM','BI','CG','HR','CU','BA','IR','IQ','JO','LR','LY','MD','NG','KP','PY','RU','RS','SL','SO','LK','SD','SY','TG','YE','ZW');
		
		$insurance_as_default = Mage::getStoreConfig('upic/general/insurance_as_default');
        
		if(in_array($country_id,$excluded_counntries)){
            Mage::register('country_status',0);
        } else {
            Mage::register('country_status',1);
        }
		
		
    }

}