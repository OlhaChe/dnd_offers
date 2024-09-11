<?php

namespace OlhaChe\Offers\Model;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\ImageFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Message\ManagerInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\Framework\Filesystem\Driver\File;
use Filesystem\Directory\WriteInterface;

/**
 * Class ImageProcessor
 */
class ImageProcessor
{
    /**
     * Locator area inside media folder
     */
    public const MEDIA_PATH = 'olhache/offers';

    /**
     * Locator temporary area inside media folder
     */
    public const MEDIA_TMP_PATH = 'olhache/offers/tmp';

    /**
     * @var WriteInterface
     */
    private $mediaDirectory;

    /**
     * @param Filesystem $filesystem
     * @param ImageUploader $imageUploader
     * @param ImageFactory $imageFactory
     * @param StoreManagerInterface $storeManager
     * @param ManagerInterface $messageManager
     * @param LoggerInterface $logger
     * @param ScopeConfigInterface $scopeConfig
     * @param Database $coreFileStorageDatabase
     * @param File $fileDriver
     */
    public function __construct(
        private Filesystem $filesystem,
        private ImageUploader $imageUploader,
        private ImageFactory $imageFactory,
        private StoreManagerInterface $storeManager,
        private ManagerInterface $messageManager,
        private LoggerInterface $logger,
        private ScopeConfigInterface $scopeConfig,
        private Database $coreFileStorageDatabase,
        private File $fileDriver
    ) {
    }

    /**
     * @return WriteInterface
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    private function getMediaDirectory(): WriteInterface
    {
        if ($this->mediaDirectory === null) {
            $this->mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        }

        return $this->mediaDirectory;
    }

    /**
     * @param string $imageName
     *
     * @return string
     */
    public function getImageRelativePath(string $imageName): string
    {
        return $this->imageUploader->getBasePath() . DIRECTORY_SEPARATOR . $imageName;
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getMediaUrl(): string
    {
        return $this->storeManager
            ->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    /**
     * @param array $params
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getImageUrl(array $params = []): string
    {
        return $this->getMediaUrl() . implode(DIRECTORY_SEPARATOR, $params);
    }

    /**
     * Move file from temporary directory
     *
     * @param string $imageName
     * @param int $locationId
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function processImage(string $imageName, int $locationId): void
    {
        $this->setBasePaths($locationId);
        $this->imageUploader->moveFileFromTmp($imageName);
    }

    /**
     * @param string $filename
     */
    public function prepareImage(string $filename): void
    {
        /** @var \Magento\Framework\Image $imageProcessor */
        $imageProcessor = $this->imageFactory->create(['fileName' => $filename]);
        $imageProcessor->keepAspectRatio(true);
        $imageProcessor->keepFrame(true);
        $imageProcessor->keepTransparency(true);
        $imageProcessor->save();
    }

    /**
     * @param string $imageName
     * @return void
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function deleteImage(string $imageName): void
    {
        $this->getMediaDirectory()->delete(
            $this->getImageRelativePath($imageName)
        );
    }

    /**
     * @param int $locationId
     * @return void
     */
    public function setBasePaths(int $locationId): void
    {
        $tmpPath = self::MEDIA_TMP_PATH ;
        $this->imageUploader->setBaseTmpPath(
            $tmpPath
        );

        $this->imageUploader->setBasePath(
            self::MEDIA_PATH . DIRECTORY_SEPARATOR . $locationId
        );
    }


    /**
     * @param string $imageName
     * @param int $idOld
     * @param int $idNew
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function duplicateImage(string $imageName, int $idOld, int $idNew): void
    {
        $mediaRootDir = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();

        $baseNewPath = self::MEDIA_PATH . DIRECTORY_SEPARATOR . $idNew ;
        $baseOldPath = self::MEDIA_PATH . DIRECTORY_SEPARATOR . $idOld;

        $baseOldImagePath = $this->imageUploader->getFilePath($baseOldPath, $imageName);
        $baseNewImagePath = $this->imageUploader->getFilePath($baseNewPath, $imageName);
        try {
            if ($this->fileDriver->isExists($mediaRootDir . $baseOldPath)) {
                $this->coreFileStorageDatabase->copyFile(
                    $baseOldImagePath,
                    $baseNewImagePath
                );
                $this->getMediaDirectory()->copyFile(
                    $baseOldImagePath,
                    $baseNewImagePath
                );
            }

        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Problem with saving the image(s).' . $imageName)
            );
        }
    }
}
