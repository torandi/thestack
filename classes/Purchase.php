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
}
