<?php

namespace OlhaChe\Offers\Controller\Adminhtml\Image;

use Magento\Catalog\Model\ImageUploader;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class Upload extends Action
{
    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        private JsonFactory $resultJsonFactory,
        private ImageUploader $imageUploader
    ) {
        parent::__construct($context);
    }

    /**
     * Upload file controller action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        try {
            $result = $this->imageUploader->saveFileToTmpDir('image');
            return $this->resultJsonFactory->create()->setData($result);
        } catch (\Exception $e) {
            return $this->resultJsonFactory->create()->setData([
                'error' => $e->getMessage(),
                'errorcode' => $e->getCode()
            ]);
        }
    }
}
