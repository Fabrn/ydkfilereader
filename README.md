# YDK File Reader

Simple PHP library that make `.ydk` file reading easier.

## Install using Composer

```shell
composer require fabrn/ydkfilereader
```

## Usage

In order to parse a specific YDK file, the `Ydk::readFile` will do the job :

```php
$ydk = Ydk::readFile('my_file.ydk');
```

Once you've done that, you get an `Ydk` instance that contains everything you need
to read the parsed file using **public properties** :

- author : if mentioned, the author can be retrieved
- mainDeck : list of card IDs of the main deck
- extraDeck : list of card IDs of the extra deck
- sideDeck : list of card IDs of the side deck

## Using a custom parser

If, for some reason, you need to use a custom YDK parser, you can create one :

```php
class MyYdkParser implements YdkParserInterface
{
    public function parse(string $ydk): array
    {
        // TODO : parse YDK content
    }
}
```

Then use the parser by giving it as a second argument to the `readFile` method :

```php
$ydk = Ydk::readFile('my_file.ydk', new MyYdkParser());
```

## Directly parse YDK content

The `Ydk` class' constructor takes some raw YDK content to parse. The `readFile` is
useful to get a file's content and construct the `Ydk` instance with it. But, if you
need to, you can give it yourself :

```php
$ydk = new Ydk($ydkContent);
```

Note that you can also use a custom parser using the constructor :

```php
$ydk = new Ydk($ydkContent, new MyYdkParser());
```

## License and legal notice

This package is available under [MIT license](https://choosealicense.com/licenses/mit/).