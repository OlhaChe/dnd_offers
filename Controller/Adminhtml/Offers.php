<?php

namespace OlhaChe\Offers\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Backend\Model\View\Result\Page;

abstract class Offers extends Action
{
    public const ADMIN_RESOURCE = 'OlhaChe_Offers::top_level';

    /**
     * @param Context $context
     * @param Registry $_coreRegistry
     */
    public function __construct(Context $context, protected Registry $_coreRegistry)
    {
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param Page $resultPage
     * @return Page
     */
    public function initPage(Page $resultPage): Page
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('OlhaChe'), __('OlhaChe'))
            ->addBreadcrumb(__('Offers'), __('Offers'));
        return $resultPage;
    }
}

