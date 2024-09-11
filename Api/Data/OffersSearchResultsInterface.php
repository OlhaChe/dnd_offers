<?php

namespace OlhaChe\Offers\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface OffersSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get offers list
     *
     * @return array|\Magento\Framework\Api\ExtensibleDataInterface[]
     */
    public function getItems(): array;

    /**
     * Set name list.
     *
     * @param \OlhaChe\Offers\Api\Data\OffersInterface[] $items
     * @return $this
     */
    public function setItems(array $items): OffersSearchResultsInterface;
}

