<?php
/**
 * Humbug
 *
 * @category   Humbug
 * @package    Humbug
 * @copyright  Copyright (c) 2015 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/padraic/humbug/blob/master/LICENSE New BSD License
 */

namespace Humbug\PhpSpec;

use Humbug\PhpSpec\Loader\FilteredResourceLoader;
use PhpSpec\Extension\ExtensionInterface;
use PhpSpec\ServiceContainer;

class FilteredResourceLoaderExtension implements ExtensionInterface
{

    /**
     * @param ServiceContainer $container
     */
    public function load(ServiceContainer $container)
    {
        $container->setShared('loader.resource_loader', function (ServiceContainer $c) {
            $filters = $c->getParam('humbug.filtered_resource_loader.filters');
            $filteredResourceLoader = new FilteredResourceLoader($c->get('locator.resource_manager'));
            if (null !== $filters && is_array($filters)) {

                foreach ($filters as $class) {
                    $filter = new $class;

                    if (($class === 'Humbug\PhpSpec\Loader\Filter\Specification\FastestFirstFilter'
                    || $class === 'Humbug\PhpSpec\Loader\Filter\Example\FastestFirstFilter')
                    && null !== $c->getParam('humbug.time_collector.target')) {
                        $filter->setLoggerFile($c->getParam('humbug.time_collector.target'));
                    }

                    if (($class === 'Humbug\PhpSpec\Loader\Filter\Specification\IncludeOnlyFilter'
                    && null !== $c->getParam('humbug.filter.include_only.specs')) {
                        $filter->setLoggerFile($c->getParam('humbug.filter.include_only.specs'));
                    }

                    $filteredResourceLoader->addFilter($filter);
                }
            }
            return $filteredResourceLoader;
        });
    }
}
