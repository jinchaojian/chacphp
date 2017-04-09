<?php

class Mysql{
	protected $conn=false;
	protected $sql;

	public function __construct($config=array()){
		$host=isset($config['host'])?$config['host']:'localhost';
		$user=isset($config['user'])?$config['user']:'root';
		$password=isset($config['password'])?$config['password']:'';
		$dbname=isset($config['dbname'])?$config['dbname']:'';
		$port=isset($config['port'])?$config['port']:'3306';
		$charset=isset($config['charset'])?$config['charset']:'UTF-8';

		$this->conn=new PDO("mysql:host=$host:$port;dbname=$dbname",$user,$password) or die('Datebase connect error');
		$this->setChar($charset);
	}

	/*
	设置字符集
	 */
	private function setChar($charset){
		$sql='set names '.$charset;
		$this->query($sql);
	}

	/*
	 执行 SQL 语句，返回PDOStatement对象,可以理解为结果集
	 */
	public function query($sql){
		$this->sql=$sql;
		//将查询记录写入日志
		$str=$sql."[".date("Y-m-d H:i:s")."]".PHP_EOL;
		file_put_contents("log.txt",$str,FILE_APPEND);
		$result=$this->conn->query($this->sql);
		if(!$result){
			die($this->errorCode().':'.$this->errorInfo().'<br/>Error SQL statement is '.$this->sql.'<br/>');
		}
		return $result;
	}

	/*
	 执行一条 SQL 语句，并返回受影响的行数
	 */
	public function exec($sql){
		$result=$this->conn->exec($sql);
		//$result=$this->conn->lastInsertId();
		return $result;
	}



	/*
	获取第一行数据
	可以以关联数组访问也可以索引数组访问
	 */
	public function getOne($sql){
		$result=$this->query($sql);
		$row=$result->fetch();
		if($row){
			return $row;
		}else{
			return false;
		}
	}


	/*
	获取所有数据
	以二维数组的形式返回数据
	可以以关联数组访问也可以索引数组访问
	 */
	public function getAll($sql){
		$result=$this->query($sql);

		$list=array();
		$list=$result->fetchAll();
		return $list;
	}

	/*
	 获得每行首值
	 */






	/*
	获取跟数据库句柄上一次操作相关的 SQLSTATE
	 */
	public function errorCode(){
		return $this->conn->errorCode();
	}

	/*
	 返回最后一次操作数据库的错误信息
	 */
	public function errorInfo(){
		return $this->conn->errorInfo();
	}



}