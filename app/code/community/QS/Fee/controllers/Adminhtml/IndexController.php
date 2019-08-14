<?php
class QS_Fee_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Return some checking result
     *
     * @return void
     */
    public function sendEmailAction()
    {
        $fromEmail = $this->getRequest()->getParam("from",0);
        $toEmail = $this->getRequest()->getParam("to",0);
        $body = $this->getRequest()->getParam("message",0);

        $fromName = "Alex Stojka"; // sender name
        $toName = "U-Pic Insurnace"; // recipient name
        $subject = "Activate Insurance"; // subject text

        $mail = new Zend_Mail();

        $mail->setBodyText($body);

        $mail->setFrom($fromEmail, $fromName);

        $mail->addTo($toEmail, $toName);

        $mail->setSubject($subject);

        try {
            $mail->send();
            $response['success'] = true;
        }
        catch(Exception $ex) {
            // I assume you have your custom module.
            // If not, you may keep 'customer' instead of 'yourmodule'.
            Mage::getSingleton('core/session')
                ->addError(Mage::helper('fee')
                    ->__('Unable to send email.'));
            $response['success'] = false;
            $response['message'] = 'Invalid request';
        }

        $result = $this->getResponse()->setBody(Zend_Json::encode($response));
        return $result;
    }
}