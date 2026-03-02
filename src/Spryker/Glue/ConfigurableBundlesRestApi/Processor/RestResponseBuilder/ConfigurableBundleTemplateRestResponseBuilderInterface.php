<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ConfigurableBundlesRestApi\Processor\RestResponseBuilder;

use Generated\Shared\Transfer\ConfigurableBundleTemplateStorageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

interface ConfigurableBundleTemplateRestResponseBuilderInterface
{
    public function createRestResponse(): RestResponseInterface;

    public function buildConfigurableBundleTemplateNotFoundErrorRestResponse(): RestResponseInterface;

    public function buildConfigurableBundleTemplateRestResponse(
        ConfigurableBundleTemplateStorageTransfer $configurableBundleTemplateStorageTransfer,
        string $localeName
    ): RestResponseInterface;

    /**
     * @param array<\Generated\Shared\Transfer\ConfigurableBundleTemplateStorageTransfer> $configurableBundleTemplateStorageTransfers
     * @param string $localeName
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function buildConfigurableBundleTemplateCollectionRestResponse(
        array $configurableBundleTemplateStorageTransfers,
        string $localeName
    ): RestResponseInterface;
}
