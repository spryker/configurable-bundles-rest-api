<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ConfigurableBundlesRestApi\Api\Storefront\Reader;

use Generated\Shared\Transfer\ConfigurableBundleTemplateStorageTransfer;

interface ConfigurableBundleTemplateStorefrontReaderInterface
{
    public function findTemplateByUuid(string $uuid, string $localeName): ?ConfigurableBundleTemplateStorageTransfer;

    /**
     * @return array<\Generated\Shared\Transfer\ConfigurableBundleTemplateStorageTransfer>
     */
    public function findAllTemplates(string $localeName): array;
}
