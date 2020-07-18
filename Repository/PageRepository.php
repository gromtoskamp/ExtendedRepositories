<?php

namespace Groskampweb\ExtendedRepositories\Repository;

use Groskampweb\ExtendedRepositories\Search\IdentifierCriteriaBuilder;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Model\PageRepository as MagentoPageRepository;

class PageRepository
{
    /** @var MagentoPageRepository */
    private $pageRepository;
    /** @var IdentifierCriteriaBuilder */
    private $searchCriteriaBuilder;

    /**
     * PageRepository constructor.
     * @param MagentoPageRepository $pageRepository
     * @param IdentifierCriteriaBuilder $identifierCriteriaBuilder
     */
    public function __construct(
        MagentoPageRepository $pageRepository,
        IdentifierCriteriaBuilder $identifierCriteriaBuilder
    ) {
        $this->pageRepository = $pageRepository;
        $this->searchCriteriaBuilder = $identifierCriteriaBuilder;
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
