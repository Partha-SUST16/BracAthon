<?php 
	require_once 'tables.php';
	require_once 'procedures.php';
require_once 'functions.php';
	class DB {

		private $_ref;
		private static $_instance = NULL;

		private function DB(){
			try {
				$this->_ref = @pg_connect("host=localhost port=5432 dbname=mydb user=swe328 password=pass1234");
				$this->migrateTable();
				$this->migratePeocedure();
				$this->migrateFunction();

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
			3.TABLE_STUDENT
			4.TABLE_ATTENDENCE
			5.TABLE_SUBJECT
			6.TABLE_EXAM
			7.TABLE_PERFORMENCE
			8.TABLE_DROPOUT
			9.TABLE_PROBLEMS
			10.TABLE_TEACHER
			11.TABLE_PO
			12.TABLE_PO_TEACHER
			13.TABLE_BRANCH
			14.TABLE_BRANCH_PO
			15.TABLE_REGIONAL
			16.TABLE_DIVBRANCH
		*/
		private function migrateTable(){
			try{
					pg_query($this->_ref,TABLE_SCHOOL);
					pg_query($this->_ref,TABLE_STUDENT);
					pg_query($this->_ref,TABLE_ATTENDENCE);
					pg_query($this->_ref,TABLE_SUBJECT);
					pg_query($this->_ref,TABLE_EXAM);
					pg_query($this->_ref,TABLE_PERFORMENCE);
					pg_query($this->_ref,TABLE_DROPOUT);
					pg_query($this->_ref,TABLE_PROBLEMS);
					pg_query($this->_ref,TABLE_TEACHER);
					pg_query($this->_ref,TABLE_PO);
					pg_query($this->_ref,TABLE_PO_TEACHER);
					pg_query($this->_ref,TABLE_BRANCH);
					pg_query($this->_ref,TABLE_BRANCH_PO);
					pg_query($this->_ref,TABLE_REGIONAL);
					pg_query($this->_ref,TABLE_DIVBRANCH);

			}catch (Exception $e) {
				echo "failed to migrated with tables <br>";
			}
		}
		private function migrateFunction(){
			try {
				pg_query($this->_ref,GET_ALL_SCHOOL);
				pg_query($this->_ref,GET_ATTENDENCE);
				pg_query($this->_ref,GET_PERFORMENCE_student);
				pg_query($this->_ref,GET_DROPOUT_DETAILS);
				pg_query($this->_ref,GET_DROPOUT);
				pg_query($this->_ref,GET_STUDENTS);
				pg_query($this->_ref,GET_PERFORMENCE_school);
				pg_query($this->_ref,GET_ALL_PROBLEM);
			} catch (Exception $e) {
				echo $e;
			}
		}
		private function migratePeocedure(){
			try {
				pg_query($this->_ref,ADD_PROBLEM);
				pg_query($this->_ref,ADD_DROPOUT);
				pg_query($this->_ref,PERFORMENCE);
				pg_query($this->_ref,ATTENDENCE);
				pg_query($this->_ref,ADD_BRANCH);
				pg_query($this->_ref,ADD_PO);
				pg_query($this->_ref,ADD_TEACHER);
				pg_query($this->_ref,CREATE_REGIONAL);
				pg_query($this->_ref,CREATE_BRANCH);
				pg_query($this->_ref,CREATE_PO);
				pg_query($this->_ref,CREATE_TEACHER);
				pg_query($this->_ref,CREATE_STUDENT);
				pg_query($this->_ref,CREATE_SCHOOL);
			} catch (Exception $e) {
				echo $e;
			}
		}
	}

 ?>