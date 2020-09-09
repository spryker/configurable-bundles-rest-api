<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ConfigurableBundlesRestApi\Processor\RestResourceBuilder;

use Generated\Shared\Transfer\ConfigurableBundleTemplateSlotStorageTransfer;
use Generated\Shared\Transfer\RestConfigurableBundleTemplateSlotsAttributesTransfer;
use Spryker\Glue\ConfigurableBundlesRestApi\ConfigurableBundlesRestApiConfig;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestLinkInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;

class ConfigurableBundleTemplateSlotRestResourceBuilder implements ConfigurableBundleTemplateSlotRestResourceBuilderInterface
{
    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     */
    public function __construct(RestResourceBuilderInterface $restResourceBuilder)
    {
        $this->restResourceBuilder = $restResourceBuilder;
    }

    /**
     * @param \Generated\Shared\Transfer\ConfigurableBundleTemplateSlotStorageTransfer $configurableBundleTemplateSlotStorageTransfer
     * @param string $idParentResource
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    public function buildConfigurableBundleTemplateSlotRestResource(
        ConfigurableBundleTemplateSlotStorageTransfer $configurableBundleTemplateSlotStorageTransfer,
        string $idParentResource
    ): RestResourceInterface {
        $restConfigurableBundleTemplateSlotsAttributesTransfer = (new RestConfigurableBundleTemplateSlotsAttributesTransfer())
            ->fromArray($configurableBundleTemplateSlotStorageTransfer->toArray(), true);

        $configurableBundleTemplateSlotRestResource = $this->restResourceBuilder->createRestResource(
            ConfigurableBundlesRestApiConfig::RESOURCE_CONFIGURABLE_BUNDLE_TEMPLATE_SLOTS,
            $configurableBundleTemplateSlotStorageTransfer->getUuid(),
            $restConfigurableBundleTemplateSlotsAttributesTransfer
        );

        $configurableBundleTemplateSlotRestResource->setPayload($configurableBundleTemplateSlotStorageTransfer);
        $configurableBundleTemplateSlotRestResource->addLink(
            RestLinkInterface::LINK_SELF,
            $this->createConfigurableBundleTemplateSlotSelfLink($idParentResource)
        );

        return $configurableBundleTemplateSlotRestResource;
    }

    /**
     * @param string $idParentResource
     *
     * @return string
     */
    protected function createConfigurableBundleTemplateSlotSelfLink(string $idParentResource): string
    {
        return sprintf(
            '%s/%s?include=%s',
            ConfigurableBundlesRestApiConfig::RESOURCE_CONFIGURABLE_BUNDLE_TEMPLATES,
            $idParentResource,
            ConfigurableBundlesRestApiConfig::RESOURCE_CONFIGURABLE_BUNDLE_TEMPLATE_SLOTS
        );
    }
}
