<?php

namespace Zam\SearchOb\Observer;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Page\Config as PageConfig;

/**
 * Class UserHandle
 * @package Zam\SearchOb\Observer
 */
class UserHandle implements ObserverInterface
{
    /**
     * @var CustomerSession $_customerSession
     */
    protected $_customerSession;

    /**
     * @var PageConfig $pageConfig
     */
    protected $pageConfig;

    /**
     * UserHandle constructor.
     * @param CustomerSession $_customerSession
     * @param PageConfig $pageConfig
     */
    public function __construct(
        CustomerSession $_customerSession,
        PageConfig $pageConfig
    ) {
        $this->_customerSession = $_customerSession;
        $this->_pageConfig = $pageConfig;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $layout = $observer->getEvent()->getLayout();

        //To check that customer is logout
        if (!$this->_customerSession->isLoggedIn()) {
            $this->_pageConfig->addPageAsset('Zam_SearchOb::css/logged_out.css');
        }
    }
}
