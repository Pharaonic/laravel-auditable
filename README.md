
<p align="center"><a href="https://pharaonic.io" target="_blank"><img src="https://raw.githubusercontent.com/Pharaonic/logos/main/auditable.jpg"></a></p>

<p align="center">
<a href="https://github.com/Pharaonic/laravel-auditable" target="_blank"><img src="http://img.shields.io/badge/source-pharaonic/laravel--auditable-blue.svg?style=flat-square" alt="Source"></a> <a href="https://packagist.org/packages/pharaonic/laravel-auditable" target="_blank"><img src="https://img.shields.io/packagist/v/pharaonic/laravel-auditable?style=flat-square" alt="Packagist Version"></a><br>
<a href="https://laravel.com" target="_blank"><img src="https://img.shields.io/badge/Laravel->=6.0-red.svg?style=flat-square" alt="Laravel"></a> <img src="https://img.shields.io/packagist/dt/pharaonic/laravel-auditable?style=flat-square" alt="Packagist Downloads"> <img src="http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Source">
</p>




<h1 align="center">Laravel Auditable</h1>

## Install
Install the latest version using [Composer](https://getcomposer.org/):

```bash
$ composer require pharaonic/laravel-auditable
```
<br>

## Usage Steps

- [Create auditable columns on the table](#CS)
- [Auditable with the model](#US)
- [How to use](#HTU)
<br><br>


<a name="CS"></a>
### Create auditable columns on the table
###### Just add one of this lines to your Migration file.
```php
// created_by, created_at
// updated_by, updated_at
$table->auditable();

// created_by, created_at
// updated_by, updated_at
// deleted_by, deleted_at
$table->auditableWithSoftDeletes();
```
<br>

<a name="US"></a>
### Auditable with the model 
###### Auditable without SoftDeletes
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Pharaonic\Laravel\Audits\Auditable;

class Article extends Model
{
    use Auditable;
}

```
###### Auditable with SoftDeletes
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pharaonic\Laravel\Audits\Auditable;

class Article extends Model
{
    use Auditable;
    use SoftDeletes;
}

```
<br>

<a name="HTU"></a>

### How To Use
```php
// Creating
$article = Article::create(['title' => 'Moamen Eltouny']);
echo $article->created_at->isoFormat('LLLL');
echo $article->created_by->name;

// Updating
$article = Article::first();
echo $article->updated_at->isoFormat('LLLL');
echo $article->updated_by->name;

// Deleting (ONLY WITH SoftDeletes)
$article->delete();
$article = Article::withTrashed()->first();
echo $article->deleted_at->isoFormat('LLLL');
echo $article->deleted_at->name;
```
<br><br>


## License

[MIT license](LICENSE.md)
