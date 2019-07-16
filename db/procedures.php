<?php 
	
	/*
	name varchar(50) NOT NULL,
			area varchar(10) NOT NULL,
			_union varchar(20) NOT NULL,
			thana varchar(20) NOT NULL,
			region varchar(30) NOT NULL	
	*/
	const CREATE_SCHOOL = "CREATE OR REPLACE PROCEDURE createSchool(
			name varchar(50),
			area varchar(10),
			_union varchar(20),
			thana varchar(20),
			region varchar(30)
		)
		LANGUAGE plpgsql AS $$
		BEGIN
			INSERT INTO school(name,area,_union,thana,region)
			VALUES (name,area,_union,thana,region);
		END;
		$$";

/*
			id serial PRIMARY KEY,
			school_id int REFERENCES school(id),
			name varchar(50) NOT NULL,
			father_name varchar(50),
			mother_name varchar(50),
			address varchar(50),
			phone varchar(11),
			batch varchar(4),
			gender varchar(1) NOT NULL
*/
	const CREATE_STUDENT = "CREATE OR REPLACE PROCEDURE createStudent(
			name varchar(50),
			school_id int,
			father_name varchar(50),
			mother_name varchar(50),
			address varchar(50),
			phone varchar(11),
			batch varchar(4),
			gender varchar(1)
		)
		LANGUAGE plpgsql AS $$
		BEGIN
			INSERT INTO student(school_id,name,father_name,mother_name,address,phone,batch,gender) VALUES (school_id,name,father_name,mother_name,address,phone,batch,gender);
		END;
		$$";

/*
			id serial PRIMARY KEY,
		   name varchar(50) NOT NULL,
		   phone varchar(11) NOT NULL UNIQUE,
		   school_id int REFERENCES school(id),
		   password varchar(40) NOT NULL,
		   gender varchar(1) NOT NULL,
		   address varchar(10)
*/
	const CREATE_TEACHER = "CREATE OR REPLACE PROCEDURE createTeacher(
			name varchar(50),
			_phone varchar(11),
			school_id int,
			password varchar(40),
			gender varchar(1),
			address varchar(10)
		)
		LANGUAGE plpgsql AS $$
		DECLARE
			exist int := 0;
		BEGIN
			SELECT COUNT(id) FROM teacher WHERE phone ILIKE _phone INTO exist;
			IF exist > 0 THEN 
			  RAISE NOTICE 'some information already taken';
			ELSE 
				INSERT INTO teacher(name,phone,school_id,password,gender,address) VALUES (name,_phone,school_id,password,gender,address);
			END IF;
		END;
		$$";
/*
		id serial PRIMARY KEY,
		   name varchar(50) NOT NULL,
		   phone varchar(11) NOT NULL UNIQUE,
		   password varchar(40) NOT NULL,
		   gender varchar(1) NOT NULL,
		   address varchar(10)
*/
		const CREATE_PO = "CREATE OR REPLACE PROCEDURE createPO(
			name varchar(50),
			_phone varchar(11),
			password varchar(40),
			gender varchar(1),
			address varchar(10)
		)
		LANGUAGE plpgsql AS $$
		DECLARE
			exist int := 0;
		BEGIN
			SELECT COUNT(id) FROM po WHERE phone ILIKE _phone INTO exist;
			IF exist > 0 THEN 
			  RAISE NOTICE 'some information already taken';
			ELSE 
				INSERT INTO po(name,phone,password,gender,address) VALUES (name,_phone,password,gender,address);
			END IF;
		END;
		$$";

		const CREATE_BRANCH = "CREATE OR REPLACE PROCEDURE createBranch(
			name varchar(50),
			_phone varchar(11),
			password varchar(40),
			gender varchar(1),
			address varchar(10)
		)
		LANGUAGE plpgsql AS $$
		DECLARE
			exist int := 0;
		BEGIN
			SELECT COUNT(id) FROM branch WHERE phone ILIKE _phone INTO exist;
			IF exist > 0 THEN 
			  RAISE NOTICE 'some information already taken';
			ELSE 
				INSERT INTO branch(name,phone,password,gender,address) VALUES (name,_phone,password,gender,address);
			END IF;
		END;
		$$";

		const CREATE_REGIONAL = "CREATE OR REPLACE PROCEDURE createRegional(
			name varchar(50),
			_phone varchar(11),
			password varchar(40),
			gender varchar(1),
			address varchar(10)
		)
		LANGUAGE plpgsql AS $$
		DECLARE
			exist int := 0;
		BEGIN
			SELECT COUNT(id) FROM regional WHERE phone ILIKE _phone INTO exist;
			IF exist > 0 THEN 
			  RAISE NOTICE 'some information already taken';
			ELSE 
				INSERT INTO regional(name,phone,school_id,password,gender,address) VALUES (name,_phone,school_id,password,gender,address);
			END IF;
		END;
		$$";

		const ADD_TEACHER = "CREATE OR REPLACE PROCEDURE addTeacher(
				po_id int,teacher_id int
			)
			LANGUAGE plpgsql AS $$
			BEGIN 
				INSERT INTO poteacher(po_id,teacher_id) VALUES (po_id,teacher_id);
			END;
			$$";
		const ADD_PO = "CREATE OR REPLACE PROCEDURE addPO(
				po_id int,branch_id int
			)
			LANGUAGE plpgsql AS $$
			BEGIN 
				INSERT INTO branchpo(po_id,branch_id) VALUES (po_id,branch_id);
			END;
			$$";
		const ADD_BRANCH = "CREATE OR REPLACE PROCEDURE addBranch(
				branch_id int,regional_id int
			)
			LANGUAGE plpgsql AS $$
			BEGIN 
				INSERT INTO divbranch(branch_id,regional_id) VALUES (branch_id,regional_id);
			END;
			$$";
		const ATTENDENCE = "CREATE OR REPLACE PROCEDURE giveAttendence(
				student_id int,school_id int,status int
		)
		LANGUAGE plpgsql AS $$
		BEGIN
			INSERT INTO attendence(student_id,school_id,status) VALUES (student_id,school_id,status); 
		END;
		$$";

		const PERFORMENCE = "CREATE OR REPLACE PROCEDURE givePerformence(
				school_id int , exam_id int,
				student_id int,subject_id int,
				grade varchar(4)
		)
		LANGUAGE plpgsql AS $$
		BEGIN
			INSERT INTO performence(school_id,exam_id,student_id,subject_id,grade)
			VALUES (school_id,exam_id,student_id,subject_id,grade);
		END;
		$$";

		const ADD_DROPOUT = "CREATE OR REPLACE PROCEDURE addDroput(student_id int,school_id int,reason varchar(100))
		LANGUAGE plpgsql AS $$
		BEGIN
			INSERT INTO dropout(school_id,student_id) VALUES (school_id,student_id);
		END;
		$$";

		const ADD_PROBLEM = "CREATE OR REPLACE PROCEDURE addProblem(
				school_id int,catagory varchar(7),
				details varchar(50)
		)
		LANGUAGE plpgsql AS $$
		BEGIN
			INSERT INTO problem(school_id,catagory,details)
			 VALUES (school_id,catagory,details);
		END;
		$$";

 ?>