<?php
namespace Base\Db;

class Table {
	
	protected $db;
	protected $table;
	private $sql;

	public function __construct($db){
		$this->db = $db;
	}
	
	public function fetchAll(){
		try{
			$sql = "SELECT * FROM {$this->table}";
			$consulta = $this->db->query($sql);
			return $consulta->fetchAll(\PDO::FETCH_OBJ);
		} catch (\PDOException $e){
			echo $e->getMessage();
		}
	}

	public function findBy($param, $value){
		try{
			$pstm = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$param} = :{$param}");
			$pstm->bindParam(":{$param}", $value);
			$pstm->execute();
			$res = $pstm->fetchAll(\PDO::FETCH_OBJ);
			return $res;
		} catch (\PDOException $e){
			echo $e->getMessage();
		}
	}
	
	public function find($param, $value){
		try{
			$pstm = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$param} = :{$param}");
			$pstm->bindParam(":{$param}", $value);
			$pstm->execute();
			$res = $pstm->fetchObject();
			
			return $res;
		} catch (\PDOException $e){
			echo $e->getMessage();
		}
	}
	
	public function delete($id){
		try{
			$pstm = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
			$pstm->bindParam(":id", $id);
			return $pstm->execute();
		} catch (\PDOException $e){
			echo $e->getMessage();
		}
	}
	
	public function insert(array $dados){
		try {
			$sql = $this->insertBuilder($dados);
			$pstm = $this->db->prepare($sql);
			foreach ($dados as $key => $value) {
				$array[':'.$key] = $value;
			}
			$pstm->execute($array);
                        return $this->db->lastInsertId();
		} catch (\PDOException $e) {
			echo $e->getMessage();
            return false;
		}
	}

	public function update(array $dados,$id){
		try {
			$sql = $this->updateBuilder($dados,$id);
			$pstm = $this->db->prepare($sql);
			foreach ($dados as $key => $value) {
				$array[':'.$key] = $value;
			}
			$array[':id'] = $id;

			return $pstm->execute($array);
		} catch (\PDOException $e) {
			echo $e->getMessage();
            return false;
		}
	}

    public function conte(){
        try{
            $sql = "SELECT count(id) as total FROM {$this->table}";
            $consulta = $this->db->query($sql);
            return $consulta->fetchObject();
        } catch (\PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function select(){
        $this->sql = "SELECT * FROM {$this->table}";
        return $this;
    }

    /***
     * @param nome da table que deseja unir
     * @param nome do parametro da table unida que deseja comparar
     * @param nome do parametro do table do model que deseja comparar
     * @param array com apelidos que deseja dar para os campos da table que deseja unir
     * @return $this
     */
    public function joinn($table, $param, $value, $apelidos){
        $from = '';
        foreach($apelidos as $key => $valor){
            $from .= ", {$table}.{$key} as {$valor}";
        }
        $this->sql = "SELECT {$this->table}.* {$from} FROM {$this->table} INNER JOIN {$table} ON {$table}.{$param} = {$this->table}.{$value}";
        return $this;
    }

    public function where($param, $value){
        $this->sql .= " WHERE {$param} = {$value}";
        return $this;
    }

    public function order($colum, $type = "DESC"){
        $this->sql .= " ORDER BY {$this->table}.{$colum} {$type}";
        return $this;
    }

    public function limit($limit, $offset = 0){
        $this->sql .= " LIMIT {$offset}, {$limit}";
        return $this;
    }

    public function execute(){
        try{
            #echo $this->sql;die;
            $consulta = $this->db->query($this->sql);
            return $consulta->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function executeObject(){
        try{
            #echo $this->sql;die;
            $consulta = $this->db->query($this->sql);
            return $consulta->fetchObject();
        } catch (\PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }


	private function insertBuilder(array $dados){
		$sql = "INSERT INTO {$this->table}";
		$key = array();
		$keyParam = array();
		foreach ($dados as $key => $value) {
			$param[] = $key;
			$keyParam[] = ":{$key}"; 
		}
		$keys = implode(',', $param);
		$keysParam = implode(',', $keyParam);
		$sql = $sql."({$keys}) VALUES($keysParam)";

		return $sql;
	}

	private function updateBuilder(array $dados, $id){
		$sql = "UPDATE {$this->table} SET";
		foreach ($dados as $key => $value) {
			$param[] = "{$key}=:{$key}";
		}
		$params = implode(",",$param);
		$sql = $sql." {$params} WHERE id = :id";
		return $sql;
	}
}
