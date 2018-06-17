<?php

class MageFM_Firewall_Model_Restriction_Ip extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        $this->_init('magefm_firewall/restriction_ip');
    }

    public function loadByIpAddress($ipAddress)
    {
        return $this->load($ipAddress, 'ip');
    }

    public function isRestricted()
    {
        if (empty($this->getId())) {
            return false;
        }

        return true;
    }

}
