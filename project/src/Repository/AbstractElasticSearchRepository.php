<?php

declare(strict_types=1);

namespace App\Repository;

use App\Service\ElasticSearchMetadataRegistry;
use Elastica\Client;
use Elastica\Index;

abstract class AbstractElasticSearchRepository
{
    protected ?Index $index = null;

    public function __construct(
        protected Client $client,
        protected ElasticSearchMetadataRegistry $registry
    ) {
    }

    abstract public function getIndexAlias(): string;

    public function getIndex(): Index
    {
        return $this->client->getIndex($this->registry->getIndexName($this->getIndexAlias()));
    }

    public function createIndex(bool $recreate = false): Index
    {
        $index = $this->getIndex();

        $index->create(['mappings' => $this->registry->getIndexMappings($this->getIndexAlias())], $recreate);
        $index->refresh();

        return $index;
    }

    public function initIndex(): Index
    {
        if ($this->index) {
            return $this->index;
        }

        $index = $this->getIndex();
        if (!$index->exists()) {
            $index = $this->createIndex();
        }
        $this->index = $index;

        return $index;
    }
}
