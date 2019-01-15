<?php

  // is_blank('abcd')
  // * validate data presence
  // * uses trim() so empty spaces don't count
  // * uses === to avoid false positives
  // * better than empty() which considers "0" to be empty
  function is_blank($value) {
    return !isset($value) || trim($value) === '';
  }

  // has_presence('abcd')
  // * validate data presence
  // * reverse of is_blank()
  // * I prefer validation names with "has_"
  function has_presence($value) {
    return !is_blank($value);
  }

  // has_length_greater_than('abcd', 3)
  // * validate string length
  // * spaces count towards length
  // * use trim() if spaces should not count
  function has_length_greater_than($value, $min) {
    $length = strlen($value);
    return $length > $min;
  }

  // has_length_less_than('abcd', 5)
  // * validate string length
  // * spaces count towards length
  // * use trim() if spaces should not count
  function has_length_less_than($value, $max) {
    $length = strlen($value);
    return $length < $max;
  }

  // has_length_exactly('abcd', 4)
  // * validate string length
  // * spaces count towards length
  // * use trim() if spaces should not count
  function has_length_exactly($value, $exact) {
    $length = strlen($value);
    return $length == $exact;
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  // * validate string length
  // * combines functions_greater_than, _less_than, _exactly
  // * spaces count towards length
  // * use trim() if spaces should not count
  function has_length($value, $options) {
    if(isset($options['min']) && !has_length_greater_than($value, $options['min'] - 1)) {
      return false;
    } elseif(isset($options['max']) && !has_length_less_than($value, $options['max'] + 1)) {
      return false;
    } elseif(isset($options['exact']) && !has_length_exactly($value, $options['exact'])) {
      return false;
    } else {
      return true;
    }
  }

  // has_inclusion_of( 5, [1,3,5,7,9] )
  // * validate inclusion in a set
  function has_inclusion_of($value, $set) {
  	return in_array($value, $set);
  }

  // has_exclusion_of( 5, [1,3,5,7,9] )
  // * validate exclusion from a set
  function has_exclusion_of($value, $set) {
    return !in_array($value, $set);
  }

  // has_string('nobody@nowhere.com', '.com')
  // * validate inclusion of character(s)
  // * strpos returns string start position or false
  // * uses !== to prevent position 0 from being considered false
  // * strpos is faster than preg_match()
  function has_string($value, $required_string) {
    return strpos($value, $required_string) !== false;
  }

  // has_valid_email_format('nobody@nowhere.com')
  // * validate correct format for email addresses
  // * format: [chars]@[chars].[2+ letters]
  // * preg_match is helpful, uses a regular expression
  //    returns 1 for a match, 0 for no match
  //    http://php.net/manual/en/function.preg-match.php
  function has_valid_email_format($value) {
    $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
    return preg_match($email_regex, $value) === 1;
  }

  // e.g. has_unique_page_menu_name('History')
  // *Validates uniqueness of pages.menu_name
  // *For new records, provide only the menu_name
  // *For existing records, provide current ID as second argument
  // e.g. has_unique_page_menu_name('History', 4)
  function has_unique_page_menu_name($menu_name, $current_id="0") {
    global $db;
    
    //Construct SQL query
    $sql = "SELECT * FROM pages ";
    $sql .= "WHERE menu_name='" . db_escape($db, $menu_name) . "' ";
    $sql .= "AND id != '" . db_escape($db, $current_id) . "'";

    //Retrieve all pages that match the query from the database
    $page_set = mysqli_query($db, $sql);
    $page_count = mysqli_num_rows($page_set);
    mysqli_free_result($page_set);

    return $page_count === 0;
  }

  function has_unique_admin_username($username, $current_id="0") {
    global $db;
    
    //Construct SQL query
    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
    $sql .= "AND id != '" . db_escape($db, $current_id) . "'";

    //Retrieve all admin users that match the query from the database
    $admin_set = mysqli_query($db, $sql);
    $admin_count = mysqli_num_rows($admin_set);
    mysqli_free_result($admin_set);

    return $admin_count === 0;
  }

  function validate_subject($subject) {
    $errors = [];

    //menu_name
    if(is_blank($subject['menu_name'])) {
        $errors[] = "Name cannot be blank.";
    } 
    elseif(!has_length($subject['menu_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must be between 2 and 255 characters.";
    }

    //position
    //Make sure we are working with an integer
    $position_int = (int) $subject['position'];
    if($position_int <= 0) {
        $errors[] = "Position must be greater than zero.";
    }
    if($position_int > 999) {
        $errors[] = "Position must be less than 999.";
    }

    //visible
    //Make sure we are working with a string
    $visible_str = (string) $subject['visible'];
    if(!has_inclusion_of($visible_str, ["0", "1"])) {
        $errors[] = "Visible must be true or false.";
    }
    
    return $errors;

  }

  function validate_page($page) {
    $errors = [];

    //subject_id
    if(is_blank($page['subject_id'])) {
        $errors[] = "Subject cannot be blank.";
    }

    //menu_name
    if(is_blank($page['menu_name'])) {
        $errors[] = "Name cannot be blank.";
    } 
    elseif(!has_length($page['menu_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must be between 2 and 255 characters.";
    }
    $current_id = $page['id'] ?? '0';
    if(!has_unique_page_menu_name($page['menu_name'], $current_id)) {
        $errors[] = "Menu name must be unique.";
    }

    //position
    //Make sure we are working with an integer
    $position_int = (int) $page['position'];
    if($position_int <= 0) {
        $errors[] = "Position must be greater than zero.";
    }
    if($position_int > 999) {
        $errors[] = "Position must be less than 999.";
    }

    //visible
    //Make sure we are working with a string
    $visible_str = (string) $page['visible'];
    if(!has_inclusion_of($visible_str, ["0", "1"])) {
        $errors[] = "Visible must be true or false.";
    }

    //content
    if(is_blank($page['content'])) {
        $errors[] = "Content cannot be blank.";
    }
    
    return $errors;

  }

  function validate_admin($admin, $options=[]) {

    $password_required = $options['password_required'] ?? true;

    $errors = [];

    //First name
    if(is_blank($admin['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } 
    elseif(!has_length($admin['first_name'], ['min' => 2, 'max' => 255])) {
      $errors[] = "First name must be between 2 and 255 characters.";
    }

    //Last name
    if(is_blank($admin['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } 
    elseif(!has_length($admin['last_name'], ['min' => 2, 'max' => 255])) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    }

    //Email
    if(is_blank($admin['email'])) {
      $errors[] = "Email cannot be blank.";
    } 
    elseif(!has_length($admin['email'], ['max' => 255])) {
      $errors[] = "Email must be less than 255 characters.";
    } 
    elseif(!has_valid_email_format($admin['email'])) {
      $errors[] = "Email must be a valid format.";
    }

    //Username 
    if(is_blank($admin['username'])) {
      $errors[] = "Username cannot be blank.";
    }
    elseif(!has_length($admin['username'], ['min' => 8 , 'max' => 255])) {
      $errors[] ="Username must be between 8 and 255 characters.";
    }
    elseif(!has_unique_admin_username($admin['username'], $admin['id'] ?? '0')) {
      $errors[] = "Username is already taken. Try another.";
    }

    //Password
    if($password_required) {
      if(is_blank($admin['password'])) {
        $errors[] = "Password cannot be blank.";
      } 
      elseif(!has_length($admin['email'], ['min' => 12, 'max' => 255])) {
        $errors[] = "Email must be between 12 and 255 characters";
      }  
      elseif (!preg_match('/[A-Z]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 uppercase letter";
      } 
      elseif (!preg_match('/[a-z]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 lowercase letter";
      } 
      elseif (!preg_match('/[0-9]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 number";
      } 
      elseif (!preg_match('/[^A-Za-z0-9\s]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 symbol";
      }
  
      if(is_blank($admin['confirm_password'])) {
        $errors[] = "Please confirm your password.";
      }
      elseif ($admin['password'] !== $admin['confirm_password']) {
        $errors[] = "Password and password confirmation must match.";
      }
    }

    return $errors;
  }

?>
