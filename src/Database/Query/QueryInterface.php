<?php

namespace Zero\Database\Query;

interface QueryInterface {    
    public function toSql(NamedValueBinder $generator);
}