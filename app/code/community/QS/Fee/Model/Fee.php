<?php
class QS_Fee_Model_Fee extends Varien_Object{

	public static function getFee(){

        $activation_code = Mage::getStoreConfig('upic/general/activation_code');

        $tier = Mage::getModel('fee/tiers')->getCollection()->addFieldToFilter('code',$activation_code)->getData();

        $quote = Mage::getModel('checkout/session')->getQuote();

        if($tier){

            $country_id = $quote->getShippingAddress()->getCountryId();

            if (($country_id == 'US')||($country_id == 'CA')){
                $rate = $tier[0]['domestic_value'];
            } else {
                $rate = $tier[0]['international_value'];
            }

            $totalProductPrice = 0;

            $shippingAmount = $quote->getShippingAddress()->getShippingAmount();
            $discountAmount = $quote->getShippingAddress()->getDiscountAmount();
            $discountShippingAmount = $quote->getShippingAddress()->getShippingDiscountAmount();

            foreach ($quote->getAllItems() as $item) {
                $productPrice = $item->getPriceInclTax();
                $totalProductPrice = $totalProductPrice +  $productPrice * $item->getQty();
            }

            $totalPrice = $totalProductPrice + $discountAmount + $shippingAmount + $discountShippingAmount;
            if ($totalPrice < 100){
                $unitCount = 1;
            } else {
                $unitCount = ceil ($totalPrice / 100);
            }

            $insuranceAmount = $rate * $unitCount;

            return $insuranceAmount;
        } else {
            return 0;
        }
	}

	public static function canApply($address){
		//put here your business logic to check if fee should be applied or not
		
        $country_id = $address->getCountryId();

        $excluded_counntries = array('AF','DZ','AO','BY','BA','MM','BI','CG','HR','CU','BA','IR','IQ','JO','LR','LY','MD','NG','KP','PY','RU','RS','SL','SO','LK','SD','SY','TG','YE','ZW');
		
		$insurance_as_default = Mage::getStoreConfig('upic/general/insurance_as_default');
        
		if(in_array($country_id,$excluded_counntries)){
			if($insurance_as_default){
				return false;
			}
        } else {
			return true;    
        }
		
	}
}