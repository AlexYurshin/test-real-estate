<?php

declare(strict_types=1);

namespace App\Service;

class ElasticSearchMetadataRegistry
{
    private array $config = [];

    public function addConfig(array $newConfig)
    {
        $this->config[$newConfig['alias']] = $newConfig;
    }

    public function getIndexName(string $alias): string
    {
        if (isset($this->config[$alias])) {
            $prefix = $this->config[$alias]['prefix'] ?? '';
            return \sprintf('%s%s', $prefix, $alias);
        }
        throw new \DomainException(\sprintf('Config for index "%s" not found', $alias));
    }

    public function getIndexMappings(string $alias): array
    {
        if (isset($this->config[$alias]['mappings'])) {
            return $this->config[$alias]['mappings'];
        }
        throw new \DomainException(\sprintf('Mappings for index "%s" not found', $alias));
    }
}
