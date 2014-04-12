<form method="post" action="<?php echo 'http://'.$link.'/alfresco/faces/jsp/dashboards/container.jsp'; ?>" target="_blank">
<table width="610px;">
			<tbody>
			<tr class="setting_tr">
				<td class="setting_td_label"><label for="firstName" class="reg_text">Display Name</label></td>
				<td colspan="2" class="setting_td">
					<?php echo $user->name;?>
				</td>
			</tr>

			<tr class="setting_tr">
				<td class="setting_td_label"><label for="email" class="reg_text required">Email</label></td>
				<td colspan="2" class="setting_td">
					<?php echo $user->email;?>
				</td>
			</tr>

			<tr class="setting_tr">
				<td class="setting_td">
				<input type="hidden" name="ssi_token" value="<?php echo $token;?>">
				<input type="submit" value="Go Ahead" />
				</td>
			</tr>

			</tbody>
		</table>
		</form>
