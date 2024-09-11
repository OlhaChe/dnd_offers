<?php

namespace OlhaChe\Offers\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use OlhaChe\Offers\Api\Data\OffersInterface;
use OlhaChe\Offers\Api\Data\OffersInterfaceFactory;
use OlhaChe\Offers\Api\Data\OffersSearchResultsInterfaceFactory;
use OlhaChe\Offers\Api\OffersRepositoryInterface;
use OlhaChe\Offers\Model\ResourceModel\Offers as ResourceOffers;
use OlhaChe\Offers\Model\ResourceModel\Offers\CollectionFactory as OffersCollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use OlhaChe\Offers\Api\Data\OffersSearchResultsInterface;
use OlhaChe\Offers\Model\ResourceModel\Offers\Collection;

class OffersRepository implements OffersRepositoryInterface
{
    /**
     * @param ResourceOffers $resource
     * @param OffersInterfaceFactory $offersFactory
     * @param OffersCollectionFactory $offersCollectionFactory
     * @param OffersSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        private ResourceOffers $resource,
        private OffersInterfaceFactory $offersFactory,
        private OffersCollectionFactory $offersCollectionFactory,
        private OffersSearchResultsInterfaceFactory $searchResultsFactory,
        private CollectionProcessorInterface $collectionProcessor
    ) {
    }

    /**
     * @param OffersInterface $offers
     * @return OffersInterface
     * @throws CouldNotSaveException
     */
    public function save(OffersInterface $offers): OffersInterface
    {
        try {
            $this->resource->save($offers);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the offers: %1',
                $exception->getMessage()
            ));
        }
        return $offers;
    }

    /**
     * @param string $offersId
     * @return OffersInterface
     * @throws NoSuchEntityException
     */
    public function get(string $offersId): OffersInterface
    {
        $offers = $this->offersFactory->create();
        $this->resource->load($offers, $offersId);
        if (!$offers->getId()) {
            throw new NoSuchEntityException(__('offers with id "%1" does not exist.', $offersId));
        }
        return $offers;
    }

    /**
     * @param SearchCriteriaInterface $criteria
     * @return OffersSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria): OffersSearchResultsInterface
    {
        $collection = $this->offersCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     *  Delete offer
     *
     * @param OffersInterface $offers
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(OffersInterface $offers): bool
    {
        try {
            $offersModel = $this->offersFactory->create();
            $this->resource->load($offersModel, $offers->getOffersId());
            $this->resource->delete($offersModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the offers: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * Delete offers by ID
     *
     * @param string $offersId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(string $offersId): bool
    {
        return $this->delete($this->get($offersId));
    }

    /**
     * Get offers by category ID
     *
     * @param string $categoryId
     * @return Collection
     */
    public function getOffersByCategory(string $categoryId): Collection
    {
        $collection = $this->offersCollectionFactory->create();

        $collection->addFieldToFilter('category', ['finset' => $categoryId]);
        return $collection;
    }
}
