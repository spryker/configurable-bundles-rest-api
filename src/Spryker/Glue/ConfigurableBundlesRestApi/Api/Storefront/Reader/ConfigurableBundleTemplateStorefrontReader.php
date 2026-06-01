<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ConfigurableBundlesRestApi\Api\Storefront\Reader;

use Generated\Shared\Transfer\ConfigurableBundleTemplatePageSearchRequestTransfer;
use Generated\Shared\Transfer\ConfigurableBundleTemplateStorageFilterTransfer;
use Generated\Shared\Transfer\ConfigurableBundleTemplateStorageTransfer;
use Spryker\Client\ConfigurableBundlePageSearch\ConfigurableBundlePageSearchClientInterface;
use Spryker\Client\ConfigurableBundleStorage\ConfigurableBundleStorageClientInterface;
use Spryker\Client\GlossaryStorage\GlossaryStorageClientInterface;

class ConfigurableBundleTemplateStorefrontReader implements ConfigurableBundleTemplateStorefrontReaderInterface
{
    protected const string FORMATTED_RESULT_KEY = 'ConfigurableBundleTemplateCollection';

    public function __construct(
        protected ConfigurableBundleStorageClientInterface $configurableBundleStorageClient,
        protected ConfigurableBundlePageSearchClientInterface $configurableBundlePageSearchClient,
        protected GlossaryStorageClientInterface $glossaryStorageClient,
    ) {
    }

    public function findTemplateByUuid(string $uuid, string $localeName): ?ConfigurableBundleTemplateStorageTransfer
    {
        $transfer = $this->configurableBundleStorageClient->findConfigurableBundleTemplateStorageByUuid($uuid, $localeName);

        if ($transfer === null) {
            return null;
        }

        $translated = $this->translateTemplates([$transfer], $localeName);

        return current($translated) ?: null;
    }

    /**
     * @return array<\Generated\Shared\Transfer\ConfigurableBundleTemplateStorageTransfer>
     */
    public function findAllTemplates(string $localeName): array
    {
        $ids = $this->searchAllTemplateIds();

        if ($ids === []) {
            return [];
        }

        $filterTransfer = (new ConfigurableBundleTemplateStorageFilterTransfer())
            ->setConfigurableBundleTemplateIds($ids)
            ->setLocaleName($localeName);

        $transfers = $this->configurableBundleStorageClient->getConfigurableBundleTemplateStorageCollection($filterTransfer);

        return $this->translateTemplates($transfers, $localeName);
    }

    /**
     * @return array<int>
     */
    protected function searchAllTemplateIds(): array
    {
        $results = $this->configurableBundlePageSearchClient
            ->searchConfigurableBundleTemplates(new ConfigurableBundleTemplatePageSearchRequestTransfer());

        if (!isset($results[static::FORMATTED_RESULT_KEY])) {
            return [];
        }

        $ids = [];
        foreach ($results[static::FORMATTED_RESULT_KEY] as $pageSearchTransfer) {
            $id = $pageSearchTransfer->getFkConfigurableBundleTemplate();
            if ($id !== null) {
                $ids[] = $id;
            }
        }

        return $ids;
    }

    /**
     * @param array<\Generated\Shared\Transfer\ConfigurableBundleTemplateStorageTransfer> $transfers
     *
     * @return array<\Generated\Shared\Transfer\ConfigurableBundleTemplateStorageTransfer>
     */
    protected function translateTemplates(array $transfers, string $localeName): array
    {
        $keys = $this->collectGlossaryKeys($transfers);

        if ($keys === []) {
            return $transfers;
        }

        $translations = $this->glossaryStorageClient->translateBulk($keys, $localeName);

        return $this->applyTranslations($transfers, $translations);
    }

    /**
     * @param array<\Generated\Shared\Transfer\ConfigurableBundleTemplateStorageTransfer> $transfers
     *
     * @return array<string>
     */
    protected function collectGlossaryKeys(array $transfers): array
    {
        $keys = [];
        foreach ($transfers as $transfer) {
            if ($transfer->getName() !== null) {
                $keys[] = $transfer->getName();
            }

            foreach ($transfer->getSlots() as $slot) {
                if ($slot->getName() !== null) {
                    $keys[] = $slot->getName();
                }
            }

            foreach ($transfer->getImageSets() as $imageSet) {
                if ($imageSet->getName() !== null) {
                    $keys[] = $imageSet->getName();
                }
            }
        }

        return array_values(array_unique(array_filter($keys)));
    }

    /**
     * @param array<\Generated\Shared\Transfer\ConfigurableBundleTemplateStorageTransfer> $transfers
     * @param array<string> $translations
     *
     * @return array<\Generated\Shared\Transfer\ConfigurableBundleTemplateStorageTransfer>
     */
    protected function applyTranslations(array $transfers, array $translations): array
    {
        foreach ($transfers as $transfer) {
            $name = $transfer->getName();

            if ($name !== null && isset($translations[$name])) {
                $transfer->setName($translations[$name]);
            }

            $this->translateSlotNames($transfer, $translations);
            $this->translateImageSetNames($transfer, $translations);
        }

        return $transfers;
    }

    /**
     * @param array<string> $translations
     */
    protected function translateSlotNames(ConfigurableBundleTemplateStorageTransfer $configurableBundleTemplateStorageTransfer, array $translations): void
    {
        foreach ($configurableBundleTemplateStorageTransfer->getSlots() as $configurableBundleTemplateSlotStorageTransfer) {
            $name = $configurableBundleTemplateSlotStorageTransfer->getName();

            if ($name !== null && isset($translations[$name])) {
                $configurableBundleTemplateSlotStorageTransfer->setName($translations[$name]);
            }
        }
    }

    /**
     * @param array<string> $translations
     */
    protected function translateImageSetNames(ConfigurableBundleTemplateStorageTransfer $configurableBundleTemplateStorageTransfer, array $translations): void
    {
        foreach ($configurableBundleTemplateStorageTransfer->getImageSets() as $productImageSetStorageTransfer) {
            $name = $productImageSetStorageTransfer->getName();

            if ($name !== null && isset($translations[$name])) {
                $productImageSetStorageTransfer->setName($translations[$name]);
            }
        }
    }
}
