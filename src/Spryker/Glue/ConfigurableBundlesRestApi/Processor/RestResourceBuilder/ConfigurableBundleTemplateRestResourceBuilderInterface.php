<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ConfigurableBundlesRestApi\Processor\RestResourceBuilder;

use Generated\Shared\Transfer\ConfigurableBundleTemplateStorageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;

interface ConfigurableBundleTemplateRestResourceBuilderInterface
{
    public function buildConfigurableBundleTemplateRestResource(
        ConfigurableBundleTemplateStorageTransfer $configurableBundleTemplateStorageTransfer
    ): RestResourceInterface;
}
