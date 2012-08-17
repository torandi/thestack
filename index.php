<?

include "includes.php";

$filter = $_GET;

if($filter) {
	$purchases = Purchase::selection($filter);
} else {
	$purchases = Purchase::selection();
}

function sort_link($text, $what) {
	return filter_link($text, array('@order'=>$what));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sv" lang="sv">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>The Stack</title>
		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="js/jquery.ui.js" type="text/javascript"></script>
		<script src="js/thestack.js" type="text/javascript"></script>
		<link type="text/css" rel="stylesheet" href="bootstrap.min.css" />
		<link type="text/css" rel="stylesheet" href="thestack.css" />
		<link type="text/css" rel="stylesheet" href="ui-lightness/jquery-ui-1.8.22.custom.css" />
		
		<link type="text/plain" rel="author" href="humans.txt" />
		<script type="text/javascript">
var persons = [
<? foreach(Person::selection() as $person) { 
	echo "'{$person->name}', ";
} ?>
	]
	</script>
	</head>
	<body>
		<div class"row" style="margin-top: 10px">
			<div class="span12">
				<h1>The Stack</h1>
				<p>
					<a href="stats.php">Statistik</a>
				</p>
				<div id="error" class="alert alert-error" style="display:none;"></div>
				<div id="msg" class="alert alert-success" style="display:none;"></div>
				<? if(!$filter) { ?>
				<div class="well">
					<form id="add" class="form-inline">

						<p class="input">
							<label for="person">Inköpt av:</label>
							<input type="text" name="person" id="person"/>
						</p>

						<p class="input">
							<label for="store">Butik:</label>
							<input type="text" name="store" id="store"/>
						</p>

						<p class="input">
							<label>Datum:</label>
							<input type="text"  name="year" id="year"/>
							-
							<input type="text" class="two_input" name="month" id="month"/>
							-
							<input type="text" class="two_input" name="day" id="day"/>
						</p>

						<p class="input">
							<label for="sum">Summa:</label>
							<input type="text" name="sum" id="sum"/> SEK
						</p>

						<p class="input">
							<label for="with">Med: (blankt == Alla)</label>
							<input type="text" name="with" id="with"/>
						</p>

						<p class="input">
							<label>&nbsp;</label>
							<input type="submit" value="Push" class="btn btn-primary"/>
						</p>
					</form>
					<p class="clear"/>
				</div>
				<? } else { ?>
				<p id="reset">
				<a href="index.php">Återställer filter</a>
				</p>
				<? } ?>
			<table class="table">
				<thead>
					<tr>
						<th><?=sort_link("Inköpt av", "persons.name")?></th>
						<th><?=sort_link("Butik", "stores.name")?></th>
						<th><?=sort_link("Datum", "date")?></th>
						<th>Med</th>
						<th><?=sort_link("Summa", "sum")?></th>
						<th></th>
					</tr>
				</thead>
				<tbody id="purchases">
					<?
					$tr_extra = "";
					foreach($purchases as $purchase) {
						include "partials/purchase.php";
					}
					?>
				</tbody>
			</table>
			</div>
		</div>
	</body>
</html>
