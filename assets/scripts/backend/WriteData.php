<?php

$columns = array('full_name', 'gender', 'email', 'date_of_birth', 'profile_link', 'contact_number', 'cnic', 'organization', 'department', 'ambassador_code', 'question01', 'question02', 'question03', 'question04', 'question05', 'attended_before', 'heared_about_us', 'date_time');
$new_member_string = '';
$response = new stdClass();
$response->log = '';
$response->code = 0;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fp = file('xtgIT/VwNN9/jPIlF/rm794/ePw4y/g9n6VP0nSQA8fqAMEZff.csv');
    $id = count($fp);
    $response->log .= $id.PHP_EOL;
    $new_member_string = "{$id}<empty>";

    foreach($columns as $column) {
        $response->log .= $column.': '.isset($_POST[$column]).PHP_EOL;
        if(isset($_POST[$column])) {
            $response->log .= $column.PHP_EOL;
            // $response->log .= ($column=='cnic').PHP_EOL;
            if($column == 'cnic') {
                $response->log .= 'is_already_registered : '.(is_already_registered($_POST[$column])).PHP_EOL;
                if(is_already_registered($_POST[$column])) {
                    // $response->log .= 'already_registered'.PHP_EOL;
                    $response->code .= 1;
                    break;
                }
            }
            $new_member_string .= test_input($_POST[$column]).'<empty>';
        } else {
            $new_member_string .= '<empty>';
        }
    }
    if($response->code == 0) {
        $new_member_string = substr($new_member_string, 0, strlen($new_member_string) - 7).PHP_EOL;
        $response->log .= $new_member_string;
        if(file_put_contents('xtgIT/VwNN9/jPIlF/rm794/ePw4y/g9n6VP0nSQA8fqAMEZff.csv', $new_member_string, FILE_APPEND | LOCK_EX)) {
            $response->code .= 0;
        } else {
            $response->code .= 2;
        }
    }
    print json_encode($response);

    // $subject = "TEDxPIEAS Member-Registration Log";
    // $from = 'noreply@tedxpieas19.com';
    // $to = "abdulrehmankhan27061998@gmail.com";
    // $headers  = 'MIME-Version: 1.0'."\r\n";
    // $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
    // $headers .= 'From: '.$from."\r\n".
    //             'Reply-To: '.$from."\r\n".
    //             'X-Mailer: PHP/'.phpversion();
    // $string = json_encode($response);
    // $message = "console-log: {$string}";
    // mail($to, $subject, $message, $headers);

    exit(0);
}
header('Location: http://tedx.pieas.edu.pk/');
exit(0);

function is_already_registered($cnic) {
    $myfile = fopen("xtgIT/VwNN9/jPIlF/rm794/ePw4y/g9n6VP0nSQA8fqAMEZff.csv", "r");
    fseek($myfile, 0);
    $line = fgets($myfile);
    $line = explode("<empty>", $line);
    $total_columns = count($line);
    while(!feof($myfile)) {
        $line = fgets($myfile);
        $line = explode("<empty>", $line);
        if(count($line) == $total_columns) {
            if($line[7] == $cnic) {
                return true;
            }
        }
    }
    fclose($myfile);
    return false;
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>
