<input type="hidden" id="reCreateAction" value="<?php echo CHtml::normalizeUrl(array('/org/cleanCreateAccount'));?>">
<table class="br_member_list">
				<thead>
					<tr>
						<th class="member_name">Emails</th>
						<th class="member_actions">Actions</th>
					</tr>
				</thead>

				<tbody>
<?php foreach ($emailData as $data) {?>

<tr>
	<td class="member_name"> <span><?php echo $data;?></span> </td>

	<td> <input type="button" class="reCreateAccount" onclick="createAccount(<?php echo json_encode($data);?>)" /> </td>
</tr>

<?php }?>

</tbody>
			</table>
<script>
function createAccount( email ){
	var link = $("#reCreateAction").val();

	$.post(link, {"email" : email}, function(json){
		if (json.state == 1) {
			window.location.reload();
		} else {
		}
	}, 'json').error(function(){
	});

}
</script>
