# eloquent-model-userstamps

## Installing

This package can be installed using composer:

    composer require codiliateur/eloquent-model-userstamps

## Model trait

Add trait `Codiliateur\Userstamps\Models\HasUserstamps` into your model.

```
class YourModel extends Model
{
    use Codiliateur\Userstamps\Models\HasUserstamps;
    ...
}    
```

To customize userstamp column names, define constants `CREATED_BY`, `UPDATED_BY`, `DELETED_BY` in your specific model.

```
class YourModel extends Model
{
    use Codiliateur\Userstamps\Models\HasUserstamps;
    ...
    
    const CREATED_BY = 'creator_id';
    const UPDATED_BY = 'updater_id';
    const DELETED_BY = 'liquidator_id';
    
    ...
}    
```

## Migration helpers

This package automatically adds into `Blueprint` two helper methods `userstamps()` and `dropUserstamps()`

```
    // to add user stamp columns
    userstamps(bool $softDeletes = false, string $columnType = null, array $columnNames = null)

    // to drop user stamp columns
    dropUserstamps(bool $softDeletes = false, array $columnNames = null)
```

To add userstamp columns into your table add lines into `up()` of your migration.

For model without `SoftDeleting` trait

    $table->userstamps();

or the same with first argument 

    $table->userstamps(false);  // the same

And for model that used `SoftDeleting` trait

    $table->userstamps(true);

By default, added columns have `bigInteger` type. 

To ***change column type***, you can put `smallInteger`, `integer`, `bigInteger` or `uuid` into second argument `$columnType`.
For example:

    $table->userstamps(false, 'uuid');


To ***customize column names***, you can put array of names into third argument `$columnNames`. 

```
    $table->userstamps(false, null, [
        'creator_id',    // [0] instead of 'created_by'
        'updater_id',    // [1] instead of 'updated_by'
        'liquidator_id', // [2] instead of 'deleted_by'
    ]);
```

Don't forget add any arguments into `dropUserstams()` call.

## Configuring package

By default, for userstamp columns used names `created_by`, `updated_by` and `deleted_by` 
and these columns are type `bigInteger`. These column names and column type defined in package configuration file. 

You can publish this configuration file into yor project. For this run command:

    php artisan vendor:publish --provider="Codiliateur\Userstamps\UserstampsServiceProvider"

File `.\config\codiliateur\userstamps.php` will be published.

To change ***userstamp column's type*** use config option `column_type`. 

For example:

    'column_type' => 'uuid', // if user ID has 'uuid' type

There you can use `smallInteger`, `integer`, `bigInteger`, `uuid` values.

To change default ***userstamp column's names*** you must modify config option `columns`.

For example:

```
    'columns' => [
        'creator_id',    // [0] instead of 'created_by'
        'updater_id',    // [1] instead of 'updated_by'
        'liquidator_id', // [2] instead of 'deleted_by'
    ],
```
    