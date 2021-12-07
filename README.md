# Woodhouse

> “There is no surer foundation for a beautiful friendship than a mutual taste in literature.” ― P.G. Wodehouse 

Woodhouse is a very simple PHP library for managing users on a postgresql database. It allows you to create/delete users and given them table specific permissions. Woodhouse requires laravels illuminate/database package (there for works natively with laravel).

## Example
```
$woodhouse = (new Woodhouse);
$woodhouse->user()->create(($username = 'testing'), ($password = 'testing'));

// ... create a table

# Then give the user permissions to the table
$woodhouse->user()->allow(($username = 'testing'), ($table = 'table_name'));

# Or take the permission away again
$woodhouse->user()->deny(($username = 'testing'), ($table = 'table_name'));

# Delete the user
$woodhouse->user()->delete(($username = 'testing'));

# We can even test if a user has permissions to a table
$woodhouse->user()->has(($username = 'testing'), ($table = 'table_name'));

# We can also get a list of all our tables
$tables = $woodhouse->user()->table()->list();
foreach($tables as $table) {
    echo $table->tablename;
}
```