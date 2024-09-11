<?php

namespace OlhaChe\Offers\Model;

use Magento\Framework\Model\AbstractModel;
use OlhaChe\Offers\Api\Data\OffersInterface;
use OlhaChe\Offers\Model\ResourceModel\Offers as ResourceModelOffers;

class Offers extends AbstractModel implements OffersInterface
{
    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(ResourceModelOffers::class);
    }

    /**
     * Get offers_id
     *
     * @return string|null
     */
    public function getOffersId(): ?string
    {
        return $this->getData(self::OFFERS_ID);
    }

    /**
     * Set offers_id
     *
     * @param string $offersId
     * @return OffersInterface
     */
    public function setOffersId(string $offersId): OffersInterface
    {
        return $this->setData(self::OFFERS_ID, $offersId);
    }

    /**
     * Get Name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    /**
     * Set Name
     *
     * @param string $name
     * @return OffersInterface
     */
    public function setName(string $name): OffersInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get Image
     *
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * Set Image
     *
     * @param string $image
     * @return OffersInterface
     */
    public function setImage(string $image): OffersInterface
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Get Link
     *
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->getData(self::LINK);
    }

    /**
     * Set Link
     *
     * @param string $link
     * @return OffersInterface
     */
    public function setLink(string $link): OffersInterface
    {
        return $this->setData(self::LINK, $link);
    }

    /**
     * Get Enabled
     *
     * @return string|null
     */
    public function getEnabled(): ?string
    {
        return $this->getData(self::ENABLED);
    }

    /**
     * Set Enabled
     *
     * @param string $enabled
     * @return OffersInterface
     */
    public function setEnabled(string $enabled): ?OffersInterface
    {
        return $this->setData(self::ENABLED, $enabled);
    }

    /**
     * Get Category
     *
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->getData(self::CATEGORY);
    }

    /**
     * Set category
     *
     * @param string $category
     * @return OffersInterface
     */
    public function setCategory(string $category): OffersInterface
    {
        return $this->setData(self::CATEGORY, $category);
    }

    /**
     * Get created_at
     *
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set created_at
     *
     * @param string $createdAt
     * @return OffersInterface
     */
    public function setCreatedAt(string $createdAt): OffersInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get finish_at
     *
     * @return string|null
     */
    public function getFinishAt(): ?string
    {
        return $this->getData(self::FINISH_AT);
    }

    /**
     * Set finish_at
     *
     * @param string $finishAt
     * @return OffersInterface
     */
    public function setFinishAt(string $finishAt): OffersInterface
    {
        return $this->setData(self::FINISH_AT, $finishAt);
    }

    /**
     * @return Offers
     */
    public function beforeSave()
    {
        $categories = $this->getData('category');
        if (is_array($categories)) {
            // Save as a comma-separated string
            $this->setData('category', implode(',', $categories));
        }
        return parent::beforeSave();
    }

    /**
     * @return Offers
     */
    public function afterLoad()
    {
        $categories = $this->getData('category');
        if ($categories) {
            // Load as an array
            $this->setData('category', explode(',', $categories));
        }
        return parent::afterLoad();
    }
}
