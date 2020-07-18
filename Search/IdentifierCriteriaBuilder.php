<?php

namespace Groskampweb\ExtendedRepositories\Search;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;

class IdentifierCriteriaBuilder
{
    /** @var string */
    private const COLUMN_IDENTIFIER = 'identifier';

    /** @var SearchCriteriaBuilder */
    private $searchCriteriaBuilder;

    /**
     * CmsPageIdentifierFilter constructor.
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param string $identifier
     * @return SearchCriteriaInterface
     */
    public function create(string $identifier): SearchCriteriaInterface
    {
        return $this->searchCriteriaBuilder
            ->addFilter(self::COLUMN_IDENTIFIER, $identifier)
            ->create();
    }
}
