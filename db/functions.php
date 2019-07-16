<?php 
	
	const GET_ALL_SCHOOL = "CREATE OR REPLACE FUNCTION getAllSchools()
	RETURNS TABLE(id int,name varchar,area varchar,_union varchar,thana varchar,region varchar,student bigint)
	LANGUAGE plpgsql AS $$
	BEGIN
		RETURN QUERY 
		SELECT school.id,school.name,school.area,school._union,school.thana,school.region,count(student.school_id)
		FROM school 
		LEFT JOIN student ON school.id = student.school_id 
		GROUP BY school.id;
	END;$$
	";
	
	const GET_ATTENDENCE = "CREATE OR REPLACE FUNCTION getAttendence(studentid int,from_date date,to_date date)
	RETURNS TABLE(student_id int,student_name varchar,school_name varchar,_date date,status int)
	LANGUAGE plpgsql AS $$
	BEGIN
		RETURN QUERY 
		SELECT attendence.student_id,student.name,school.name,attendence._date,attendence.status
		FROM attendence 
		LEFT JOIN student on attendence.student_id = student.id
		LEFT JOIN school on attendence.school_id = school.id
		WHERE attendence.student_id = studentid AND
		attendence._date BETWEEN from_date AND to_date;
	END;
	$$";

	const GET_PERFORMENCE_student = "CREATE OR REPLACE FUNCTION getPerformenceStudent(studentid int)
	RETURNS TABLE(student_id int,student_name varchar,exam_name varchar,subject_name varchar,grade varchar)
	LANGUAGE plpgsql AS $$
	BEGIN
		RETURN QUERY 
		SELECT performence.student_id,student.name,exam.name,subject.name,performence.grade
		FROM performence
		LEFT JOIN school on school.id = performence.school_id
		LEFT JOIN exam on exam.id = performence.exam_id
		LEFT JOIN subject on subject.id = performence.subject_id
		LEFT JOIN student on student.id = performence.student_id
		WHERE performence.student_id = studentid 
		GROUP BY performence.exam_id;
	END;
	$$";


	const GET_DROPOUT_DETAILS = "CREATE OR REPLACE FUNCTION getDropoutDetails(schoolid int)
	RETURNS TABLE(student_id int,student_name varchar,school_name varchar,batch varchar,details varchar)
	LANGUAGE plpgsql AS $$
	BEGIN
		RETURN QUERY
		SELECT dropout.student_id,student.name,school.name,student.batch
		FROM dropout
		LEFT JOIN student ON dropout.student_id = student.id
		LEFT JOIN school ON dropout.school_id = school.id
		WHERE dropout.school_id = schoolid;
	END;
	$$";

	const GET_DROPOUT = "CREATE OR REPLACE FUNCTION getDropout(schoolid int)
	RETURNS TABLE(school_name varchar,student_number int)
	LANGUAGE plpgsql AS $$
	BEGIN
		RETURN QUERY
		SELECT school.name,COUNT(dropout.student_id)
		FROM dropout 
		LEFT JOIN school ON dropout.school_id =school.id
		WHERE dropout.school_id = schoolid;
	END;
	$$";

	const GET_STUDENTS = "CREATE OR REPLACE FUNCTION getStudents(schoolid int) 
	RETURNS TABLE(student_id int ,student_name varchar,gender varchar,batch varchar,school_name varchar)
	LANGUAGE plpgsql AS $$
	BEGIN
		RETURN QUERY
		SELECT student.id,student.name,student.gender,student.batch,school.name
		FROM student
		LEFT JOIN school ON school.id = student.school_id;
	END;
	$$";

	const GET_PERFORMENCE_school = "CREATE OR REPLACE FUNCTION getPerformenceSchool(schoolid int)
	RETURNS TABLE(school_id int,school_name varchar,exam_name varchar,A int,B int,C int)
	LANGUAGE plpgsql AS $$ 
	BEGIN
		SELECT performence.school_id,school.name,exam.name,COUNT(performence.grade='A'),COUNT(performence.grade='B'),COUNT(performence.grade='C')
		FROM performence
		LEFT JOIN school ON  performence.school_id = school.id
		LEFT JOIN exam ON performence.exam_id = exam.id
		WHERE schoolid = performence.school_id;
	END;
	$$";

	const GET_ALL_PROBLEM = "CREATE OR REPLACE FUNCTION getAllProblem()
		RETURNS TABLE (id int,school_id int,catagory varchar,details varchar,issue_date date,is_verified bool,is_solved bool)
		LANGUAGE plpgsql AS $$
		BEGIN
			SELECT * FROM problems;
		END;
		$$";
 ?>