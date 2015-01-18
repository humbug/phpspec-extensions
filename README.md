Humbug PHPSpec Extensions
=========================

A collection of extensions intended to allow for:
* Timing of specification and example execution
* Freeing of memory by removing specification properties after execution
* Filter/Reorder both specifications and examples using custom filters

An example phpspec.yml configuration:

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

This is for illustrative purposes. Filters are applied in the order listed
in the configuration, so technically the FastestFirstFilter would be undone
by the ShuffleFilter for specs in the above. All filters are applied not replaced.

These extensions are primarily targeted at Humbug, but are reusable/extendable for
any other purpose. Knock yourself out!