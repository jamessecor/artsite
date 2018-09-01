<?php
// editartwork.php
// author jrs
// 2018
include "utility.php";
global $db;
$contactsResultSet = selectQuery($db, "c_id, c_name, c_lastname", "contacts", "1", "1");
?>
<script language="JavaScript">
var contacts = [];


<?php
while($c = mysqli_fetch_assoc($contactsResultSet)) {
	$lastname = $c['c_lastname'];
	echo "contacts.push(\"$lastname\");";
}

?>

var h = $("#name").val();	
console.log(h);

$("#name")
	.keyup(function() {
		$(this).val("FLJDKFW");
		var value = $( this ).val();
		$( "#ppp" ).text( value );
	})
	.keyup();


/*
var nameBox = $("name").val();
alert(nameBox);
/*
if(confirm(contacts)) {
	alert("GO");
}
*/
</script>

<div>
<form id="selectcontact" method="post" action="">
	<table align="center">
		<tr>
			<td>
				<select id="contacts" name="contactSelect">
					<option value="">Select Contact</option>
					<?php
					$selected = "";
					if(isset($_POST['editcontact'])) {
						$selectedId = $_POST['contactSelect'];						
					}
					$counter = 0;
					mysqli_data_seek($contactsResultSet, 0);
					while($c = mysqli_fetch_assoc($contactsResultSet)) {
						if($selectedId == $c['c_id'])
							$selected = "selected";
						echo "<option value=\"$c[c_id]\" $selected>$c[c_name] $c[c_lastname]</option>";
						$selected = "";
						$counter++;
					}
					?>
				</select>
			</td>
			<!--<td>
				<input type="text" value="hereeeee" id="name"/>
			</td>-->
			<td><input type="submit" value="Edit" name="editcontact"/></td>
		</tr>
	</table>
</form>
<?php
if(isset($_POST['editcontact'])) {
?>
	<form id="updatecontact" method="post" action="">
	<table align="center">
		<tr>
			<td>Name</td>
			<td><input type="text" name="updatename" value="<?php echo "";?>"></td>
		</tr>
		<tr>
			<td>Last Name</td>
			<td><input type="text" name="updatelastname" value=""></td>
		</tr>
		<tr>
			<td>Year</td>
			<td><input type="text" name="updateyear" value=""></td>
		</tr>

	</table>
	</form>
<?php
}
?>

<p id="ppp"></p>
</div>