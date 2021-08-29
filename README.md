# annotations-collector (attributes-collector)

PHP8 attribute collector.

### Required

* php>=8

### Install

```shell
composer require anhoder/annotations-collector
```

### Usage

1. Install
2. Add php file `AttributeConfig.php` to your project.

```php
class AttributeConfig implements ConfigInterface
{
    #[ArrayShape(['scanDirs' => 'array'])]
    public static function getAttributeConfigs(): array
    {
        return [
            'scanDirs' => [
                __NAMESPACE__ => __DIR__,
            ],
        ];
    }
}
```
3. Add attribute and attribute handler.

```php
// Attribute
#[Attribute(Attribute::TARGET_CLASS)]
class ClassAttribute
{
    public const TEST = 'test';

    private string $test;

    public function __construct(#[ExpectedValues(valuesFromClass: ClassAttribute::class)] string $test)
    {
        $this->test = $test;
    }

    public function getTest(): string
    {
        return $this->test;
    }
}

// AttributeHandler
#[AttributeHandler(ClassAttribute::class)]
class ClassAttributeHandler extends AbstractHandler
{
    public function handle()
    {
        /**
         * @var $attribute ClassAttribute
         */
        var_dump($this);
        $attribute = $this->attribute;
        var_dump($attribute->getTest());
    }
}
```
4. Start scan.

```php
AttributeHelper::collect();
```

### Example

[example](./tests)


