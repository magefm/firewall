<?php

class MageFM_Firewall_Model_Restriction
{

    /**
     * @param Mage_Core_Controller_Request_Http $request
     * @return bool
     */
    public function isRestricted(Mage_Core_Controller_Request_Http $request)
    {
        $ipAddress = $request->getClientIp();

        /** @var MageFM_Firewall_Model_Restriction_Ip $ipRestriction */
        $ipRestriction = Mage::getModel('magefm_firewall/restriction_ip')->loadByIpAddress($ipAddress);
        return $ipRestriction->isRestricted();
    }

}
