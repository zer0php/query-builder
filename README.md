[![Build Status](https://travis-ci.com/zer0php/query-builder.svg?branch=master)](https://travis-ci.com/zer0php/query-builder)
[![Coverage Status](https://coveralls.io/repos/github/zer0php/query-builder/badge.svg?branch=master)](https://coveralls.io/github/zer0php/query-builder?branch=master)

# ZeroPHP Query Builder

```php
use Zero\Database\Query\QueryBuilder;

$query = new QueryBuilder();
$query->select('*')->from('table')->where(['id' => 1]); // SELECT * FROM table WHERE id = :id
```