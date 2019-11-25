# Blog

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

A simple blog package written for Laravel. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
composer require wingsline/blog
```

Clone the your theme or the default theme into the theme folder:

```bash
git clone https://github.com/wingsline/blog-theme.git theme
```

Configure the Laravel installation, making sure the cache driver supports tags and the database is configured.

The default admin url is `/admin`, customize with the `ADMIN_PREFIX` in your `.env` file.

Run the installer:

```bash
php artisan blog:install
```

The installer will publish the blog assets, default configuration files. Also it will migrate the database.


## Usage

You can access your blog admin interface at `https://example.com/admin`.

Default login:

* Username: `admin@example.com`
* Password: `admin123`

The admin uses [EasyMde](https://github.com/Ionaru/easy-markdown-editor) as the content editor with the [michelf/php-markdown](https://github.com/michelf/php-markdown) parser.

### Uploading images

For existing posts you can upload or drag and drop images (png, jpg) in the editor. 

For new posts, you need to save the post first before uploading an image.

Other filetype uploads currently are not supported.

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todo list.

## Security

If you discover any security related issues, please email wingsline@gmail.com instead of using the issue tracker.

## Credits

- [Arpad Olasz][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/wingsline/blog.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/wingsline/blog.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/wingsline/laravel-blog/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/219611248/shield

[link-packagist]: https://packagist.org/packages/wingsline/blog
[link-downloads]: https://packagist.org/packages/wingsline/blog
[link-travis]: https://travis-ci.org/wingsline/laravel-blog
[link-styleci]: https://styleci.io/repos/219611248
[link-author]: https://github.com/wingsline
[link-contributors]: ../../contributors
