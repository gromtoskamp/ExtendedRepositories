<?php

namespace Groskampweb\ExtendedRepositories\Repository;

use Groskampweb\ExtendedRepositories\Search\IdentifierCriteriaBuilder;
use Magento\Cms\Api\Data;
use Magento\Cms\Api\Data\BlockInterface;
use Magento\Cms\Model\BlockFactory;
use Magento\Cms\Model\BlockRepository as MagentoBlockRepository;
use Magento\Cms\Model\ResourceModel\Block as ResourceBlock;
use Magento\Cms\Model\ResourceModel\Block\CollectionFactory as BlockCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class BlockRepository extends MagentoBlockRepository
{
    /** @var IdentifierCriteriaBuilder */
    private $identifierCriteriaBuilder;

    public function __construct(
        ResourceBlock $resource,
        BlockFactory $blockFactory,
        Data\BlockInterfaceFactory $dataBlockFactory,
        BlockCollectionFactory $blockCollectionFactory,
        Data\BlockSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        IdentifierCriteriaBuilder $identifierCriteriaBuilder,
        CollectionProcessorInterface $collectionProcessor = null
    ) {
        parent::__construct(
            $resource,
            $blockFactory,
            $dataBlockFactory,
            $blockCollectionFactory,
            $searchResultsFactory,
            $dataObjectHelper,
            $dataObjectProcessor,
            $storeManager,
            $collectionProcessor
        );
        $this->identifierCriteriaBuilder = $identifierCriteriaBuilder;
    }

    /**
     * @param string $identifier
     * @return BlockInterface[]
     */
    public function getByIdentifier(string $identifier): array
    {
        $searchCriteria = $this->identifierCriteriaBuilder->create($identifier);
        $blockSearchResults = $this->getList($searchCriteria);

        return $blockSearchResults->getItems();
    }
}
