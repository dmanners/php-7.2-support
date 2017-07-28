<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\AdvancedSearch\Model\Recommendations;

use Magento\AdvancedSearch\Model\ResourceModel\RecommendationsFactory;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class \Magento\AdvancedSearch\Model\Recommendations\SaveSearchQueryRelationsObserver
 *
 * @since 2.0.0
 */
class SaveSearchQueryRelationsObserver implements ObserverInterface
{

    /**
     * @var RecommendationsFactory
     * @since 2.0.0
     */
    private $recommendationsFactory;

    /**
     * @param RecommendationsFactory $recommendationsFactory
     * @since 2.0.0
     */
    public function __construct(RecommendationsFactory $recommendationsFactory)
    {
        $this->recommendationsFactory = $recommendationsFactory;
    }

    /**
     * Save search query relations after save search query
     *
     * @param EventObserver $observer
     * @return void
     * @since 2.0.0
     */
    public function execute(EventObserver $observer)
    {
        $searchQueryModel = $observer->getEvent()->getDataObject();
        $queryId = $searchQueryModel->getId();
        $relatedQueries = $searchQueryModel->getSelectedQueriesGrid();

        if (strlen($relatedQueries) == 0) {
            $relatedQueries = [];
        } else {
            $relatedQueries = explode('&', $relatedQueries);
        }

        $this->recommendationsFactory->create()->saveRelatedQueries($queryId, $relatedQueries);
    }
}
