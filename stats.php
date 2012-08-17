<?

include "includes.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sv" lang="sv">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>The Stack - Summering</title>
		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="js/jquery.ui.js" type="text/javascript"></script>
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
		</div>
	</div>
	</body>
</html>
