<?php

require_once 'abstract.php';

class MageFM_Firewall_Shell extends Mage_Shell_Abstract
{

    public function run()
    {
        Mage::getModel('magefm_firewall/cronjob')->execute();
    }

    public function usageHelp()
    {
        return <<<USAGE
Usage:  php magefm_firewall.php

USAGE;
    }

}

$shell = new MageFM_Firewall_Shell();
$shell->run();
