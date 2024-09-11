<?php

declare(strict_types=1);

namespace OlhaChe\Offers\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use OlhaChe\Offers\Model\ImageProcessor;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Offers extends AbstractDb
{
    public function __construct(
        Context $context,
        private ImageProcessor $imageProcessor,
        ?string $connectionName = null,
    ) {
        parent::__construct($context, $connectionName);
    }

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('olhache_offers_offers', 'offers_id');
    }

    /**
     * Perform actions before object save
     *
     * @param AbstractModel|\Magento\Framework\DataObject $object
     * @return void
     * @throws \Magento\Framework\Exception\FileSystemException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _beforeSave(AbstractModel $object)
    {
        if ($object->getOrigData('image') && $object->getOrigData('image') !== $object->getImage()) {
            $this->imageProcessor->deleteImage($object->getOrigData('image'));
            $object->setImage($object->getImage() ?: '');
        }

        if (
            !$object->getImage()
            && !empty($object->getData('image'))
            && !empty($object->getData('image')[0])
        ) {
            $object->setImage($object->getData('image')[0]['url'] ?: '');
        }
    }

    /**
     * @param AbstractModel $object
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _afterSave(AbstractModel $object)
    {
        if ($object->getImage() && $object->getOrigData('image') !== $object->getImage()) {
            if (!empty($object->getIdImageDuplicate())) {
                $this->imageProcessor->duplicateImage(
                    $object->getImage(),
                    $object->getIdImageDuplicate(),
                    (int) $object->getId()
                );
            } else {
                $this->imageProcessor->processImage(
                    $object->getImage(),
                    (int) $object->getId()
                );
            }
        }
    }
}
