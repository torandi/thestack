<tr class="purchase_row" <?=$tr_extra?>>
	<td><?= filter_link($purchase->by_name(), array('person_id' => $purchase->person_id)) ?></td>
	<td><?= filter_link($purchase->Store()->name, array('store_id' => $purchase->store_id)) ?></td>
	<td><?= filter_link($purchase->date, array('date' => $purchase->date)) ?></td>
	<td><?= filter_link($purchase->with_name(), array('with_id' => $purchase->with_id)) ?></td>
	<td><?=$purchase->sum?> SEK</td>
	<td><a href="#" data-id="<?= $purchase->id ?>" class="delete_row">Radera</a></td>
</tr>
