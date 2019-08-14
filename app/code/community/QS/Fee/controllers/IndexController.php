<?php
/** controller for test action */

class QS_Fee_IndexController extends Mage_Core_Controller_Front_Action
{

    public function updateAmountAction(){
        if (array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) && $_SERVER['HTTP_X_REQUESTED_WITH']==='XMLHttpRequest') {
            $response = array();

            $data = $this->getRequest()->getPost('shipping_method', '');

            try {
                $quote = Mage::getModel('checkout/session')->getQuote();
                $adress = $quote->getShippingAddress();

                $rate = $adress->getShippingRateByCode($data)->getData();

                if (!$rate) {
                    return array('error' => -1, 'message' => Mage::helper('checkout')->__('Invalid shipping method.'));
                }

                $adress->setShippingAmount($rate['price']);

                $adress->save();

                $insurance = Mage::helper('core')->currency(QS_Fee_Model_Fee::getFee(), true, false);
                $response['success'] = true;
                $response['html'] = array('content' => $insurance);

            }catch (Exception $e) {
                $response['success'] = false;
                $response['message'] = 'Invalid request';
            }

            $result = $this->getResponse()->setBody(Zend_Json::encode($response));
            return $result;
        }
    }

    public function updateStatusAction(){
        if (array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) && $_SERVER['HTTP_X_REQUESTED_WITH']==='XMLHttpRequest') {
            $response = array();
            $status = $this->getRequest()->getPost('status');
            try {
                $quote = Mage::getModel('checkout/session')->getQuote();

                $adress = $quote->getShippingAddress();

                if($status=='true'){
                    $adress->setInsuranceStatus(1);
                } else {
                    $adress->setInsuranceStatus(0);
                }

                $adress->save();

                $response['success'] = true;
            }catch (Exception $e) {
                $response['success'] = false;
                $response['message'] = 'Invalid request';
            }

            $result = $this->getResponse()->setBody(Zend_Json::encode($response));
            return $result;
        }
    }

}