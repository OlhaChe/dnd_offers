<?php

namespace OlhaChe\Offers\ViewModel;

use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use OlhaChe\Offers\Model\OffersRepository;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use OlhaChe\Offers\Model\ImageProcessor;

class OffersInfo extends DataObject implements ArgumentInterface
{
    public function __construct(
        private OffersRepository $offerRepository,
        private Registry $registry,
        private TimezoneInterface $timezone,
        private ImageProcessor $imageProcessor
    ) {
        parent::__construct();
    }

    /**
     * @return array
     */
    public function getActiveOffers(): array
    {
        $category = $this->getCurrentCategory();
        if ($category) {
            $offers = $this->offerRepository->getOffersByCategory($category->getId());
            $currentDate = $this->timezone->date()->format('Y-m-d H:i:s');
            $activeOffers = [];
            foreach ($offers as $offer) {
                if ($offer->getCreatedAt() <= $currentDate && $offer->getFinishAt() >= $currentDate) {
                    $activeOffers[] = $offer;
                }
            }
            return $activeOffers;
        }

        return [];
    }
    /**
     * Get current category
     *
     * @return \Magento\Catalog\Model\Category|null
     */
    public function getCurrentCategory()
    {
        return $this->registry->registry('current_category');
    }

    public function getImageUrl($offer): ?string
    {
        if (!empty($offer->getImage())) {
            return $this->imageProcessor->getImageUrl(
                [
                    ImageProcessor::MEDIA_PATH,
                    $offer->getId(),
                    $offer->getImage()
                ]
            );
        }
        return null;
    }
}
