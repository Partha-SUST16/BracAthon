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

	const GET_PERFORMENCE_student = "CREATE OR REPLACE FUNCTION getPerformenceStudent(schoolid int,studentid int)
	RETURNS TABLE(student_id int,student_name varchar,exam_name varchar,stuject_name varchar,marks int,status varchar)
	LANGUAGE plpgsql AS $$
	BEGIN
		RETURN QUERY 
		SELECT performence.student_id,student.name,exam.type,subject.name,performence.marks,performence.status
		FROM performence
		LEFT JOIN school on school.id = performence.school_id
		LEFT JOIN exam on exam.id = performence.exam_id
		LEFT JOIN subject on subject.id = performence.subject_id
		LEFT JOIN student on student.id = performence.student_id
		WHERE performence.school_id = schoolid AND performence.student_id = studentid 
		GROUP BY performence.exam_id;
	END;
	$$";

	const GET_PERFORMENCE_SCHOOL = "CREATE OR REPLACE FUNCTION getPerformenceSchool(schoolid int,exam_id int)
	RETURNS TABLE(school_id int,school_name varchar,pass int)
	LANGUAGE plpgsql AS $$
	BEGIN 
		RETURN QUERY 
		SELECT performence.school_id,school.name,count(performence.status='PASS')
		FROM performence
		LEFT JOIN school ON school.id = performence.school_id
		WHERE schoolid=performence.school_id 
		AND performence.exam_id = exam_id;
	END;
	$$";
 ?>