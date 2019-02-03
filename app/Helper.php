<?php

/**
 * @param   $field_key
 *
 */
function is_key( $field_key ) {
    $key = strrpos( $field_key, '_Id' );
    return $key;
}

function is_pk( $field_key, $field_extra ) {
    if ( $field_key == 'PRI' and $field_extra == 'auto_increment' ) {
        return true;
    } else
        return false;
}

/**
 * [is_fk description]
 * @param  [type]  $fk [description]
 * @return boolean     [description]
 */
function is_fk( $fk ) {
    $key = strrpos( $fk, '_Id' );
    if ( $key ) {
        $fk_parts = explode('_Id', $fk);
        $table_parts = explode('_', $fk_parts['0']);
        if ( count( $table_parts ) > 1 ) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Return table name width foreign key
 * @param  string $fk Foreign Key name
 * @return string     Table name
 */
function get_table_by_fk( $fk ) {
    $fk_parts = explode('_Id', $fk);
    $table_parts = explode('_', $fk_parts['0']);
    $table_name = $table_parts['1'];
    return $table_name;
}

/**
 * [get_field_by_fk description]
 * @param  [type] $fk [description]
 * @return [type]     [description]
 */
function get_field_by_fk( $fk ) {
    $fk_parts = explode('_Id', $fk);
    $field_parts = explode('_', $fk_parts['0']);
    $field_name = $field_parts['1'];
    return $field_name . '_Id';
}

function normalize_attribute_name( $table_name ) {
    $table_name_parts = explode('_', $table_name);

    $attribute_name = '';

    foreach ($table_name_parts as $key => $part) {
        $attribute_name .= ucfirst($part);
    }

    return $attribute_name;
}

function from_camel_case($input) {
    preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
    $ret = $matches[0];
    foreach ($ret as &$match) {
        $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
    }
    return implode('_', $ret);
}

function name_has_many( $name ) {
    if ( substr($name, -1) == 'y' ) {
        return substr($name, 0, -1) . 'ies';
    } elseif ( substr($name, -1) == 's' or substr($name, -1) == 'x' or substr($name, -1) == 'z' or substr($name, -1) == 'ch' or substr($name, -1) == 'sh' ) {
        return substr($name, 0, -1) . 'es';
    } else {
        return $name . 's';
    }
}