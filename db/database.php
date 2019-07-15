<?php 
	require_once 'tables.php';
	require_once 'functions.php';
	class DB {

		private $_ref;
		private static $_instance = NULL;

		private function DB(){
			try {
				$this->_ref = @pg_connect("host=localhost port=5432 dbname=bracathon user=swe328 password=pass1234");
				$this->migrateTable();
				echo "success";
			} catch (Exception $e) {
				$this->_ref = NULL;
			}
		}
		public static function connection(){
		if(self::$_instance == NULL){
			self::$_instance = new DB();
		}
		return self::$_instance;
		}

		public function getRefference(){
			return $this->_ref;
		}
		/*
			1.TABLE_SCHOOL
			2.TABLE_BATCH
			3.TABLE_STUDENT
			4.TABLE_ATTENDENCE
			5.TABLE_SUBJECT
			6.TABLE_EXAM
			7.TABLE_PERFORMENCE
			8.TABLE_DROPOUT
			9.TABLE_PROBLEMS
			10.TABLE_STUFF_CAT
			11.TABLE_ACCOUNT
		*/
		private function migrateTable(){
			try{
					pg_query($this->_ref,TABLE_SCHOOL);
					pg_query($this->_ref,TABLE_BATCH);
					pg_query($this->_ref,TABLE_STUDENT);
					pg_query($this->_ref,TABLE_ATTENDENCE);
					pg_query($this->_ref,TABLE_SUBJECT);
					pg_query($this->_ref,TABLE_EXAM);
					pg_query($this->_ref,TABLE_PERFORMENCE);
					pg_query($this->_ref,TABLE_DROPOUT);
					pg_query($this->_ref,TABLE_PROBLEMS);
					pg_query($this->_ref,TABLE_STUFF_CAT);
					pg_query($this->_ref,TABLE_ACCOUNT);
			}catch (Exception $e) {
				echo "failed to migrated with tables <br>";
			}
		}
		private function migrateFunction(){
			try {
				pg_query($this->_ref,GET_ALL_SCHOOL);
				pg_query($this->_ref,GET_ATTENDENCE);
				pg_query($this->_ref,GET_PERFORMENCE_student);
				pg_query($this->_ref,GET_PERFORMENCE_SCHOOL);
			} catch (Exception $e) {
				echo $e;
			}
		}
	}

 ?>