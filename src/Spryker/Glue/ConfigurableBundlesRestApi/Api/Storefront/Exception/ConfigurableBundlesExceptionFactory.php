<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ConfigurableBundlesRestApi\Api\Storefront\Exception;

use Spryker\ApiPlatform\Exception\GlueApiException;
use Spryker\Glue\ConfigurableBundlesRestApi\ConfigurableBundlesRestApiConfig;
use Symfony\Component\HttpFoundation\Response;

class ConfigurableBundlesExceptionFactory
{
    public function createTemplateNotFoundException(): GlueApiException
    {
        return new GlueApiException(
            Response::HTTP_NOT_FOUND,
            ConfigurableBundlesRestApiConfig::RESPONSE_CODE_CONFIGURABLE_BUNDLE_TEMPLATE_NOT_FOUND,
            ConfigurableBundlesRestApiConfig::RESPONSE_DETAIL_CONFIGURABLE_BUNDLE_TEMPLATE_NOT_FOUND,
        );
    }
}
