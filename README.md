Humbug PHPSpec Extensions
=========================

A collection of extensions intended to allow for:
* Timing of specification and example execution
* Freeing of memory by removing specification properties after execution
* Filter/Reorder both specifications and examples using custom filters

Available phpspec.yml options (see usable examples below):

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

This is for illustrative purposes only to show all options. See the usage examples
below for working combinations of options. Generally, you can write separate yml files
and load them selectively using phpspec's -c option. Filters are applied in the order listed
in the configuration, so technically the FastestFirstFilter would be undone
by the ShuffleFilter for specs in the above. All filters are supplied a referenced
array of either examples or specifications to play with.

These extensions are primarily targeted at Humbug, but are reusable/extendable for
any other purpose. Knock yourself out!

Installation
============

```json
require: {
   "padraic/phpspec-extensions": "dev-master"
}
```

Usage Examples
==============

Free memory after running a specification. This clears out any non phpspec properties
on the class which may improve performance somewhat:

```yaml
formatter.name: pretty
extensions:
- Humbug\PhpSpec\FreeMemoryExtension
```

Generate timing data for any timing related filters (run prior to activating
such filters):

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
Root them out by shuffling examples and specifications. Specification position in
a suite, or example position in a specification, will be randomly distributed.

```yaml
formatter.name: pretty
humbug.filtered_resource_loader.filters:
- Humbug\PhpSpec\Loader\Filter\Specification\ShuffleFilter
- Humbug\PhpSpec\Loader\Filter\Example\ShuffleFilter
extensions:
- Humbug\PhpSpec\FilteredResourceLoaderExtension
- Humbug\PhpSpec\FreeMemoryExtension
```