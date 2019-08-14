<?php
class QS_Fee_Model_Observer{

    public function getOrdersData()
    {

        $fromDate = date('Y-m-d 00:00:00',strtotime('-1 days'));
        $toDate = date('Y-m-d 23:59:00',strtotime(now()));

        $orders = Mage::getModel('sales/order')->getCollection()
            ->addAttributeToFilter('created_at', array('from'=>$fromDate, 'to'=>$toDate))
            ->addAttributeToFilter('status', array('eq' => Mage_Sales_Model_Order::STATE_COMPLETE))
            ->addAttributeToFilter('fee_amount', array('neq' => 0));

        $result = array();

        $array_title = array('Policy','Code','ShipDate','InvoiceNumber','DeclaredValue','ConsigneeName','ConsigneeAddress','ConsigneeZip');

        array_push($result,$array_title);

        foreach($orders as $order) {
            $orderArray = array();

            $policy_number = Mage::getStoreConfig('upic/general/policy_number');
            $orderArray['Policy number'] = $policy_number;

            $activation_code = Mage::getStoreConfig('upic/general/activation_code');
            $orderArray['Activation code'] = $activation_code;

            $shipmentCollection = $order->getShipmentsCollection();

            foreach($shipmentCollection as $shipment){
                $orderArray['ShipDate'] = $shipment->getCreatedAt();
            }

            $invoiceCollection = $order->getInvoiceCollection();

            foreach ($invoiceCollection as $inv) {
                $orderArray['InvoiceNumber'] = $inv->getData('increment_id');
                $orderArray['DeclaredValue'] = $inv->getData('grand_total');
            }

            $shippingId = $order->getShippingAddress()->getId();

            $address = Mage::getModel('sales/order_address')->load($shippingId);
            $orderArray['ConsigneeName']= $address->getData('firstname').' '.$address->getData('lastname');
            $orderArray['ConsigneeAddress']=$address->getData('region').' '.$address->getData('city').' '.$address->getData('street').' '.$address->getData('country_id');
            $orderArray['ConsigneeZip']= $address->getData('postcode');
            array_push($result,$orderArray);
        }
        return $result;
    }

    public function createReportFile($orderData){
        $result = array();
        $rand  = rand();
        $file_name = $rand.'report.csv';
        $result['fileName'] = $file_name;
        $file_path = implode (DS, array (Mage::getBaseDir('media'),$file_name));
        $result['filePath'] = $file_path;
        $mage_csv = new Varien_File_Csv();
        if ($mage_csv->saveData($file_path, $orderData)){
            Mage::helper('fee')->_getNotifier()->addNotice('U-PIC Insurance','Daily ordered insurance" File was generated successfully');
            return $result;
        }
    }


    public function load(){

        $ftp_server = Mage::getStoreConfig('upic/general/ftp_server');
        $ftp_user_name = Mage::getStoreConfig('upic/general/ftp_user_name');
        $ftp_user_pass =  Mage::getStoreConfig('upic/general/ftp_user_pass');

        $activation_code = Mage::getStoreConfig('upic/general/activation_code');
        $policy_number = Mage::getStoreConfig('upic/general/policy_number');

        if (($activation_code !='')&&($policy_number !='')){

            $orderData = $this->getOrdersData();
            $file_info = $this->createReportFile($orderData);
            $file_name = $file_info['fileName'];
            $file_path = $file_info['filePath'];

            // set up basic connection
            $conn_id = ftp_connect($ftp_server);

            // login with username and password
            $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
            if (!$login_result){
                Mage::log("There was a problem with login on ftp server");
            } else {
                // upload a file
                if (ftp_put($conn_id, $file_name, $file_path, FTP_ASCII)) {
                    Mage::helper('fee')->_getNotifier()->addNotice('U-PIC Insurance','Daily ordered insurance" File uploaded succesfully');
                } else {
                    Mage::log("There was a problem while uploading $file_path\n");
                }
                // close the connection
                ftp_close($conn_id);
            }
        }
    }

	public function invoiceSaveAfter(Varien_Event_Observer $observer)
	{
            $invoice = $observer->getEvent()->getInvoice();
            if ($invoice->getBaseFeeAmount()) {
                $order = $invoice->getOrder();
                $order->setFeeAmountInvoiced($order->getFeeAmountInvoiced() + $invoice->getFeeAmount());
                $order->setBaseFeeAmountInvoiced($order->getBaseFeeAmountInvoiced() + $invoice->getBaseFeeAmount());
            }
            return $this;
	}
	public function creditmemoSaveAfter(Varien_Event_Observer $observer)
	{
		/* @var $creditmemo Mage_Sales_Model_Order_Creditmemo */
            $creditmemo = $observer->getEvent()->getCreditmemo();
            if ($creditmemo->getFeeAmount()) {
                $order = $creditmemo->getOrder();
                $order->setFeeAmountRefunded($order->getFeeAmountRefunded() + $creditmemo->getFeeAmount());
                $order->setBaseFeeAmountRefunded($order->getBaseFeeAmountRefunded() + $creditmemo->getBaseFeeAmount());
            }
            return $this;
	}
	public function updatePaypalTotal($evt){
            $cart = $evt->getPaypalCart();
            $cart->updateTotal(Mage_Paypal_Model_Cart::TOTAL_SUBTOTAL,$cart->getSalesEntity()->getFeeAmount());
	}
}