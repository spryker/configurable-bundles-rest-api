<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ConfigurableBundlesRestApi\Api\Storefront\Relationship;

use Generated\Api\Storefront\ConfigurableBundleTemplateImageSetsStorefrontResource;
use Generated\Api\Storefront\ConfigurableBundleTemplatesStorefrontResource;
use Generated\Shared\Transfer\ConfigurableBundleTemplateStorageTransfer;
use Generated\Shared\Transfer\ProductImageSetStorageTransfer;
use Spryker\ApiPlatform\Relationship\AbstractRelationshipResolver;

class ConfigurableBundleTemplateImageSetsRelationshipResolver extends AbstractRelationshipResolver
{
    /**
     * @return array<\Generated\Api\Storefront\ConfigurableBundleTemplateImageSetsStorefrontResource>
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

            foreach ($configurableBundleTemplateStorageTransfer->getImageSets() as $productImageSetStorageTransfer) {
                $resources[] = $this->mapImageSetToResource($productImageSetStorageTransfer);
            }
        }

        return $resources;
    }

    protected function mapImageSetToResource(
        ProductImageSetStorageTransfer $productImageSetStorageTransfer,
    ): ConfigurableBundleTemplateImageSetsStorefrontResource {
        $resource = new ConfigurableBundleTemplateImageSetsStorefrontResource();
        $resource->name = $productImageSetStorageTransfer->getName();
        $resource->images = array_map(
            fn ($image) => [
                'externalUrlLarge' => $image->getExternalUrlLarge(),
                'externalUrlSmall' => $image->getExternalUrlSmall(),
            ],
            iterator_to_array($productImageSetStorageTransfer->getImages()),
        );

        return $resource;
    }
}
