<?php

class QS_Fee_Helper_Data extends Mage_Core_Helper_Abstract
{
    const SEVERITY_CRITICAL = 1;
    const SEVERITY_MAJOR = 2;
    const SEVERITY_MINOR = 3;
    const SEVERITY_NOTICE = 4;

	public function formatFee(){
		return Mage::helper('fee')->__('U-PIC Parcel Insurance');
	}

    public function formatAmount($amount){
        return '$'.$amount;
    }

    /**
     * Add new message
     *
     * @param int $severity
     * @param string $title
     * @param string|array $description
     * @param string $url
     * @param bool $isInternal
     * @return Mage_AdminNotification_Model_Inbox
     */
    public function add($severity, $title, $description, $url = '', $isInternal = true)
    {
        if (!$this->getSeverities($severity)) {
            Mage::throwException($this->__('Wrong message type'));
        }
        if (is_array($description)) {
            $description = '<ul><li>' . implode('</li><li>', $description) . '</li></ul>';
        }
        $date = date('Y-m-d H:i:s');
        Mage::getModel('adminnotification/inbox')->parse(array(array(
            'severity' => $severity,
            'date_added' => $date,
            'title' => $title,
            'description' => $description,
            'url' => $url,
            'internal' => $isInternal
        )));
        return $this;
    }

    /**
     * Add notice
     *
     * @param string $title
     * @param string|array $description
     * @param string $url
     * @param bool $isInternal
     * @return Mage_AdminNotification_Model_Inbox
     */
    public function addNotice($title, $description, $url = '', $isInternal = true)
    {
        $this->add(self::SEVERITY_NOTICE, $title, $description, $url, $isInternal);
        return $this;
    }

    public function _getNotifier()
    {
        return $this;
    }


    /**
     * Retrieve Severity collection array
     *
     * @return array|string
     */
    public function getSeverities($severity = null)
    {
        $severities = array(
            self::SEVERITY_CRITICAL => Mage::helper('adminnotification')->__('critical'),
            self::SEVERITY_MAJOR => Mage::helper('adminnotification')->__('major'),
            self::SEVERITY_MINOR => Mage::helper('adminnotification')->__('minor'),
            self::SEVERITY_NOTICE => Mage::helper('adminnotification')->__('notice'),
        );

        if (!is_null($severity)) {
            if (isset($severities[$severity])) {
                return $severities[$severity];
            }
            return null;
        }

        return $severities;
    }


}