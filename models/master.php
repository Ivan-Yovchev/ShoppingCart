<?php

namespace Models;

class MasterModel {

    protected $table;
    protected $limit;
    protected $db;

    public function __constuct($args = array()){
        $defaults = array(
            'limit' => 0
        );

        $args = array_merge($defaults, $args);

        if(!isset($args['table'])){
            die('Table not defined');
        }

        extract($args);

        $this->table = $table;
        $this->limit = $limit;

        $db_object = \Lib\Database::get_Instance();
        $this->db = $db_object::get_db();
    }

    public function get($username){
        return $this->find(array('where' => "username='" . $username . "'"));
    }

    public function add( $pairs ) {
        // Get keys and values separately
        $keys = array_keys( $pairs );
        $values = array();

        // Escape values, like prepared statement
        foreach( $pairs as $key => $value ) {
            $values[] = "'" . $this->db->real_escape_string( $value ) . "'";
        }

        $keys = implode( $keys, ',' );
        $values = implode( $values, ',' );

        $query = "insert into {$this->table}($keys) values($values)";

//    	var_dump($query);die();

        $this->db->query( $query );

        return $this->db->affected_rows;
    }

    public function delete( $id ) {
        $query = "DELETE FROM {$this->table} WHERE id=" . intval( $id );

        $this->db->query( $query );

        return $this->db->affected_rows;
    }

    public function update( $model ) {
        $query = "UPDATE " . $this->table . " SET ";

        foreach( $model as $key => $value ) {
            if( $key === 'id' ) continue;
            $query .= "$key = '" . $this->db->real_escape_string( $value ) . "',";
        }
        $query = rtrim( $query, "," );
        $query .= " WHERE id = " . $model['id'];
        $this->db->query( $query );

        return $this->db->affected_rows;
    }

    public function find($args = array()){
        $defaults = array(
            'table' => $this->table,
            'limit' => $this->limit,
            'where' => '',
            'columns' => '*'
        );

        $args = array_merge($defaults, $args);

        extract($args);

        $query = "SELECT {$columns} FROM {$table}";
        if(!empty($where)){
            $query .= " WHERE $where";
        }

        if(!empty($limit)){
            $query .= " LIMIT $limit";
        }

        $result_set = $this->db->query($query);
        $results = $this->process_results($result_set);

        return $results;
    }

    protected function process_results($result_set){
        $result = array();

        if(!empty($result_set) && $result_set->num_rows > 0){
            while($row = $result_set->fetch_assoc()){
                $result[] = $row;
            }
        }

        return $result;
    }
}