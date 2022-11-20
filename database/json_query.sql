SELECT CONCAT('[', better_result, ']') AS best_result FROM
(
SELECT GROUP_CONCAT('{', subj_json, '}' SEPARATOR ',') AS better_result FROM
(
SELECT 
    CONCAT
    (
      '"subj_name":'   , '"', subj_name   , '"', ',' 
      '"user_id":', '"', user_id,'"'
    ) AS subj_json
  FROM subjects
) AS more_json
) AS yet_more_json;




SELECT CONCAT('"users_num":"',
              (select COUNT(*) from users WHERE status = 1),'","class_num":"',
              (SELECT COUNT(*) FROM class_rooms WHERE status = 1),'","subj_num":"',
              (SELECT COUNT(*) FROM subjects WHERE status = 1),'","quiz_num":"',
              (SELECT COUNT(*) FROM quiz WHERE status = 1),'","question_num":"',
              (SELECT COUNT(*) FROM questions WHERE status = 1),'","dep_data":',
              
              (SELECT CONCAT('[', better_result, ']') AS best_result FROM
                (
                  SELECT GROUP_CONCAT('{', dep_json, '}' SEPARATOR ',') AS better_result FROM
                    (
                    SELECT 
                    CONCAT
                    (
                      '"dep_name":'   , '"', dep_name   , '"', ',' 
                      '"member":', '"', (SELECT COUNT(*) FROM users u WHERE u.dep_id = d.dep_id AND u.status = 1),'"'
                    ) AS dep_json
                    FROM departments d WHERE dep_status = 1
                    ) AS more_json
                )AS yet_more_json
             )
             
             )






SELECT classroom_id, classroom_des, year_no, class_no, course_id, classroom_status, (SELECT count(*) FROM tb_student_register WHERE classroom_id = c.classroom_id)'std_count',


SELECT CONCAT('[', better_result, ']') AS best_result FROM
(
SELECT GROUP_CONCAT('{', student, '}' SEPARATOR ',') AS better_result FROM
(
SELECT 
    CONCAT
    (
      '"student_id":"', s.student_id, '",', 
      '"student_code":"', sr.student_code, '",',
      '"gender":"', s.gender,'",',
      '"name_la":"', s.name_la,'",',
      '"surname_la":"', s.surname_la,'"' 
    ) AS student, s.course_id
  FROM tb_student_register sr INNER JOIN tb_student s ON sr.student_code = s.student_code
) AS student_json
) AS final_student_json;


FROM tb_classroom c WHERE year_no=1 AND course_id = 1;




SELECT course_id,CONCAT('[', json_child, ']') AS classroom_json_str FROM
(
SELECT GROUP_CONCAT('{', classroom_data, '}' SEPARATOR ',') AS json_child,course_id FROM
(SELECT CONCAT
    (
      '"classroom_id":"', c.classroom_id, '",', 
      '"classroom_des":"', c.classroom_des, '",',
      '"class_no":"', c.class_no,'"'
    ) AS classroom_data,course_id FROM tb_classroom c WHERE year_no=1 AND classroom_status = 1) AS classroom_json GROUP BY course_id) AS classroom_json_final;