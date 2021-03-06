<?php
class ModelLocalisationCountry extends Model {
	public function getCountry($country_id) {
		$query = $this->db->query("SELECT * FROM country WHERE country_id = '" . (int)$country_id . "' AND status = '1'");
		
		return $query->row;
	}	
	
	public function getCountryISO2($country_id) {
		$query = $this->db->query("SELECT iso_code_2 FROM country WHERE country_id = '" . (int)$country_id . "' AND status = '1'");
		
		return $query->row['iso_code_2'];
	}
	
	public function getCountries() {
		$country_data = $this->cache->get('country.status');
		
		if (!$country_data) {
			$query = $this->db->query("SELECT * FROM country WHERE status = '1' ORDER BY name ASC");
	
			$country_data = $query->rows;
		
			$this->cache->set('country.status', $country_data);
		}

		return $country_data;
	}
}