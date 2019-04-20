<?php
session_start();
/*
Program: DB.php
Developer: Andy Lam Yan Yu (andylamyy@gmail.com)
Date: 2010/06/22
Description: 資料庫連線專用CLASS specific for DB link class
Version: 1.0.5
*/

class DB
{
	var $DB_HOST;		//資料庫主機位置DB hosting location
	var $DB_USER;		//資料庫的使用帳號DB account
	var $DB_PASSWORD;	//資料庫的使用密碼DB password
	var $DB_NAME;		//資料庫名稱DB name
	var $DB_LANGUAGE;	//資料庫使用語系DB language applied
	
	var $conn;
	var $result;
	
	function DB($argDB_HOST = 'localhost', $argDB_USER = 'tnoaunimewb9aenr', $argDB_PASSWORD = '2A28C5TLYTYFq1ZkkX1I', $argDB_Language = 'utf8')
	{
		$this->DB_HOST = $argDB_HOST;
		$this->DB_USER = $argDB_USER;
		$this->DB_PASSWORD = $argDB_PASSWORD;
		$this->DB_NAME = $_SESSION['ncareDBno_lwj'];
		$this->DB_LANGUAGE = $argDB_Language;
		
		$this->connect();
	}
	
	function connect()
	{
		@ $this->conn = mysql_connect($this->DB_HOST, $this->DB_USER, $this->DB_PASSWORD);
		
		if (mysql_errno())
			$this->err_msg();
		else
			mysql_select_db($this->DB_NAME, $this->conn);
			
		if (mysql_errno())
			$this->err_msg();
		else
			$this->query("SET NAMES ".$this->DB_LANGUAGE);
	}
	
	function query($argQuery)
	{
		$this->result = mysql_query($argQuery, $this->conn);
		
		if (mysql_errno()) {
			$this->err_msg();
		}
	}
	
	function num_rows()
	{
		return mysql_num_rows($this->result);
	}
	
	function num_fields()
	{
		return mysql_num_fields($this->result);
	}
	
	function fetch_assoc()
	{
		return mysql_fetch_assoc($this->result);
	}
	
	function fetch_row()
	{
		return mysql_fetch_row($this->result);
	}
	
	function field_name($col)
	{
    	return mysql_field_name($this->result, $col);
  	}
	
	function free_result() {
		mysql_free_result($this->result);
	}
	
	function close()
	{
		mysql_close($this->conn);
	}
	
	function err_msg()
	{
		echo "[".mysql_errno()."]: ".mysql_error()."<br />";
		exit();
	}
	
}
?>