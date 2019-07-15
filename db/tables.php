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
	const TABLE_BATCH = "CREATE TABLE IF NOT EXISTS batch(
			year int PRIMARY KEY,
			school_id int REFERENCES school(id)
	)";
	const TABLE_STUDENT = "CREATE TABLE IF NOT EXISTS student(
			id serial PRIMARY KEY,
			school_id int REFERENCES school(id),
			batch_id int REFERENCES batch(year),
			name varchar(50) NOT NULL,
			father_name varchar(50),
			mother_name varchar(50),
			address varchar(50)

	)";

	const TABLE_ATTENDENCE = "CREATE TABLE IF NOT EXISTS attendence(
			_date date,
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
			marks int ,
			status varchar(4),
			PRIMARY KEY (school_id,exam_id,student_id,subject_id)
	)";
	const TABLE_DROPOUT ="CREATE TABLE IF NOT EXISTS dropout(
		   school_id int REFERENCES school(id),
		   student_id int REFERENCES student(id),
		   batch_id int REFERENCES batch(year),
		   reason varchar(100),
		   PRIMARY KEY (school_id)
	)";
	const TABLE_PROBLEMS = "CREATE TABLE IF NOT EXISTS problem(
		   school_id int REFERENCES school(id),
		   catagory varchar(3),
		   details varchar(50),
		   issue_date date DEFAULT CURRENT_DATE,
		   is_approved bool NOT NULL DEFAULT FALSE,
		   PRIMARY KEY (school_id)
	)";
	const TABLE_STUFF_CAT = "CREATE TABLE IF NOT EXISTS stuff(
		   id serial PRIMARY KEY,
		   name varchar(15)
	)";
	const TABLE_ACCOUNT = "CREATE TABLE IF NOT EXISTS account(
		   id serial PRIMARY KEY,
		   name varchar(50) NOT NULL,
		   phone varchar(11) NOT NULL UNIQUE,
		   stuff_catagory int REFERENCES stuff(id)
	)";
 ?>