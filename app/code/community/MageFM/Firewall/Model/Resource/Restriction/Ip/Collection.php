<?php

class MageFM_Firewall_Model_Resource_Restriction_Ip_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    public function _construct()
    {
        $this->_init('magefm_firewall/restriction_ip');
    }

}
