<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ConfigurableBundlesRestApi\Processor\Reader;

use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface ConfigurableBundleTemplateReaderInterface
{
    public function getConfigurableBundleTemplate(
        string $uuidConfigurableBundleTemplate,
        RestRequestInterface $restRequest
    ): RestResponseInterface;

    public function getConfigurableBundleTemplateCollection(RestRequestInterface $restRequest): RestResponseInterface;
}
