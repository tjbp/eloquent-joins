<?php

/*

This file is part of Eloquent Joins.

Eloquent Joins is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Eloquent Joins is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Eloquent Joins.  If not, see <http://www.gnu.org/licenses/>.

*/

namespace EloquentJoins\Relations;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\HasManyThrough as BaseHasManyThrough;

class HasManyThrough extends BaseHasManyThrough
{
    protected function setJoin(EloquentBuilder $query = null)
    {
        $query = $query ?: $this->query;

        return parent::setJoin($query instanceof EloquentBuilder ? $query->getQuery() : $query);
    }
}
