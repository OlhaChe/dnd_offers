<?php

namespace OlhaChe\Offers\Controller\Adminhtml\Offers;

use OlhaChe\Offers\Controller\Adminhtml\Offers;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Backend\Model\View\Result\ForwardFactory;

class NewAction extends Offers
{
    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        private ForwardFactory $resultForwardFactory
    ) {
        parent::__construct($context, $coreRegistry);
    }

    /**
     * New action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}

