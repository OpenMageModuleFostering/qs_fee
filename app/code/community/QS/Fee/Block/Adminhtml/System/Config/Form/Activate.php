<?php
class QS_Fee_Block_Adminhtml_System_Config_Form_Activate extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /*
     * Set template
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('fee/system/config/activate_link.phtml');
    }

    /**
     * Return element html
     *
     * @param  Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        return $this->_toHtml();
    }

    /**
     * Return ajax url for button
     *
     * @return string
     */
    public function getAjaxCheckUrl()
    {
        return Mage::helper('adminhtml')->getUrl('adminhtml/index/sendEmail');
    }

    /**
     * Generate button html
     *
     * @return string
     */
    public function getButtonHtml()
    {
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'id'        => 'activate_button',
                'label'     => $this->helper('adminhtml')->__('Send'),
                'onclick'   => 'activatePopup.showPopupBox();'
            ));

        return $button->toHtml();
    }

    public function getUpicEmailAdress(){
        $upic_email_adress = Mage::getStoreConfig('upic/general/upic_email_adress');
        return $upic_email_adress;
    }

    public function getAdminEmailAdress(){
        $admin_email_adress = Mage::getStoreConfig('trans_email/ident_general/email');
        return $admin_email_adress;
    }
}