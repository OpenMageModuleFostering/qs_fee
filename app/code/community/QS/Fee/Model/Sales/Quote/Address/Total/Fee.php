<?php
class QS_Fee_Model_Sales_Quote_Address_Total_Fee extends Mage_Sales_Model_Quote_Address_Total_Abstract{
	protected $_code = 'U-PIC';

	public function collect(Mage_Sales_Model_Quote_Address $address)
	{
		parent::collect($address);

		$this->_setAmount(0);
		$this->_setBaseAmount(0);

		$items = $this->_getAddressItems($address);
		if (!count($items)) {
			return $this;
		}

		$quote = $address->getQuote();

        $insurance_as_default = Mage::getStoreConfig('upic/general/insurance_as_default');
        if($insurance_as_default){
            $address->setInsuranceStatus(1);
        }
            if(QS_Fee_Model_Fee::canApply($address)){
                $exist_amount = $quote->getFeeAmount();

                $fee = QS_Fee_Model_Fee::getFee();
                $balance = $fee - $exist_amount;

                if ($address->getInsuranceStatus()){
                    $address->setFeeAmount($balance);
                    $address->setBaseFeeAmount($balance);

                    $quote->setFeeAmount($balance);

                    $address->setGrandTotal($address->getGrandTotal() + $address->getFeeAmount());
                    $address->setBaseGrandTotal($address->getBaseGrandTotal() + $address->getBaseFeeAmount());
                }
            }
	}

	public function fetch(Mage_Sales_Model_Quote_Address $address)
	{
		$amt = $address->getFeeAmount();
        if($amt != 0){
            $address->addTotal(array(
                'code'=>$this->getCode(),
                'title'=>Mage::helper('fee')->__('U-PIC Parcel Insurance'),
                'value'=> $amt
            ));
        }
		return $this;
	}
}