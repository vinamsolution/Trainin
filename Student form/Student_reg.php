<?php
 require_once ('MysqlDatabase.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title align="center">STUDENT REGISTRATION</title>
	<style>
		.btnbutton{
			background-color: #000000;
			color: white;
			padding: 10px 32px;
			text-align: center;
			margin: 4px 2px;
			font-size: 18px;
		}
		input,select,textarea{
			font-size: 14px;
		}
		
	</style>

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script type="text/javascript">
	
	$(function() {

  $("form[name='form']").validate({
    
    rules: {
      	name:{
			required:true
		},
		age: {
			required: true
		},
		address:{
			required:true
		},
		city:{
			required:true
		},
		education:{
			required:true
		},
		grade:{
			required:true
		}
    },
    messages: {
      name: { 
      	required:"Please enter your firstname"
	  },
	  age: {
	  	required:"Please enter your age"
	  },
	  address:{
	  	required:"address plzz"
	  },
	  city:{
	  	required:"plz enter"
	  },
	  education:{
	  	required:"plzz enter"
	  },
	  grade:{
	  	required:"plzz grade"
	  }
	},
	submitHandler: function(form) {
      form.submit();
    }
  });

    $("#btnsubmit").click(function() {     
      if($('input[type=radio][name=gender]:checked').length == 0)
      {
         alert("Please select atleast one gender");

         return false;
      }
      else
      {
      }      
    });
});
</script>
</head>
<body>
	
	<h1 align="center">STUDENT REGISTRATION</h1>
	
	<form method="post" id="form" name="form" action="list.php">
		<table align="center" cellpadding="20">
			<tr>
				<td colspan="2">NAME:</td>
				<td colspan="2"><input type="text" id="name" name="name" ></td>  
				<td><p id="nameerr"></p></td> 
			</tr>
			<tr>
				<td colspan="2">AGE:</td>
				<td colspan="2"><input type="number" id="age" name="age"></td>
			</tr>
			<tr>
				<td colspan="2">SEX:</td>
				<td rowspan="1"><input type="radio" value="Male" name="gender" id=gender > Male</td>
				<td rowspan="1"><input type="radio" value="Female" name="gender" id=gender>Female</td><label id=gender></label>
			</tr>
			<tr>
				<td colspan="2">CITY:</td>
				<td colspan="2">
					<select name="city" >
						<option value="">Select a city</option>
						<option value="Kannur">KANNUR</option>
						<option value="Calicut">KOZHIKODE</option>
						<option value="Kochi">KOCHI</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">ADDRESS:</td>
				<td colspan="2"><textarea name="address" rows="4" cols="20"></textarea></td>
			</tr>
			<tr>
				<td colspan="2">EDUCATION:</td>
				<td colspan="2">
					<select name="education" id="education" multiple>
						<option value="MCA">MCA</option>
						<option value="MBA">MBA</option>
						<option value="BCA">BCA</option>
						<option value="BBA">BBA</option>
						<option value="BSC Physics">BSC Physics</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">GRADE:</td>
				<td colspan="2">
					<select name="grade">
						<option value="">Select a grade..</option>
						<option value="A">A</option>
						<option value="B">B</option>
						<option value="C">C</option>
						<option value="D">D</option>
					</select>
				</td>
			</tr>
		</table>
	<p align="center"><button id=btnsubmit type="submit" class="btnbutton" name="btnsubmit">SUBMIT</button></p>
</form>
</body>
</html>