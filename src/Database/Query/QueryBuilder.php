<?php

namespace Zero\Database\Query;

class QueryBuilder {
    public function select($field) {
        return new Select($field);
    }
}