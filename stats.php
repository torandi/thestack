<?

include "includes.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sv" lang="sv">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>The Stack - Summering</title>
		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="js/jquery.flot.min.js" type="text/javascript"></script>
		<script src="js/jquery.flot.selection.min.js" type="text/javascript"></script>
		<link type="text/css" rel="stylesheet" href="bootstrap.min.css" />
		<link type="text/css" rel="stylesheet" href="stats.css" />
		<link type="text/css" rel="stylesheet" href="ui-lightness/jquery-ui-1.8.22.custom.css" />
		
		<link type="text/plain" rel="author" href="humans.txt" />
	</head>
	<body>
	<div class"row" style="margin-top: 10px">
		<div class="span12">
		<h2>Summering</h2>
		<p>
			<a href="index.php">Lägg till nya</a>
		</p>
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
					$result = Purchase::calculate_debts();
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

		<!-- BEGIN graphs -->
		<h4>Summa inköp per person över tid</h4>
		<div id="graph1" style="width:800px;height:400px;"></div>

		<script type="text/javascript" >
			var g1_data = [
<?
					$first_date = Purchase::first(array('@order' => 'date'))->timestamp() - 3600;
					$first_date *= 1000;

			foreach(Person::selection() as $person) {
?>
				{
					data: [[<?= $first_date ?>,0] <?
					$accum = 0;
					foreach(Purchase::selection(array('person_id' => $person->id, '@order'=>'date')) as $p){
						$accum += $p->sum;
						?> 
						, [<?= $p->timestamp()*1000 ?>, <?= $accum ?> ] <?
					}
?>
					],
					label: "<?= $person->name ?>",
					},
<?
			}
?>
			];
			var g1_options = {
				xaxis: { mode: "time", },
			};
			$.plot($("#graph1"), g1_data, g1_options);
		</script>

		<h4>Butiker</h4>
		<table class="table">
			<thead>
				<tr>
					<th>Butik</th>
					<th>Total inköpssumma</th>
					<th>Antal inköp</th>
					<th>Medelvärdesinköp</th>
				</tr>
			</thead>
			<tbody>
<?
					foreach(Store::selection() as $store) {
?>
					<tr>
						<td><?= $store->name ?></td>
						<td><?= $s = round(Purchase::sum('sum', array('store_id' => $store->id)),2) ?> kr</td>
						<td><?= $c = Purchase::count(array('store_id' => $store->id)) ?></td>
						<td><?= round($s / $c,2) ?> kr</td>
					</tr>
<?
					}
?>
			</tbody>
		</table>
		<h4>Inköp summerat per veckodag</h4>
		<div id="graph2" style="width:800px;height:400px;"></div>

		<script type="text/javascript" >
			var g2_data = [
				{
					data: [
<?
			//Build weekday summary:
			$day = array_fill(0, 7, 0);
			foreach(Purchase::selection() as $purchase) {
				$day[date('N',$purchase->timestamp()) - 1] += $purchase->sum;
			}

			for($i=0; $i<7; ++$i) {
?>
				[<?= $i ?>, <?= $day[$i] ?>],
<?
			}
?>
				]},
			];
			var g2_options = {
				xaxis: { ticks: [[0, "Måndag"], [1,"Tisdag"], [2,"Onsdag"], [3,"Torsdag"], [4,"Fredag"], [5,"Lördag"], [6,"Söndag"]] }
			};
			$.plot($("#graph2"), g2_data, g2_options);
		</script>
		</div>
	</div>
	</body>
</html>
