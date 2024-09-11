<?php

namespace OlhaChe\Offers\Model\Offers;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use OlhaChe\Offers\Model\ResourceModel\Offers\CollectionFactory;
use OlhaChe\Offers\Model\ImageProcessor;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    private array $loadedData;

    /**
     * @inheritDoc
     */
    protected $collection;

    /**
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param ImageProcessor $imageProcessor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        private DataPersistorInterface $dataPersistor,
        private ImageProcessor $imageProcessor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();
        }
        $data = $this->dataPersistor->get('olhache_offers_offers');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('olhache_offers_offers');
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $this->loadedData[$item->getId()] = $item->getData();
            $image = $item->getData('image');
            if ($image) {
                $this->loadedData[$item->getId()]['image'] = [
                    [
                        'name' => $image,
                        'url' => $this->imageProcessor->getImageUrl(
                            [ImageProcessor::MEDIA_PATH, $item->getId(), $image]
                        )
                    ]
                ];
            }
        }
        return $this->loadedData;
    }
}
