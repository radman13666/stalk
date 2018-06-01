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