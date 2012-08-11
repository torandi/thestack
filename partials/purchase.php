<tr class="purchase_row" <?=$tr_extra?>>
	<td><?=$purchase->by_name()?></td>
	<td><?=$purchase->Store()->name?></td>
	<td><?=$purchase->date?></td>
	<td><?=$purchase->with_name()?></td>
	<td><?=$purchase->sum?> SEK</td>
</tr>
