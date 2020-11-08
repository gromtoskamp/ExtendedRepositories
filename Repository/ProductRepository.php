<?php

namespace Groskampweb\ExtendedRepositories\Repository;

use Magento\Catalog\Api\CategoryLinkManagementInterface;
use Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory;
use Magento\Catalog\Api\ProductAttributeRepositoryInterface;
use Magento\Catalog\Controller\Adminhtml\Product\Initialization\Helper;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Gallery\MimeTypeExtensionMap;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\ProductRepository as MagentoProductRepository;
use Magento\Framework\Api\Data\ImageContentInterfaceFactory;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\ImageContentValidatorInterface;
use Magento\Framework\Api\ImageProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\EntityManager\Operation\Read\ReadExtensions;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\StoreManagerInterface;

class ProductRepository extends MagentoProductRepository
{
    /** @var CategoryRepository */
    private $categoryRepository;

    public function __construct(
        ProductFactory $productFactory,
        Helper $initializationHelper,
        ProductSearchResultsInterfaceFactory $searchResultsFactory,
        ResourceModel\Product\CollectionFactory $collectionFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ProductAttributeRepositoryInterface $attributeRepository,
        ResourceModel\Product $resourceModel,
        Product\Initialization\Helper\ProductLinks $linkInitializer,
        Product\LinkTypeProvider $linkTypeProvider,
        StoreManagerInterface $storeManager,
        FilterBuilder $filterBuilder,
        ProductAttributeRepositoryInterface $metadataServiceInterface,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        Product\Option\Converter $optionConverter,
        Filesystem $fileSystem,
        ImageContentValidatorInterface $contentValidator,
        ImageContentInterfaceFactory $contentFactory,
        MimeTypeExtensionMap $mimeTypeExtensionMap,
        ImageProcessorInterface $imageProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        CollectionProcessorInterface $collectionProcessor = null,
        Json $serializer = null,
        $cacheLimit = 1000,
        ReadExtensions $readExtensions = null,
        CategoryLinkManagementInterface $linkManagement = null,
        CategoryRepository $categoryRepository
    ) {
        parent::__construct(
            $productFactory,
            $initializationHelper,
            $searchResultsFactory,
            $collectionFactory,
            $searchCriteriaBuilder,
            $attributeRepository,
            $resourceModel,
            $linkInitializer,
            $linkTypeProvider,
            $storeManager,
            $filterBuilder,
            $metadataServiceInterface,
            $extensibleDataObjectConverter,
            $optionConverter,
            $fileSystem,
            $contentValidator,
            $contentFactory,
            $mimeTypeExtensionMap,
            $imageProcessor,
            $extensionAttributesJoinProcessor,
            $collectionProcessor,
            $serializer,
            $cacheLimit,
            $readExtensions,
            $linkManagement
        );
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param $categoryId
     * @return Product[]
     * @throws NoSuchEntityException
     */
    public function getByCategoryId($categoryId): array
    {
        /** @var Category $category */
        $category = $this->categoryRepository->get($categoryId);
        return $category->getProductCollection()->getItems();
    }
}
