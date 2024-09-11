<?php

namespace OlhaChe\Offers\Controller\Adminhtml\Offers;

use OlhaChe\Offers\Controller\Adminhtml\Offers;

class Delete extends Offers
{
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('offers_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\OlhaChe\Offers\Model\Offers::class);
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Offers.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['offers_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Offers to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
