<?php

class QS_Fee_Block_Adminhtml_Totals extends Mage_Adminhtml_Block_Template{

    function getCollection(){

        $fromDate = date('Y-m-d 00:00:00',strtotime('-1 days'));
        $toDate = date('Y-m-d 23:59:00',strtotime(now()));

        $collection = Mage::getResourceModel('sales/order_collection')
            ->addAttributeToFilter('status', array('eq' => Mage_Sales_Model_Order::STATE_COMPLETE))
            ->addAttributeToFilter('fee_amount', array('neq' => 0))
            ->addAttributeToFilter('created_at', array('from'=>$fromDate, 'to'=>$toDate))
            ->addExpressionFieldToSelect(
                'fullname',
                'CONCAT({{customer_firstname}}, \' \', {{customer_lastname}})',
                array('customer_firstname' => 'main_table.customer_firstname', 'customer_lastname' => 'main_table.customer_lastname'))
            ->addExpressionFieldToSelect(
                'products',
                '(SELECT GROUP_CONCAT(\' \', x.name)
                    FROM sales_flat_order_item x
                    WHERE {{entity_id}} = x.order_id
                        AND x.product_type != \'configurable\')',
                array('entity_id' => 'main_table.entity_id')
            );
        return $collection;
    }

    function getOrdersCount(){
        $collection = $this->getCollection();
        return $collection->count();
    }

    function getTotalInsurance(){
        $collection = $this->getCollection();
        $totalAmount = 0;
        foreach ($collection as $order){
            $totalAmount += $order->getFeeAmount();
        }
        return $totalAmount;
    }

}

