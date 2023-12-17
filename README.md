# eloquent-model-userstamps

## Installing

This package can be installed using composer:

    composer require codiliateur/eloquent-model-userstamps

## Use in migrations

This package automatically adds into `Blueprint` two helper methods `userstamps()` and `dropUserstamps()`

    // to add user stamp columns
    userstamps(bool $softDeletes = false, string $columnType = null, array $columnNames = null)

    // to drop user stamp columns
    dropUserstamps(bool $softDeletes = false, array $columnNames = null)

### Adding userstamps columns

```
    // Adding bigInteger userstamp columns
    $table->userstamps();       
    $table->userstamps(false);  // the same
    
    // Adding bigInteger userstamp columns for models with SoftDeletes trait
    $table->userstamps(true);
```    

### Type of userstamp columns

To change type of user stamp columns, you can put name of method
for creating column of required type into second argument.  

```
    // Adding uuid userstamp columns
    $table->userstamps(false, 'uuid');
```

### Customizing names of userstamp columns

If you want to customize userstamp column names, then use third argument. 

```
use Codiliateur\Userstamps\Support\UserstampNames;

    ...

    // Changing column names
    $table->userstamps(false, null, [
        UserstampNames::CREATED => 'creator_id',
        UserstampNames::UPDATED => 'updater_id',
        UserstampNames::DELETED => 'killer_id',
    ]);
```

## Use in models

Add trait `Codiliateur\Userstamps\Models\HasUserstamps` into your model.

```
use Codiliateur\Userstamps\Models\HasUserstamps;
...

class YourModel extends Model
{
    use HasUserstamps;
    ...
}    
```

If your user stamp columns have non-standard names, declare it in your model. 

```
use Codiliateur\Userstamps\Models\HasUserstamps;
...

class YourModel extends Model
{
    use HasUserstamps;
    ...
    
    const CREATED_BY => 'creator_id',
    const UPDATED_BY => 'updater_id',
    const DELETED_BY => 'killer_id',
    
    ...
}    
```
