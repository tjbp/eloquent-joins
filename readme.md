# Eloquent Joins

[![StyleCI](https://styleci.io/repos/45935955/shield?style=flat)](https://styleci.io/repos/45935955)
[![Build Status](https://travis-ci.org/tjbp/eloquent-joins.svg)](https://travis-ci.org/tjbp/eloquent-joins)
[![Total Downloads](https://poser.pugx.org/tjbp/eloquent-joins/d/total.svg)](https://packagist.org/packages/tjbp/eloquent-joins)
[![Latest Stable Version](https://poser.pugx.org/tjbp/eloquent-joins/v/stable.svg)](https://packagist.org/packages/tjbp/eloquent-joins)
[![Latest Unstable Version](https://poser.pugx.org/tjbp/eloquent-joins/v/unstable.svg)](https://packagist.org/packages/tjbp/eloquent-joins)
[![License](https://poser.pugx.org/tjbp/eloquent-joins/license.svg)](https://packagist.org/packages/tjbp/eloquent-joins)

This package allows you to simply call `$model->join($relation)` to join a Laravel Eloquent relationship's table on the keys declared by your relationship. Columns will be selected automatically,  and the joined records hydrated as models in the resulting collection. Laravel's Eloquent does support joins normally, but internally calls the underlying query builder, thereby expecting the name of a table and keys to join it on as arguments.

## Installation

Eloquent Joins is installable [with Composer via Packagist](https://packagist.org/packages/tjbp/eloquent-joins).

## Usage

### Use trait

Simply use EloquentJoins\ModelTrait in a model:

```php
namespace App;

use EloquentJoins\ModelTrait as EloquentJoinsModelTrait;

class User
{
    use EloquentJoinsModelTrait;

    protected $table = 'users';

    public function orders()
    {
        return $this->hasMany('\App\Order');
    }
}

$users = User::join('orders')->get();
```

In the above example, `$users` will contain a collection of all the User models with a corresponding Order model (since we've performed an inner join). Each corresponding Order model can be found in the `$orders` property on the User model (normally this would contain a collection of models with a matching foreign key).

You can string multiple `join()` calls, as well as use the other types of join normally available on the underlying query object (`joinWhere()`, `leftJoin()`, etc.).

### Licence

Eloquent Joins is free and gratis software licensed under the [GPL3 licence](https://www.gnu.org/licenses/gpl-3.0). This allows you to use Eloquent Joins for commercial purposes, but any derivative works (adaptations to the code) must also be released under the same licence.
