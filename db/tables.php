<?php 
	const host = "localhost";
	const port ="5432";
	const user = "swe328";
	const password = "pass1234";
	const dbname = "bracathon";

	/*
	TABLE SQL
	*/

	const TABLE_SCHOOL = "CREATE TABLE IF NOT EXISTS school(
			id serial PRIMARY KEY,
			name varchar(50) NOT NULL,
			area varchar(10) NOT NULL,
			_union varchar(20) NOT NULL,
			thana varchar(20) NOT NULL,
			region varchar(30) NOT NULL	
	)";
	
	const TABLE_STUDENT = "CREATE TABLE IF NOT EXISTS student(
			id serial PRIMARY KEY,
			school_id int REFERENCES school(id),
			name varchar(50) NOT NULL,
			father_name varchar(50),
			mother_name varchar(50),
			address varchar(50),
			phone varchar(11),
			batch varchar(4),
			gender varchar(1) NOT NULL
	)";

	const TABLE_ATTENDENCE = "CREATE TABLE IF NOT EXISTS attendence(
			_date date DEFAULT CURRENT_DATE,
			student_id int REFERENCES student(id),
			school_id int REFERENCES school(id),
			status int,
			PRIMARY KEY(_date,student_id)
	)";

	const TABLE_SUBJECT="CREATE TABLE IF NOT EXISTS subject(
			id serial PRIMARY KEY,
			name varchar(20)
	)";
	const TABLE_EXAM = "CREATE TABLE IF NOT EXISTS exam(
			id serial PRIMARY KEY,
			name varchar(30),
			full_mark int
	)";
	const TABLE_PERFORMENCE = "CREATE TABLE IF NOT EXISTS performence(
			school_id int REFERENCES school(id),
			exam_id int REFERENCES exam(id),
			student_id int REFERENCES student(id),
			subject_id int REFERENCES subject(id),
			grade varchar(4),
			PRIMARY KEY (school_id,exam_id,student_id,subject_id)
	)";
	const TABLE_DROPOUT ="CREATE TABLE IF NOT EXISTS dropout(
		   id serial PRIMARY KEY,
		   school_id int REFERENCES school(id),
		   student_id int REFERENCES student(id),
		   reason varchar(100)
	)";
	const TABLE_PROBLEMS = "CREATE TABLE IF NOT EXISTS problem(
		   id serial PRIMARY KEY,
		   school_id int REFERENCES school(id),
		   catagory varchar(7),
		   details varchar(50),
		   issue_date date DEFAULT CURRENT_DATE,
		   is_varified bool NOT NULL DEFAULT FALSE,
		   is_solved bool NOT NULL DEFAULT FALSE
	)";
	const TABLE_TEACHER = "CREATE TABLE IF NOT EXISTS teacher(
		   id serial PRIMARY KEY,
		   name varchar(50) NOT NULL,
		   phone varchar(11) NOT NULL UNIQUE,
		   school_id int REFERENCES school(id),
		   password varchar(40) NOT NULL,
		   gender varchar(1) NOT NULL,
		   address varchar(10)
	)";
	const TABLE_PO = "CREATE TABLE IF NOT EXISTS po(
		   id serial PRIMARY KEY,
		   name varchar(50) NOT NULL,
		   phone varchar(11) NOT NULL UNIQUE,
		   password varchar(40) NOT NULL,
		   gender varchar(1) NOT NULL,
		   address varchar(10)
	)";
	const TABLE_PO_TEACHER = "CREATE TABLE IF NOT EXISTS poteacher(
		   id serial PRIMARY KEY,
		   po_id int REFERENCES po(id),
		   teacher_id int REFERENCES teacher(id)
	)";
	const TABLE_BRANCH= "CREATE TABLE IF NOT EXISTS branch(
		   id serial PRIMARY KEY,
		   name varchar(50) NOT NULL,
		   phone varchar(11) NOT NULL UNIQUE,
		   password varchar(40) NOT NULL,
		   gender varchar(1) NOT NULL,
		   address varchar(10)
	)";
	const  TABLE_BRANCH_PO = "CREATE TABLE IF NOT EXISTS branchpo(
		   po_id int REFERENCES po(id),
		   branch_id int REFERENCES branch(id),
		   id serial PRIMARY KEY
	)";
	const TABLE_REGIONAL= "CREATE TABLE IF NOT EXISTS regional(
		   id serial PRIMARY KEY,
		   name varchar(50) NOT NULL,
		   phone varchar(11) NOT NULL UNIQUE,
		   password varchar(40) NOT NULL,
		   gender varchar(1) NOT NULL,
		   address varchar(10)
	)";
	const  TABLE_DIVBRANCH = "CREATE TABLE IF NOT EXISTS divbranch(
		   branch_id int REFERENCES branch(id),
		   regional_id int REFERENCES regional(id),
		   id serial PRIMARY KEY
	)";
 ?>