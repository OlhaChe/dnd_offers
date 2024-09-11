<?php

namespace OlhaChe\Offers\Controller\Adminhtml\Offers;

use OlhaChe\Offers\Controller\Adminhtml\Offers;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Offers
{

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        protected PageFactory $resultPageFactory
    ) {
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('offers_id');
        $model = $this->_objectManager->create(\OlhaChe\Offers\Model\Offers::class);

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Offers no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('olhache_offers_offers', $model);

        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Offers') : __('New Offers'),
            $id ? __('Edit Offers') : __('New Offers')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Offerss'));
        $resultPage->getConfig()->getTitle()->prepend(
            $model->getId() ? __('Edit Offers %1', $model->getId()) : __('New Offers')
        );
        return $resultPage;
    }
}
