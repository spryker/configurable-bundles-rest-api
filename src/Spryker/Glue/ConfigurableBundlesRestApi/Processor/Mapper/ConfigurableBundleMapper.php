<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ConfigurableBundlesRestApi\Processor\Mapper;

use Generated\Shared\Transfer\ProductImageSetStorageTransfer;
use Generated\Shared\Transfer\RestConfigurableBundleImagesAttributesTransfer;
use Generated\Shared\Transfer\RestConfigurableBundleTemplateImageSetsAttributesTransfer;

class ConfigurableBundleMapper implements ConfigurableBundleMapperInterface
{
    public function mapProductImageSetStorageTransferToRestAttributesTransfer(
        ProductImageSetStorageTransfer $productImageSetStorageTransfer,
        RestConfigurableBundleTemplateImageSetsAttributesTransfer $restConfigurableBundleTemplateImageSetsAttributesTransfer
    ): RestConfigurableBundleTemplateImageSetsAttributesTransfer {
        $restConfigurableBundleTemplateImageSetsAttributesTransfer->fromArray(
            $productImageSetStorageTransfer->toArray(),
            true,
        );

        foreach ($productImageSetStorageTransfer->getImages() as $productImageStorageTransfer) {
            $restConfigurableBundleImagesAttributesTransfer = (new RestConfigurableBundleImagesAttributesTransfer())
                ->fromArray($productImageStorageTransfer->toArray(), true);

            $restConfigurableBundleTemplateImageSetsAttributesTransfer->addImage($restConfigurableBundleImagesAttributesTransfer);
        }

        return $restConfigurableBundleTemplateImageSetsAttributesTransfer;
    }
}
