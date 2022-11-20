SELECT register_id,s.student_id,s.gender,s.name_la,s.surname_la, sr.student_code, school_year, year_no, classroom_id, create_date, last_update, user_update, register_status, (SELECT CONCAT('[', json_child, ']') AS classroom_json_str FROM(
SELECT GROUP_CONCAT('{', classroom_data, '}' SEPARATOR ',') AS json_child,course_id FROM
(SELECT CONCAT(
      '\"classroom_id\":\"', c.classroom_id, '\",', 
      '\"classroom_des\":\"', c.classroom_des, '\",',
      '\"class_no\":\"', c.class_no,'\"'
    ) AS classroom_data,course_id FROM tb_classroom c WHERE year_no=1 AND classroom_status = 1) AS classroom_json GROUP BY course_id) AS classroom_json_final WHERE classroom_json_final.course_id = s.course_id) 'class_data'
FROM tb_student_register sr INNER JOIN tb_student s ON sr.student_code = s.student_code WHERE sr.school_year='2022-2023' AND year_no = 1;