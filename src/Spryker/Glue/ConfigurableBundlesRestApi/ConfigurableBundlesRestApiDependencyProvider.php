<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ConfigurableBundlesRestApi;

use Spryker\Glue\ConfigurableBundlesRestApi\Dependency\Client\ConfigurableBundlesRestApiToConfigurableBundlePageSearchClientBridge;
use Spryker\Glue\ConfigurableBundlesRestApi\Dependency\Client\ConfigurableBundlesRestApiToConfigurableBundleStorageClientBridge;
use Spryker\Glue\ConfigurableBundlesRestApi\Dependency\Client\ConfigurableBundlesRestApiToGlossaryStorageClientBridge;
use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

/**
 * @method \Spryker\Glue\ConfigurableBundlesRestApi\ConfigurableBundlesRestApiConfig getConfig()
 */
class ConfigurableBundlesRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_CONFIGURABLE_BUNDLE_STORAGE = 'CLIENT_CONFIGURABLE_BUNDLE_STORAGE';

    /**
     * @var string
     */
    public const CLIENT_CONFIGURABLE_BUNDLE_PAGE_SEARCH = 'CLIENT_CONFIGURABLE_BUNDLE_PAGE_SEARCH';

    /**
     * @var string
     */
    public const CLIENT_GLOSSARY_STORAGE = 'CLIENT_GLOSSARY_STORAGE';

    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);
        $container = $this->addConfigurableBundleStorageClient($container);
        $container = $this->addConfigurableBundlePageSearchClient($container);
        $container = $this->addGlossaryStorageClient($container);

        return $container;
    }

    protected function addConfigurableBundleStorageClient(Container $container): Container
    {
        $container->set(static::CLIENT_CONFIGURABLE_BUNDLE_STORAGE, function (Container $container) {
            return new ConfigurableBundlesRestApiToConfigurableBundleStorageClientBridge(
                $container->getLocator()->configurableBundleStorage()->client(),
            );
        });

        return $container;
    }

    protected function addConfigurableBundlePageSearchClient(Container $container): Container
    {
        $container->set(static::CLIENT_CONFIGURABLE_BUNDLE_PAGE_SEARCH, function (Container $container) {
            return new ConfigurableBundlesRestApiToConfigurableBundlePageSearchClientBridge(
                $container->getLocator()->configurableBundlePageSearch()->client(),
            );
        });

        return $container;
    }

    protected function addGlossaryStorageClient(Container $container): Container
    {
        $container->set(static::CLIENT_GLOSSARY_STORAGE, function (Container $container) {
            return new ConfigurableBundlesRestApiToGlossaryStorageClientBridge(
                $container->getLocator()->glossaryStorage()->client(),
            );
        });

        return $container;
    }
}
