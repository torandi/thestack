<?php
include "includes.php";

$action = request("action");

if(!$action) {
	echo "INVALID ACTION";
	exit;
}

unset($_REQUEST['action']);

if($action == "stores") {
	$stores = array();
	foreach(Store::selection(array('name:like' => "{$_REQUEST['term']}%")) as $store) {
		$stores[] = $store->name;
	}
	output_json($stores);
} else if($action == 'add') {
	$data = $_REQUEST['data'];
	$person = Person::one(array('name'=>$data['person']));
	if($person == NULL) {
		output_json(array('status'=>1, 'msg'=>"Kunde inte hitta {$data['person']}"));
	}
	unset($data['person']);
	$data['person_id'] = $person->id;

	if(!empty($data['with'])) {
		$with = Person::one(array('name'=>$data['person']));
		if($with == NULL) {
			output_json(array('status'=>1, 'msg'=>"Kunde inte hitta {$data['person']}"));
		}
		$with_id = $with->id;
	} else {
		$with_id = NULL;
	}
	unset($data['with']);
	$data['with_id'] = $with_id;

	$store = Store::one(array('name'=>$data['store']));
	if($store == NULL) {
		$store = new Store(array('name'=>$data['store']));
		$store->commit();
	}
	unset($data['store']);
	$data['store_id'] = $store->id;

	$purchase = new Purchase($data);
	$purchase->commit();

	$tr_extra = "style='display:none'";
	include "partials/purchase.php";
} else {
	echo "Invalid action!";
}
