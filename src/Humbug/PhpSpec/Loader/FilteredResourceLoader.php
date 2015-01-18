<?php
/**
 * Humbug
 *
 * @category   Humbug
 * @package    Humbug
 * @copyright  Copyright (c) 2015 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/padraic/humbug/blob/master/LICENSE New BSD License
 */

namespace Humbug\PhpSpec\Loader;

use Humbug\PhpSpec\Loader\Filter\FilterInterface as BaseFilterInterface;
use Humbug\PhpSpec\Loader\Filter\Specification\FilterInterface as SpecFilterInterface;
use Humbug\PhpSpec\Loader\Filter\Example\FilterInterface as ExampleFilterInterface;
use PhpSpec\Loader\ResourceLoader;
use PhpSpec\Loader\Suite;
use PhpSpec\Loader\Node;
use PhpSpec\Util\MethodAnalyser;
use PhpSpec\Locator\ResourceManagerInterface;
use ReflectionClass;
use ReflectionMethod;

class FilteredResourceLoader extends ResourceLoader
{

    private $filters = [];

    /**
     * @var \PhpSpec\Locator\ResourceManagerInterface
     */
    private $manager;
    /**
     * @var \PhpSpec\Util\MethodAnalyser
     */
    private $methodAnalyser;

    /**
     * @param ResourceManagerInterface $manager
     */
    public function __construct(ResourceManagerInterface $manager, MethodAnalyser $methodAnalyser = null)
    {
        $this->manager = $manager;
        $this->methodAnalyser = $methodAnalyser ?: new MethodAnalyser();
    }

    /**
     * @param string       $locator
     * @param integer|null $line
     *
     * @return Suite
     */
    public function load($locator, $line = null)
    {
        $suite = new Suite();
        $specifications = [];
        foreach ($this->manager->locateResources($locator) as $resource) {
            if (!class_exists($resource->getSpecClassname()) && is_file($resource->getSpecFilename())) {
                require_once $resource->getSpecFilename();
            }
            if (!class_exists($resource->getSpecClassname())) {
                continue;
            }

            $reflection = new ReflectionClass($resource->getSpecClassname());

            if ($reflection->isAbstract()) {
                continue;
            }
            if (!$reflection->implementsInterface('PhpSpec\SpecificationInterface')) {
                continue;
            }

            $spec = new Node\SpecificationNode($resource->getSrcClassname(), $reflection, $resource);
            $examples = [];
            foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                if (!preg_match('/^(it|its)[^a-zA-Z]/', $method->getName())) {
                    continue;
                }
                if (null !== $line && !$this->lineIsInsideMethod($line, $method)) {
                    continue;
                }

                $example = new Node\ExampleNode(str_replace('_', ' ', $method->getName()), $method);

                if ($this->methodAnalyser->reflectionMethodIsEmpty($method)) {
                    $example->markAsPending();
                }

                $examples[] = $example;
            }

            foreach ($this->filters as $filter) {
                if ($filter instanceof ExampleFilterInterface) {
                    $filter->setSpecificationTitle($spec->getTitle());
                    $examples = $filter->filter($examples);
                }
            }

            foreach($examples as $example) {
                $spec->addExample($example);
            }
            unset($examples);

            $specifications[] = $spec;
        }

        foreach ($this->filters as $filter) {
            if ($filter instanceof SpecFilterInterface) {
                $specifications = $filter->filter($specifications);
            }
        }

        foreach ($specifications as $spec) {
            $suite->addSpecification($spec);
        }
        unset($specifications);

        return $suite;
    }

    public function addFilter(BaseFilterInterface $filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * @param int              $line
     * @param ReflectionMethod $method
     *
     * @return bool
     */
    private function lineIsInsideMethod($line, ReflectionMethod $method)
    {
        $line = intval($line);

        return $line >= $method->getStartLine() && $line <= $method->getEndLine();
    }
}