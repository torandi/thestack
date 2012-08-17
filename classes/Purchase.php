<?php
class Purchase extends ValidatingBasicObject {
	protected static function table_name() {
		return 'purchases';
	}

	protected static function default_order() {
		return 'id desc';
	}

	protected function validation_hooks() {

	}

	public function timestamp() {
		return strtotime($this->date);
	}

	public function by_name() {
		return $this->Person()->name;
	}

	public function with_name() {
		if($this->with_id == NULL) return "Alla";
		return $this->With()->name;
	}

	public function With() {
		if($this->with_id == NULL) return NULL;
		return Person::from_id($this->with_id);
	}

	public static function calculate_debts() {
		$total_participate = array();
		$total_payed = array();

		$persons = Person::selection();

		foreach($persons as $p) {
			$total_participate[$p->id] = 0;
			$total_payed[$p->id] = 0;
		}

		$total_num_persons = count($persons);


		foreach(Purchase::selection(array('resolved' => false)) as $purchase) {
			$num_persons = ($purchase->with_id == NULL) ? $total_num_persons : 2;
			$each_sum = $purchase->sum / $num_persons;
			if($purchase->with_id == NULL) {
				foreach($persons as $p) {
					$total_participate[$p->id] += $each_sum;
				}
			} else {
				$total_participate[$purchase->person_id] += $each_sum;
				$total_participate[$purchase->with_id] += $each_sum;
			}

			$total_payed[$purchase->person_id] += $purchase->sum;
		}

		$result = array();
		foreach($persons as $p) {
			$result[$p->id] = $total_payed[$p->id] - $total_participate[$p->id];
		}

		return array(
			'participate' => $total_participate,
			'payed' => $total_payed,
			'result' => $result
		);
	}
}
