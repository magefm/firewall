<?php

class MageFM_Firewall_Model_Cronjob
{

    public function execute()
    {
        $orderCount = (int)Mage::getStoreConfig('sales/magefm_firewall/order_count');
        $timeSpan = (int)Mage::getStoreConfig('sales/magefm_firewall/time_span');

        if ($orderCount < 1 || $timeSpan < 1) {
            return;
        }

        /** @var Mage_Core_Model_Resource $resource */
        $resource = Mage::getModel('core/resource');

        $date = new Zend_Date();
        $date->sub($timeSpan, Zend_Date::MINUTE);

        $select = $resource->getConnection('core_read')->select()
            ->from($resource->getConnection('core_read')->getTableName('sales_flat_order'), array(
                'total' => new Zend_Db_Expr('COUNT(1)'),
                'last_xff' => new Zend_Db_Expr('SUBSTRING_INDEX(x_forwarded_for, \',\', -1)')
            ))
            ->where('created_at > ?', $date->toString('YYYY-MM-dd HH:mm:ss'))
            ->group('last_xff')
            ->having('COUNT(1) >= ?', $orderCount);

        $table = $resource->getConnection('core_read')->getTableName('magefm_firewall_restriction_ip');

        foreach ($select->query()->fetchAll() as $item) {
            $resource->getConnection('core_write')->insertIgnore($table, array(
                'ip' => $item['last_xff'],
                'added_at' => now(),
            ), array('ip'));
        }
    }

}
