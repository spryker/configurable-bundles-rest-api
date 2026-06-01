<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ConfigurableBundlesRestApi\Api\Storefront\Relationship;

use Generated\Api\Storefront\ConfigurableBundleTemplateSlotsStorefrontResource;
use Generated\Api\Storefront\ConfigurableBundleTemplatesStorefrontResource;
use Generated\Shared\Transfer\ConfigurableBundleTemplateSlotStorageTransfer;
use Generated\Shared\Transfer\ConfigurableBundleTemplateStorageTransfer;
use Spryker\ApiPlatform\Relationship\AbstractRelationshipResolver;

class ConfigurableBundleTemplateSlotsRelationshipResolver extends AbstractRelationshipResolver
{
    /**
     * @return array<\Generated\Api\Storefront\ConfigurableBundleTemplateSlotsStorefrontResource>
     */
    protected function resolveRelationship(): array
    {
        $resources = [];

        foreach ($this->getParentResources() as $parentResource) {
            if (!$parentResource instanceof ConfigurableBundleTemplatesStorefrontResource) {
                continue;
            }

            if ($parentResource->storageData === []) {
                continue;
            }

            $configurableBundleTemplateStorageTransfer = (new ConfigurableBundleTemplateStorageTransfer())->fromArray($parentResource->storageData, true);

            foreach ($configurableBundleTemplateStorageTransfer->getSlots() as $configurableBundleTemplateSlotStorageTransfer) {
                $resources[] = $this->mapSlotToResource($configurableBundleTemplateSlotStorageTransfer);
            }
        }

        return $resources;
    }

    protected function mapSlotToResource(
        ConfigurableBundleTemplateSlotStorageTransfer $configurableBundleTemplateSlotStorageTransfer,
    ): ConfigurableBundleTemplateSlotsStorefrontResource {
        $resource = new ConfigurableBundleTemplateSlotsStorefrontResource();
        $resource->uuid = $configurableBundleTemplateSlotStorageTransfer->getUuid();
        $resource->name = $configurableBundleTemplateSlotStorageTransfer->getName();
        $resource->idProductList = $configurableBundleTemplateSlotStorageTransfer->getIdProductList();

        return $resource;
    }
}
