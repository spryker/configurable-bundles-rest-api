<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ConfigurableBundlesRestApi;

use Spryker\Glue\ConfigurableBundlesRestApi\Dependency\Client\ConfigurableBundlesRestApiToConfigurableBundlePageSearchClientInterface;
use Spryker\Glue\ConfigurableBundlesRestApi\Dependency\Client\ConfigurableBundlesRestApiToConfigurableBundleStorageClientInterface;
use Spryker\Glue\ConfigurableBundlesRestApi\Dependency\Client\ConfigurableBundlesRestApiToGlossaryStorageClientInterface;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\Expander\ConfigurableBundleRestResourceExpanderInterface;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\Expander\ConfigurableBundleTemplateImageSetExpander;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\Expander\ConfigurableBundleTemplateSlotExpander;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\Expander\QuoteRequestItemExpander;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\Expander\QuoteRequestItemExpanderInterface;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\Mapper\ConfigurableBundleMapper;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\Mapper\ConfigurableBundleMapperInterface;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\Mapper\OrderItemMapper;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\Mapper\OrderItemMapperInterface;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\Reader\ConfigurableBundleTemplateReader;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\Reader\ConfigurableBundleTemplateReaderInterface;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\RestResourceBuilder\ConfigurableBundleTemplateImageSetRestResourceBuilder;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\RestResourceBuilder\ConfigurableBundleTemplateImageSetRestResourceBuilderInterface;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\RestResourceBuilder\ConfigurableBundleTemplateRestResourceBuilder;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\RestResourceBuilder\ConfigurableBundleTemplateRestResourceBuilderInterface;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\RestResourceBuilder\ConfigurableBundleTemplateSlotRestResourceBuilder;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\RestResourceBuilder\ConfigurableBundleTemplateSlotRestResourceBuilderInterface;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\RestResponseBuilder\ConfigurableBundleTemplateRestResponseBuilder;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\RestResponseBuilder\ConfigurableBundleTemplateRestResponseBuilderInterface;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\Translator\ConfigurableBundleTranslator;
use Spryker\Glue\ConfigurableBundlesRestApi\Processor\Translator\ConfigurableBundleTranslatorInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class ConfigurableBundlesRestApiFactory extends AbstractFactory
{
    public function createConfigurableBundleTemplateReader(): ConfigurableBundleTemplateReaderInterface
    {
        return new ConfigurableBundleTemplateReader(
            $this->getConfigurableBundleStorageClient(),
            $this->getConfigurableBundlePageSearchClient(),
            $this->createConfigurableBundleTemplateRestResponseBuilder(),
        );
    }

    public function createConfigurableBundleTemplateSlotExpander(): ConfigurableBundleRestResourceExpanderInterface
    {
        return new ConfigurableBundleTemplateSlotExpander(
            $this->createConfigurableBundleTemplateSlotRestResourceBuilder(),
        );
    }

    public function createConfigurableBundleTemplateImageSetExpander(): ConfigurableBundleRestResourceExpanderInterface
    {
        return new ConfigurableBundleTemplateImageSetExpander(
            $this->createConfigurableBundleTemplateImageSetRestResourceBuilder(),
        );
    }

    public function createConfigurableBundleTemplateRestResponseBuilder(): ConfigurableBundleTemplateRestResponseBuilderInterface
    {
        return new ConfigurableBundleTemplateRestResponseBuilder(
            $this->getResourceBuilder(),
            $this->createConfigurableBundleTemplateRestResourceBuilder(),
            $this->createConfigurableBundleTranslator(),
        );
    }

    public function createConfigurableBundleTemplateRestResourceBuilder(): ConfigurableBundleTemplateRestResourceBuilderInterface
    {
        return new ConfigurableBundleTemplateRestResourceBuilder(
            $this->getResourceBuilder(),
        );
    }

    public function createConfigurableBundleTemplateSlotRestResourceBuilder(): ConfigurableBundleTemplateSlotRestResourceBuilderInterface
    {
        return new ConfigurableBundleTemplateSlotRestResourceBuilder(
            $this->getResourceBuilder(),
        );
    }

    public function createConfigurableBundleTemplateImageSetRestResourceBuilder(): ConfigurableBundleTemplateImageSetRestResourceBuilderInterface
    {
        return new ConfigurableBundleTemplateImageSetRestResourceBuilder(
            $this->getResourceBuilder(),
            $this->createConfigurableBundleMapper(),
        );
    }

    public function createConfigurableBundleMapper(): ConfigurableBundleMapperInterface
    {
        return new ConfigurableBundleMapper();
    }

    public function createConfigurableBundleTranslator(): ConfigurableBundleTranslatorInterface
    {
        return new ConfigurableBundleTranslator($this->getGlossaryStorageClient());
    }

    public function createOrderItemMapper(): OrderItemMapperInterface
    {
        return new OrderItemMapper();
    }

    public function createRestQuoteRequestItemExpander(): QuoteRequestItemExpanderInterface
    {
        return new QuoteRequestItemExpander(
            $this->getGlossaryStorageClient(),
        );
    }

    public function getConfigurableBundleStorageClient(): ConfigurableBundlesRestApiToConfigurableBundleStorageClientInterface
    {
        return $this->getProvidedDependency(ConfigurableBundlesRestApiDependencyProvider::CLIENT_CONFIGURABLE_BUNDLE_STORAGE);
    }

    public function getConfigurableBundlePageSearchClient(): ConfigurableBundlesRestApiToConfigurableBundlePageSearchClientInterface
    {
        return $this->getProvidedDependency(ConfigurableBundlesRestApiDependencyProvider::CLIENT_CONFIGURABLE_BUNDLE_PAGE_SEARCH);
    }

    public function getGlossaryStorageClient(): ConfigurableBundlesRestApiToGlossaryStorageClientInterface
    {
        return $this->getProvidedDependency(ConfigurableBundlesRestApiDependencyProvider::CLIENT_GLOSSARY_STORAGE);
    }
}
