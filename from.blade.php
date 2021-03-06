<!DOCTYPE html>
<html>
<head>
	<title>Insert data in MySQL database using Ajax</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div style="margin: auto;width: 60%;">
	<div class="alert alert-success alert-dismissible" id="success" style="display:none;">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
	</div>
	<form id="fupForm" name="form1" method="post">
		<div class="form-group">
			<label for="email">Product Name:</label>
			<input type="text" class="form-control" id="name" placeholder="Name" name="name">
		</div>
		<div class="form-group">
			<label for="email">Product Price:</label>
			<input type="text" class="form-control" id="price" placeholder="Price" name="price" onkeypress="return isNumber(event)">
		</div>
		<div class="form-group">
			<label for="email">Description:</label>
			<textarea class="form-control" id="desc" placeholder="Description..." name="desc"></textarea>
		</div>
		<div class="form-group">
			<label for="pwd">Qty:</label>
			<input type="number" class="form-control" id="qty" placeholder="Quantity" name="qty" min="0">
		</div>
		<div class="form-group" >
			<label for="pwd">Discount Type:</label>
			<select name="city" id="choice" class="form-control">
				<!-- <option value="">Select</option> -->
				<option value="1">Percentage</option>
				<option value="2">Rs.</option>
			</select>
		</div>
		<div class="form-group">
			<label for="pwd">Discount:</label>
			<input type="text" class="form-control" id="discount" placeholder="Discount" name="discount" onkeypress="return isNumber(event)">
		</div>
		<div class="form-group">
			<label for="pwd">Total:</label>
			<input type="text" class="form-control" id="total" placeholder="Total" name="total" disabled="">
		</div>
		<input type="button" name="save" class="btn btn-primary" value="Save to database" id="butsave">
		@csrf
	</form>
</div>
<script>
$(document).ready(function() {
	$('#butsave').on('click', function() {
		$("#butsave").attr("disabled", "disabled");
		var name = $('#name').val();
		var price = $('#price').val();
		var desc = $('#desc').val();
		var qty = $('#qty').val();
		var disc = $('#discount').val();
		var total = $('#total').val();
		if(name!="" && price!="" && qty!="" && desc!="" && disc!="" && total!=""){
			$.ajax({
				url: "/from_submit",
				type: "POST",
				data: {
					name: name,
					price: price,
					desc: desc,
					qty: qty,
					discount: disc,
					total: total			
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					if(dataResult.statusCode==200){
						$("#butsave").removeAttr("disabled");
						$('#fupForm').find('input:text').val('');
						$("#success").show();
						$('#success').html('Data added successfully !'); 						
					}
					else if(dataResult.statusCode==201){
					   alert("Error occured Hello !");
					}
					
				}
			});
		}
		else{
			alert('Please fill all the field !');
		}
	});
});
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}	
$("#qty").bind('keyup mouseup', function () {
    var price = $('#price').val();
    var qty = $('#qty').val();
    var total = parseFloat(price) * parseFloat(qty);
    $('#total').val(total);
});
	
$("#price").bind('keypress mouseup', function(){
	var price = $('#price').val();
    var qty = $('#qty').val();
    var total = parseFloat(price) * parseFloat(qty);
    $('#total').val(total);
});
$("#discount").change(function(){
	var choice = $('#choice').val();
	    var price = $('#price').val();
		//var disc = $('#discount').val()// / 100;
		var qty = $('#qty').val();
	if(choice=="1")
	{
		var disc = $('#discount').val() / 100;
    	var total = parseFloat(price) * parseFloat(qty);
		var d_total = total - (total * disc);
		$("#total").val(d_total); 
	}
	//if(choice=="2")
	else
	{
		// var price = $('#price').val();
		var disc = $('#discount').val();
		// var qty = $('#qty').val();
    	var total = parseFloat(price) * parseFloat(qty);
		var d_total = total - disc;
		$("#total").val(d_total);
	}
})
</script>
</body>
</html>


<!-- <!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form id="frm">
	@csrf
	<label>Name:</label>
	<input type="text" name="name" required="">
	<br>
	<label>price:</label>
	<input type="number" name="price" required="">
    <br>
	<label>description:</label>
	<input type="text" name="description" required="">
	<br>
	<label>oty:</label>
	<input type="number" name="qty" required="">
	<br>
	<label>discount Type:</label>
	<select>
		<option>price</option>
		<option>%</option>
	</select>
	<br>
	<label>Discount:</label>
	<input type="number" name="price" required="">
	<br>
	<label>Total:</label>
	<input type="number" name="total" required="">
	<br><br>

	<input type="submit" name="submit" id="fromSubmit">


</form>
</body>
	<script src="https://code.jquery.com/jquery-2.2.4.min.js" ></script>

<script type="text/javascript">
	jQuery('#frm').submit(function(e){
     e.preventDefault();
    // alert('test');
     jQuery.ajax({
     url:"{{url('from_submit')}}",
     data:jQuery('#frm').serialize(),
     type: 'post',
     success:function(result){
     	console.log(result);
     }
   
    });
	});
	
</script>
</html> -->