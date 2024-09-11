<?php

namespace OlhaChe\Offers\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class CategoryOptions implements OptionSourceInterface
{
    public function __construct(public CollectionFactory $categoryCollectionFactory)
    {
    }

    public function toOptionArray()
    {
        $collection = $this->categoryCollectionFactory->create()
            ->addAttributeToSelect('name')  // Add category name
            ->addIsActiveFilter();                  // Only active categories

        $options = [];
        foreach ($collection as $category) {
            $options[] = [
                'value' => $category->getId(),
                'label' => $category->getName()
            ];
        }
        return $options;
    }
}
