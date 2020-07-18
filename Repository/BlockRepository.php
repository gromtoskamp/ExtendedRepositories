<?php

namespace Groskampweb\ExtendedRepositories\Repository;

use Groskampweb\ExtendedRepositories\Search\IdentifierCriteriaBuilder;
use Magento\Cms\Api\Data\BlockInterface;
use Magento\Cms\Model\BlockRepository as MagentoBlockRepository;

class BlockRepository
{
    /** @var MagentoBlockRepository */
    private $blockRepository;
    /** @var IdentifierCriteriaBuilder */
    private $identifierCriteriaBuilder;

    /**
     * BlockRepository constructor.
     * @param MagentoBlockRepository $blockRepository
     * @param IdentifierCriteriaBuilder $identifierCriteriaBuilder
     */
    public function __construct(
        MagentoBlockRepository $blockRepository,
        IdentifierCriteriaBuilder $identifierCriteriaBuilder
    ) {
        $this->blockRepository = $blockRepository;
        $this->identifierCriteriaBuilder = $identifierCriteriaBuilder;
    }

    /**
     * @param string $identifier
     * @return BlockInterface[]
     */
    public function getByIdentifier(string $identifier): array
    {
        $searchCriteria = $this->identifierCriteriaBuilder->create($identifier);
        $blockSearchResults = $this->blockRepository->getList($searchCriteria);

        return $blockSearchResults->getItems();
    }
}
