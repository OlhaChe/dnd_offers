<?php

namespace OlhaChe\Offers\Controller\Adminhtml\Offers;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use OlhaChe\Offers\Model\Offers;

class Save extends Action
{

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        private DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('offers_id');

            $model = $this->_objectManager->create(Offers::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Offers no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            if (isset($data['image']) && is_array($data['image'])) {
                if (isset($data['image'][0]['name'])) {
                    $data['image'] = $data['image'][0]['name'];
                }
            } else {
                $data['image'] = null;
            }
            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Offers.'));
                $this->dataPersistor->clear('olhache_offers_offers');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['offers_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Offers.'));
            }

            $this->dataPersistor->set('olhache_offers_offers', $data);
            return $resultRedirect->setPath('*/*/edit', ['offers_id' => $this->getRequest()->getParam('offers_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
