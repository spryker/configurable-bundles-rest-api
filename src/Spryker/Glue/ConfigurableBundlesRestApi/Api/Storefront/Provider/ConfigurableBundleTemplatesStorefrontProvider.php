<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ConfigurableBundlesRestApi\Api\Storefront\Provider;

use Generated\Api\Storefront\ConfigurableBundleTemplatesStorefrontResource;
use Generated\Shared\Transfer\ConfigurableBundleTemplateStorageTransfer;
use Spryker\ApiPlatform\State\Provider\AbstractStorefrontProvider;
use Spryker\Glue\ConfigurableBundlesRestApi\Api\Storefront\Exception\ConfigurableBundlesExceptionFactory;
use Spryker\Glue\ConfigurableBundlesRestApi\Api\Storefront\Reader\ConfigurableBundleTemplateStorefrontReaderInterface;

class ConfigurableBundleTemplatesStorefrontProvider extends AbstractStorefrontProvider
{
    protected const string KEY_UUID = 'uuid';

    public function __construct(
        protected ConfigurableBundleTemplateStorefrontReaderInterface $reader,
        protected ConfigurableBundlesExceptionFactory $exceptionFactory,
    ) {
    }

    /**
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     *
     * @return \Generated\Api\Storefront\ConfigurableBundleTemplatesStorefrontResource|null
     */
    protected function provideItem(): ?object
    {
        $uuid = (string)$this->getUriVariable(static::KEY_UUID);

        $configurableBundleTemplateStorageTransfer = $this->reader->findTemplateByUuid($uuid, (string)$this->getLocale()->getLocaleName());

        if ($configurableBundleTemplateStorageTransfer === null) {
            throw $this->exceptionFactory->createTemplateNotFoundException();
        }

        return $this->mapTransferToResource($configurableBundleTemplateStorageTransfer);
    }

    /**
     * @return array<\Generated\Api\Storefront\ConfigurableBundleTemplatesStorefrontResource>
     */
    protected function provideCollection(): array
    {
        $configurableBundleTemplateStorageTransfers = $this->reader->findAllTemplates((string)$this->getLocale()->getLocaleName());

        return array_map(
            fn (ConfigurableBundleTemplateStorageTransfer $configurableBundleTemplateStorageTransfer) => $this->mapTransferToResource($configurableBundleTemplateStorageTransfer),
            $configurableBundleTemplateStorageTransfers,
        );
    }

    protected function mapTransferToResource(
        ConfigurableBundleTemplateStorageTransfer $configurableBundleTemplateStorageTransfer,
    ): ConfigurableBundleTemplatesStorefrontResource {
        $resource = new ConfigurableBundleTemplatesStorefrontResource();
        $resource->uuid = $configurableBundleTemplateStorageTransfer->getUuid();
        $resource->name = $configurableBundleTemplateStorageTransfer->getName();
        $resource->storageData = $configurableBundleTemplateStorageTransfer->toArray(true, true);

        return $resource;
    }
}
