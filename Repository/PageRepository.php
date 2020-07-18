<?php

namespace Groskampweb\ExtendedRepositories\Repository;

use Groskampweb\ExtendedRepositories\Search\IdentifierCriteriaBuilder;
use Magento\Cms\Api\Data;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Model\Page\IdentityMap;
use Magento\Cms\Model\PageFactory;
use Magento\Cms\Model\PageRepository as MagentoPageRepository;
use Magento\Cms\Model\ResourceModel\Page as ResourcePage;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory as PageCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class PageRepository extends MagentoPageRepository
{
    /** @var MagentoPageRepository */
    private $pageRepository;
    /** @var IdentifierCriteriaBuilder */
    private $searchCriteriaBuilder;

    /**
     * PageRepository constructor.
     * @param ResourcePage $resource
     * @param PageFactory $pageFactory
     * @param Data\PageInterfaceFactory $dataPageFactory
     * @param PageCollectionFactory $pageCollectionFactory
     * @param Data\PageSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface|null $collectionProcessor
     * @param IdentityMap|null $identityMap
     */
    public function __construct(
        ResourcePage $resource,
        PageFactory $pageFactory,
        Data\PageInterfaceFactory $dataPageFactory,
        PageCollectionFactory $pageCollectionFactory,
        Data\PageSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor = null,
        ?IdentityMap $identityMap = null
    ) {
        parent::__construct($resource, $pageFactory, $dataPageFactory, $pageCollectionFactory, $searchResultsFactory, $dataObjectHelper, $dataObjectProcessor, $storeManager, $collectionProcessor, $identityMap);
    }

    /**
     * @param string $identifier
     * @return PageInterface[]
     */
    public function getByIdentifier(string $identifier): array
    {
        $identifierFilter = $this->searchCriteriaBuilder->create($identifier);
        $pageSearchResults = $this->pageRepository->getList($identifierFilter);

        return $pageSearchResults->getItems();
    }
}
