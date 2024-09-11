<?php

namespace OlhaChe\Offers\Api\Data;

interface OffersInterface
{
    public const NAME = 'name';
    public const LINK = 'link';
    public const ENABLED = 'enabled';
    public const IMAGE = 'image';
    public const CATEGORY = 'category';
    public const OFFERS_ID = 'offers_id';
    public const CREATED_AT = 'created_at';
    public const FINISH_AT = 'finish_at';

    /**
     * Get offers_id
     *
     * @return string|null
     */
    public function getOffersId(): ?string;

    /**
     * Set offers_id
     *
     * @param string $offersId
     * @return OffersInterface
     */
    public function setOffersId(string $offersId): OffersInterface;

    /**
     * Get Name
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Set Name
     *
     * @param string $name
     * @return OffersInterface
     */
    public function setName(string $name): OffersInterface;

    /**
     * Get Image
     *
     * @return string|null
     */
    public function getImage(): ?string;

    /**
     * Set Image
     *
     * @param string $image
     * @return OffersInterface
     */
    public function setImage(string $image): OffersInterface;

    /**
     * Get Link
     *
     * @return string|null
     */
    public function getLink(): ?string;

    /**
     * Set Link
     *
     * @param string $link
     * @return OffersInterface
     */
    public function setLink(string $link): OffersInterface;

    /**
     * Get Enabled
     *
     * @return string|null
     */
    public function getEnabled(): ?string;

    /**
     * Set Enabled
     *
     * @param string $enabled
     * @return OffersInterface
     */
    public function setEnabled(string $enabled): ?OffersInterface;

    /**
     * Get Category
     *
     * @return string|null
     */
    public function getCategory(): ?string;

    /**
     * Set category
     *
     * @param string $category
     * @return OffersInterface
     */
    public function setCategory(string $category): OffersInterface;

    /**
     * Get created_at
     *
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * Set created_at
     *
     * @param string $createdAt
     * @return OffersInterface
     */
    public function setCreatedAt(string $createdAt): OffersInterface;

    /**
     * Get finish_at
     *
     * @return string|null
     */
    public function getFinishAt(): ?string;

    /**
     * Set finish_at
     *
     * @param string $finishAt
     * @return OffersInterface
     */
    public function setFinishAt(string $finishAt): OffersInterface;
}
