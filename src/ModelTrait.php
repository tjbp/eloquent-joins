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

namespace EloquentJoins;

use EloquentJoins\Builder;
use EloquentJoins\Relations\BelongsToMany;
use EloquentJoins\Relations\HasManyThrough;

trait ModelTrait
{
    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    /**
     * Define a has-many-through relationship.
     *
     * @param  string  $related
     * @param  string  $through
     * @param  string|null  $firstKey
     * @param  string|null  $secondKey
     * @param  string|null  $localKey
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function hasManyThrough($related, $through, $firstKey = null, $secondKey = null, $localKey = null)
    {
        $through = new $through;

        $firstKey = $firstKey ?: $this->getForeignKey();

        $secondKey = $secondKey ?: $through->getForeignKey();

        $localKey = $localKey ?: $this->getKeyName();

        return new HasManyThrough((new $related)->newQuery(), $this, $through, $firstKey, $secondKey, $localKey);
    }

    /**
     * Define a many-to-many relationship.
     *
     * @param  string  $related
     * @param  string  $table
     * @param  string  $foreignKey
     * @param  string  $otherKey
     * @param  string  $relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function belongsToMany($related, $table = null, $foreignKey = null, $otherKey = null, $relation = null)
    {
        // If no relationship name was passed, we will pull backtraces to get the
        // name of the calling function. We will use that function name as the
        // title of this relation since that is a great convention to apply.
        if (is_null($relation)) {
            $relation = $this->getBelongsToManyCaller();
        }

        // First, we'll need to determine the foreign key and "other key" for the
        // relationship. Once we have determined the keys we'll make the query
        // instances as well as the relationship instances we need for this.
        $foreignKey = $foreignKey ?: $this->getForeignKey();

        $instance = new $related;

        $otherKey = $otherKey ?: $instance->getForeignKey();

        // If no table name was provided, we can guess it by concatenating the two
        // models using underscores in alphabetical order. The two model names
        // are transformed to snake case from their default CamelCase also.
        if (is_null($table)) {
            $table = $this->joiningTable($related);
        }

        // Now we're ready to create a new query builder for the related model and
        // the relationship instances for the relation. The relations will set
        // appropriate query constraint and entirely manages the hydrations.
        $query = $instance->newQuery();

        return new BelongsToMany($query, $this, $table, $foreignKey, $otherKey, $relation);
    }
}
