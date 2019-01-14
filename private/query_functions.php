<?php 

    /******************************  SUBJECTS ******************************/

    function find_all_subjects($options=[]) {
        global $db;

        //If nothing specified set false
        $visible = $options['visible'] ?? false;

        $sql = "SELECT * FROM subjects ";
        if($visible) {
            $sql .= "WHERE visible = true ";
        }
        $sql .= "ORDER BY position ASC";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

    function find_subject_by_id($id, $options=[]) {
        global $db;

        $visible = $options['visible'] ?? false;

        $sql = "SELECT * FROM subjects ";
        $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
        if($visible) {
            $sql .= "AND visible = true";
        }
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $subject = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $subject; //Returns an associative array
    }

    function insert_subject($subject) {
        global $db;

        $errors = validate_subject($subject);
        if(!empty($errors)) {
            return $errors;
        }

        $sql = "INSERT INTO subjects ";
        $sql .= "(menu_name, position, visible) ";
        $sql .= "VALUES (";
        $sql .= "'" . db_escape($db,$subject['menu_name']) . "', ";
        $sql .= "'" . db_escape($db,$subject['position']) . "', ";
        $sql .= "'" . db_escape($db,$subject['visible']) . "'";
        $sql .= ")";
        $result = mysqli_query($db, $sql);
        //For INSERT statements, $result is true/false
        if($result) {
            return true;
        } else {
            //INSERT failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function update_subject($subject) {
        global $db;

        $errors = validate_subject($subject);
        if(!empty($errors)) {
            return $errors;
        }
        
        //Construct SQL query
        $sql = "UPDATE subjects SET ";
        $sql .= "menu_name='" . db_escape($db,$subject['menu_name']) . "', ";
        $sql .= "position='" . db_escape($db,$subject['position']) . "', ";
        $sql .= "visible='" . db_escape($db,$subject['visible']) . "' ";
        $sql .= "WHERE id='" . db_escape($db,$subject['id']) . "' ";

        //Not strictly necessary, but will prevent overwritting 
        //other information in the event of an error
        $sql .= "LIMIT 1";  
        
        $result = mysqli_query($db, $sql);
        //For UPDATE statements, $result is true/false
        if($result) {
            return true;
        } else {
            //UPDATE failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function delete_subject($id) {
        global $db;

        $sql = "DELETE FROM subjects ";
        $sql .= "WHERE id='" . $id . "' ";
        $sql .= "LIMIT 1";
        echo $sql;
        $result = mysqli_query($db, $sql);

        //For DELETE statements, $result is true/false. 
        if($result) {
            return true;
        } else {
            //DELETE failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }



    /******************************  PAGES ******************************/



    function find_all_pages() {
        global $db;

        $sql = "SELECT * FROM pages ";
        $sql .= "ORDER BY subject_id ASC, position ASC";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

    function find_page_by_id($id, $options=[]) {
        global $db;

        $visible = $options['visible'] ?? false;

        $sql = "SELECT * FROM pages ";
        $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
        if($visible) {
            $sql .= "AND visible = true";
        }
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $page = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $page; //Returns an associative array
    }

    function insert_page($page) {
        global $db;

        $errors = validate_page($page);
        if(!empty($errors)) {
            return $errors;
        }

        $sql = "INSERT INTO pages ";
        $sql .= "(subject_id, menu_name, position, visible, content) ";
        $sql .= "VALUES (";
        $sql .= "'" . db_escape($db, $page['subject_id']) . "', ";
        $sql .= "'" . db_escape($db, $page['menu_name']) . "', ";
        $sql .= "'" . db_escape($db, $page['position']) . "', ";
        $sql .= "'" . db_escape($db, $page['visible']) . "', ";
        $sql .= "'" . db_escape($db, $page['content']) . "' ";
        $sql .= ")";
        $result = mysqli_query($db, $sql);
        //For INSERT statements, $result is true/false
        if($result) {
            return true;
        } else {
            //INSERT failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function update_page($page) {
        global $db;

        $errors = validate_page($page);
        if(!empty($errors)) {
            return $errors;
        }
        
        //Construct SQL query
        $sql = "UPDATE pages SET ";
        $sql .= "subject_id='" . db_escape($db, $page['subject_id']) . "', ";
        $sql .= "menu_name='" . db_escape($db, $page['menu_name']) . "', ";
        $sql .= "position='" . db_escape($db, $page['position']) . "', ";
        $sql .= "visible='" . db_escape($db, $page['visible']) . "', ";
        $sql .= "content='" . db_escape($db, $page['content']) . "' ";
        $sql .= "WHERE id='" . db_escape($db, $page['id']) . "' ";
        //Not strictly necessary, but will prevent overwritting 
        //other information in the event of an error
        $sql .= "LIMIT 1";  
        
        $result = mysqli_query($db, $sql);
        //For UPDATE statements, $result is true/false
        if($result) {
            return true;
        } else {
            //UPDATE failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function delete_page($id) {
        global $db;

        $sql = "DELETE FROM pages ";
        $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
        $sql .= "LIMIT 1";
        echo $sql;
        $result = mysqli_query($db, $sql);

        //For DELETE statements, $result is true/false. 
        if($result) {
            return true;
        } else {
            //DELETE failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function find_pages_by_subject_id($subject_id, $options=[]) {
        global $db;

        //If nothing specified set false
        $visible = $options['visible'] ?? false;

        $sql = "SELECT * FROM pages ";
        $sql .= "WHERE subject_id='" . db_escape($db, $subject_id) . "' ";
        if($visible) {
            $sql .= "AND visible = true ";
        }
        $sql .= "ORDER BY position ASC";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }



    /******************************  ADMINS ******************************/



    function find_all_admins() {
        global $db;

        $sql = "SELECT * FROM admins ";
        $sql .= "ORDER BY username ASC, id ASC";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

    function find_admin_by_id($id) {
        global $db;

        $sql = "SELECT * FROM admins ";
        $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $admin = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $admin; //Returns an associative array
    }

    function insert_admin($admin) {
        global $db;

        $errors = validate_admin($admin);
        if(!empty($errors)) {
            return $errors;
        }

        $sql = "INSERT INTO admins ";
        $sql .= "(subject_id, menu_name, position, visible, content) ";
        $sql .= "VALUES (";
        $sql .= "'" . db_escape($db, $page['subject_id']) . "', ";
        $sql .= "'" . db_escape($db, $page['menu_name']) . "', ";
        $sql .= "'" . db_escape($db, $page['position']) . "', ";
        $sql .= "'" . db_escape($db, $page['visible']) . "', ";
        $sql .= "'" . db_escape($db, $page['content']) . "' ";
        $sql .= ")";
        $result = mysqli_query($db, $sql);
        //For INSERT statements, $result is true/false
        if($result) {
            return true;
        } else {
            //INSERT failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function update_admin($admin) {

    }

    function delete_admin($admin) {

    }

?>