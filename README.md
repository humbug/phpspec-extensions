Humbug PHPSpec Extensions
=========================

A collection of extensions intended to allow for:
* Timing of specification and example execution
* Freeing of memory by removing specification properties after execution
* Filter/Reorder both specifications and examples using custom filters

An example phpspec.yml configuration (see usable examples below):

```yaml
formatter.name: pretty
humbug.filtered_resource_loader.filters:
- Humbug\PhpSpec\Loader\Filter\Specification\FastestFirstFilter
- Humbug\PhpSpec\Loader\Filter\Specification\ShuffleFilter
- Humbug\PhpSpec\Loader\Filter\Example\ShuffleFilter
humbug.time_collector.target: /tmp/phpspec.times.humbug.json
extensions:
- Humbug\PhpSpec\TimeCollectorExtension
- Humbug\PhpSpec\FilteredResourceLoaderExtension
- Humbug\PhpSpec\FreeMemoryExtension
```

This is for illustrative purposes to show all options. Filters are applied in the order listed
in the configuration, so technically the FastestFirstFilter would be undone
by the ShuffleFilter for specs in the above. All filters are applied not replaced.

These extensions are primarily targeted at Humbug, but are reusable/extendable for
any other purpose. Knock yourself out!

Usage Examples
==============

Free memory after running a specification. This clears out any non phpspec properties
on the class:

```yaml
formatter.name: pretty
extensions:
- Humbug\PhpSpec\FreeMemoryExtension
```

Generate timing data:

```yaml
formatter.name: pretty
humbug.time_collector.target: /tmp/phpspec.times.humbug.json
extensions:
- Humbug\PhpSpec\TimeCollectorExtension
- Humbug\PhpSpec\FreeMemoryExtension
```

Use the timing to run specifications fastest first:

```yaml
formatter.name: pretty
humbug.filtered_resource_loader.filters:
- Humbug\PhpSpec\Loader\Filter\Specification\FastestFirstFilter
humbug.time_collector.target: /tmp/phpspec.times.humbug.json
extensions:
- Humbug\PhpSpec\FilteredResourceLoaderExtension
- Humbug\PhpSpec\FreeMemoryExtension
```

Worried about any odd inter-example or inter-specification dependencies?
Root them out:

```yaml
formatter.name: pretty
humbug.filtered_resource_loader.filters:
- Humbug\PhpSpec\Loader\Filter\Specification\ShuffleFilter
- Humbug\PhpSpec\Loader\Filter\Example\ShuffleFilter
extensions:
- Humbug\PhpSpec\FilteredResourceLoaderExtension
- Humbug\PhpSpec\FreeMemoryExtension
```