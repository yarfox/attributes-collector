# annotations-collector

PHP8 annotation collector.

### Required

* php 8

### Install

```shell
composer require anhoder/annotations
```

### Usage

1. Install
2. Add php file `AnnotationConfig.php` to your project.

```php
class AnnotationConfig implements AnnotationConfigInterface
{

    public static function getAnnotationConfigs(): array
    {
        return [
            // The dirs need to be scanned
            'scanDirs' => [
                __NAMESPACE__ => __DIR__,
            ],
        ];
    }
}
```
3. Add annotation and annotation handler.

```php
// Annotation
#[Attribute(Attribute::TARGET_CLASS)]
class ClassAnnotation
{
    public const TEST = 'test';

    private string $test;

    public function __construct(string $test)
    {
        $this->test = $test;
    }
}

// AnnotationHandler
#[AnnotationHandler(ClassAnnotation::class)]
class ClassAnnotationHandler extends AbstractAnnotationHandler
{
    public function handle()
    {
        // Your logic.
        var_dump($this);
    }
}
```
4. Start scan.

```php
AnnotationHelper::scan();
```

### Example

[example](./tests)


