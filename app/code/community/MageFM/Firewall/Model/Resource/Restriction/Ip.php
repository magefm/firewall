<?php

class MageFM_Firewall_Model_Resource_Restriction_Ip extends Mage_Core_Model_Resource_Db_Abstract
{

    public function _construct()
    {
        $this->_init('magefm_firewall/restriction_ip', 'id');
    }

}
