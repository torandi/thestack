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
} else if($action == 'delete') {
	$purchase = Purchase::from_id($_REQUEST['id']);
	$result = array();
	if($purchase) {
		try {
			$purchase->delete();
			$result['status'] = 0;
			$result['msg'] = "Inköpet raderades";
		} catch (Exception $e) {
			$result['status'] = 1;
			$result['msg'] = "Kunde inte radera inköpet: " . $e->getMessage();
		}
	} else {
		$result['status'] = 1;
		$result['msg'] = "Kunde inte hitta inköp med id " . $_REQUEST['id'];
	}
	output_json($result);
} else if($action == 'add') {
	$data = $_REQUEST['data'];
	$person = Person::one(array('name'=>$data['person']));
	if($person == NULL) {
		output_json(array('status'=>1, 'msg'=>"Kunde inte hitta {$data['person']}"));
	}
	unset($data['person']);
	$data['person_id'] = $person->id;

	if(!empty($data['with'])) {
		$with = Person::one(array('name'=>$data['with']));
		if($with == NULL) {
			output_json(array('status'=>1, 'msg'=>"Kunde inte hitta {$data['with']}"));
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
