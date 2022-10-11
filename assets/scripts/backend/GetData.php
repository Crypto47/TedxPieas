<!-- xtgIT/VwNN9/jPIlF/rm794/ePw4y -->
<!-- tedx.pieas.edu\xtgIT\VwNN9\jPIlF\rm794\ePw4y\g9n6VP0nSQA8fqAMEZff.csv -->

<style>
	#tedx-members-table {
		border-collapse: collapse;
	}

	#tedx-members-table th, td {
		border: 1px solid #000000;
		padding: 8px;
		min-width: 180px;
	}
</style>

<?php
$USERNAME = "";
$PASSWORD = "";
?>

<FORM NAME="form1" METHOD="POST" ACTION="GetData.php">
	<LABEL for="USERNAME" class="col-md-3">USERNAME:</LABEL>
	<INPUT TYPE="TEXT" VALUE="<?PHP print $USERNAME;?>" ID="USERNAME" NAME="USERNAME">
	<LABEL for="PASSWORD" class="col-md-3">PASSWORD:</LABEL>
	<INPUT TYPE="PASSWORD" VALUE="<?PHP print $PASSWORD;?>" ID="PASSWORD" NAME="PASSWORD">
	<INPUT TYPE="Submit" class="btn btn-primary" Name="Submit1" VALUE="Login">
	<INPUT TYPE="Submit" class="btn btn-primary" Name="Submit2" VALUE="Logout">
	<?php
	if (isset($_POST['Submit2']) && $_POST['Submit2'] == 'Logout') {
		$USERNAME = "";
		$PASSWORD = "";
	}
	if (isset($_POST['Submit1']) && $_POST['Submit1'] == 'Login') {
		$USERNAME = $_POST['USERNAME'];
		$PASSWORD = $_POST['PASSWORD'];
		writeMsg();
	}

	function writeMsg() {
		print '<br><br>';
		if ($_POST['USERNAME'] == 'mrfaizanjawed' && $_POST['PASSWORD'] == 'tedxwhatsyourwhypieas') {
			$myfile = fopen("xtgIT/VwNN9/jPIlF/rm794/ePw4y/g9n6VP0nSQA8fqAMEZff.csv", "r");
			fseek($myfile, 0);
			$line = fgets($myfile);
			$line = explode("<empty>", $line);
			$total_columns = count($line);
			print '<table id="tedx-members-table">';
			print '<tr>';
			for($i = 0; $i < $total_columns; $i++) {
				print '<th>'.$line[$i].'</th>';
			}
			print '</tr>';
			while(!feof($myfile)) {
				$line = fgets($myfile);
				$line = explode("<empty>", $line);
				if(count($line) == $total_columns) {
					print '<tr>';
					for($i = 0; $i < $total_columns; $i++) {
						print '<td>'.$line[$i].'</td>';
					}
					print '</tr>';
				}
			}
			print '</table>';
			fclose($myfile);
		} else {
			print 'Login Attempt Failed';
		}
	}
	?>
</FORM>
