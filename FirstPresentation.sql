
University/Tertiary 

 -Scholarship status (Govt, irish  government , ua,)
 -Student index number
 -School number
 -National ID Number




/* */
 tracking perfomance for all this student

 one off capture


 Secondary

 Year start ---
 /* Year of Registration */

Form year auto complete


/* ** */
STudent bank details

Banking details for the hostel

/* Students */
Termly for all the students


/* Term 3 */

Status ,

Repeating, continuing


/* SUbcounty */
Drop down

/* PLE */
P.7 PLE
S.4
S.6

/* + */
+267-recoded

/* Next of kind */


Irish Aid/Embassy
Government Quarter System

/* stream is not important */


/* Bank Details */
captured every time

-Life skills
-Career Guidance and Counselling

Results for Career Guidance (Yes or No)


-subjects result
-ccount details 

-Grade level

- NAtional ID number
Ba


liviung

-organizational email



/* Query Details */
-Generating reports
-General for applicant

Alumni
-FIlters for alumini
-offline reason


-System should be offline
-should should be  


Reasons for Dropout as a drop down menu


/* School materials for new students */

-student
/* tickets for complaints */

/* locking data for a given school */




/* **************************** */

/* Berna  ----- 26 June 2018

/* **************************** */

- Volley/Videos - 1



/* **************************** */

/* Edision  ----- 26 June 2018

/* **************************** */


/* sql queries */

       // SELECT COUNT(*) AS total, students.dist_name FROM students GROUP BY students.dist_name;
        // SELECT students.dist_name,COUNT(*) AS total FROM students WHERE students.current_state = 'continuing' GROUP BY students.dist_name
        // SELECT students.dist_name, students.current_state, COUNT(*) AS total FROM students GROUP BY students.dist_name,students.current_state
        // SELECT students.dist_name, students.level, COUNT(*) AS total FROM students GROUP BY students.dist_name,students.level
        // SELECT students.dist_name, students.level,students.current_state, COUNT(*) AS total FROM students GROUP BY students.dist_name,students.level,students.current_state
        // $schools = Student::selectRaw('students.dist_name, students.level, students.current_state, count(*)  Total')
        //                     ->groupBy('students.dist_name,students.level,students.current_state')
        //                     ->get()
        //                     ->toArray();

        // SELECT schools.school_name, COUNT(*) FROM schools LEFT JOIN students ON schools.id = students.school GROUP BY schools.school_name;
        // SELECT schools.school_name,schools.level, COUNT(*) FROM schools LEFT JOIN students ON schools.id = students.school GROUP BY schools.school_name,schools.level

        // SELECT schools.school_name,schools.level, students.s_form, students.gender, COUNT(*) FROM schools LEFT JOIN students ON schools.id = students.school GROUP BY schools.school_name,schools.level, students.s_form, students.gender;
        
        // SELECT schools.school_name,schools.level, students.s_form, students.gender, COUNT(*) FROM schools
        //  LEFT JOIN students ON schools.id = students.school WHERE students.school <> ''
        //   GROUP BY schools.school_name,schools.level, students.s_form, students.gender
