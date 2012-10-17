<table class="table">
	<thead>
		<tr>
			<th>Person</th>
			<th>Total matkostnad</th>
			<th>Totala utlägg</th>
			<th>Resultat</th>
		</tr>
	</thead>
	<tbody>
		<?
			foreach(Person::selection() as $person) {
				$r =  round($result['result'][$person->id],2);
				?>
				<tr>
					<td><?= $person->name ?></td>
					<td><?= round($result['participate'][$person->id],2) ?> kr</td>
					<td><?= round($result['payed'][$person->id],2) ?> kr</td>
					<td class="result <?= $r == 0 ? 'neutral' : ( $r < 0 ? 'negative' : 'positive' )?>"><?= $r ?></td>
				</tr>
				<?
			}
		?>
	</tbody>
</table>
