<?php

namespace Zero\Database\Query;

interface QueryInterface {    
    public function toSql(ValueBinder $generator);
}