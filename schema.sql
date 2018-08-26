CREATE TABLE IF NOT EXISTS `student_subject` (
    id BIGINT (14) NOT NULL AUTO_INCREMENT,
    student_id INT (11) NULL,
    subject_id INT (11) NULL,
    
    PRIMARY KEY (id),
    
    FOREIGN KEY(student_id) REFERENCES students(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
     
    FOREIGN KEY (subject_id) REFERENCES subjects(id)
    ON DELETE CASCADE ON UPDATE CASCADE
    
    );

    SELECT DISTINCT(results.academic_year),results.term, results.subject_id, results.mark FROM results GROUP BY results.academic_year,results.term,results.subject_id,results.mark

/* SEARCH AND WHERE  */
    SELECT results.subject_id, results.mark FROM results WHERE term ='first_term' AND results.academic_year='2017' AND results.s_form='S2' GROUP BY results.subject_id,results.mark 
/* AVERAGE */
    SELECT AVG(mark) AS TOTAL FROM results WHERE results.academic_year='2017' AND results.term='first_term' AND results.s_form='S2'