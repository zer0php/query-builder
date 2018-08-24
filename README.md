# ZeroPHP Query Builder

```php
use Zero\Database\Query\QueryBuilder;

$query = new QueryBuilder();
$query->select('*')->from('table')->where(['id' => 1]); // SELECT * FROM table WHERE id = 1
```