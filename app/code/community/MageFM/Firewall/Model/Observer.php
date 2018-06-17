<?php

class MageFM_Firewall_Model_Observer
{

    public function controllerPredispatch(Varien_Event_Observer $observer)
    {
        /** @var Mage_Core_Controller_Front_Action $controller */
        $controller = $observer->getControllerAction();

        if (Mage::getModel('magefm_firewall/restriction')->isRestricted($controller->getRequest())) {
            $this->sendBlockedResponse($controller);
        }
    }

    private function sendBlockedResponse(Mage_Core_Controller_Front_Action $controller)
    {
        $controller->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);

        if ($controller->getRequest()->isAjax()) {
            $controller->getResponse()->setBody(Zend_Json::encode(array(
                'success' => false,
                'message' => Mage::helper('core')->__('This request was blocked for security reasons.'),
            )));

            $controller->getResponse()->setHttpResponseCode(429);
            $controller->getResponse()->sendHeaders();
            die;
        }

        $controller->loadLayout();

        $content = $controller->getLayout()->getBlock('content');
        $content->unsetChildren();

        $errorMessageBlock = $controller
            ->getLayout()
            ->createBlock('core/template')
            ->setTemplate('magefm/firewall/blocked.phtml');

        $content->append($errorMessageBlock);

        Mage::dispatchEvent('magefm_firewall_before_layout_render', array(
            'layout' => $controller->getLayout(),
        ));

        $controller->renderLayout();
        $controller->getResponse()->setHttpResponseCode(429);
        $controller->getResponse()->sendResponse();
        die;
    }

}
