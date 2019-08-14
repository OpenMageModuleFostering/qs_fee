<?php

class QS_Fee_Block_Adminhtml_Report_Simple_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    protected $_countTotals = true;

    public function __construct()
    {
        parent::__construct();
        $this->setId('inshurance_orders_grid');
        //$this->setDefaultSort('increment_id');
       // $this->setDefaultDir('DESC');
       // $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    public function getTotals()
    {
        $totals = new Varien_Object();
        $fields = array(
            'fee_amount' => 0, //actual column index, see _prepareColumns()
            'grand_total' => 0,
        );
        foreach ($this->getCollection() as $item) {
            foreach($fields as $field=>$value){
                $fields[$field]+=$item->getData($field);
            }
        }
        //First column in the grid
        $fields['increment_id']='Totals';
        $totals->setData($fields);
        return $totals;
    }

    protected function _prepareCollection()
    {
        $collection = Mage::registry('orders');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $collection = Mage::getResourceModel('sales/order_collection')
            ->addAttributeToFilter('status', array('eq' => Mage_Sales_Model_Order::STATE_COMPLETE))
            ->addAttributeToFilter('fee_amount', array('neq' => 0))
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
        Mage::register('orders',$collection);

        $helper = Mage::helper('fee');
        $currency = (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE);

        $this->addColumn('increment_id', array(
            'header' => $helper->__('Order #'),
            'index'  => 'increment_id',
            'filter_index' => 'increment_id',
        ));
        $this->addColumn('purchased_on', array(
            'header' => $helper->__('Purchased On'),
            'type'   => 'datetime',
            'index'  => 'created_at'
        ));
        $this->addColumn('fullname', array(
            'header'       => $helper->__('Customer Name'),
            'index'        => 'fullname',
            'filter_index' => 'CONCAT(customer_firstname, \' \', customer_lastname)'
        ));
        $this->addColumn('products', array(
            'header'       => $helper->__('Products Purchased'),
            'index'        => 'products',
            'filter_index' => '(SELECT GROUP_CONCAT(\' \', x.name) FROM sales_flat_order_item x WHERE main_table.entity_id = x.order_id AND x.product_type != \'configurable\')'
        ));
        $this->addColumn('shipping_method', array(
            'header' => $helper->__('Shipping Method'),
            'index'  => 'shipping_description'
        ));
        $this->addColumn('fee_amount', array(
            'header'        => $helper->__('U-PIC Insurance'),
            'index'         => 'fee_amount',
            'type'          => 'currency',
            'currency_code' => $currency,
        ));
        $this->addColumn('grand_total', array(
            'header'        => $helper->__('Grand Total'),
            'index'         => 'grand_total',
            'type'          => 'currency',
            'currency_code' => $currency,
        ));
        $this->addExportType('*/*/exportSimpleCsv', Mage::helper('reports')->__('CSV'));
        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}