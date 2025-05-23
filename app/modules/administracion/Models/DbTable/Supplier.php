<?php

/**
 * clase que genera la insercion y edicion  de register en la base de datos
 */
class Administracion_Model_DbTable_Supplier extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'suppliers';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un register y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data)
	{
		$is_legal_entity = $data['is_legal_entity'];
		$filling_date = $data['filling_date'];
		$counterparty_type = $data['counterparty_type'];
		$supplier_type = $data['supplier_type'];
		$company_name = $data['company_name'];
		$primary_email = $data['primary_email'];
		$economic_activity = $data['economic_activity'];
		$ciiu_code = $data['ciiu_code'];
		$commercial_activity = $data['commercial_activity'];
		$website = $data['website'];
		$main_address = $data['main_address'];
		$company_type = $data['company_type'];
		$identification_nit = $data['identification_nit'];
		$city = $data['city'];
		$state = $data['state'];
		$country = $data['country'];
		$landline = $data['landline'];
		$mobile_phone = $data['mobile_phone'];
		$trade_registry = $data['trade_registry'];
		$legal_representative_id = $data['legal_representative_id'];
		$rut_certificate = $data['rut_certificate'];
		$financial_statements = $data['financial_statements'];
		$tax_declaration = $data['tax_declaration'];
		$tax_declaration_year = $data['tax_declaration_year'];
		$tax_declaration_udate = $data['tax_declaration_udate'];
		$number_of_employees = $data['number_of_employees'];
		$company_date = $data['company_date'];
		$representative_name = $data['representative_name'];
		$document_type = $data['document_type'];
		$document_number = $data['document_number'];
		$document_issue_place = $data['document_issue_place'];
		$nationality = $data['nationality'];
		$document_issue_date = $data['document_issue_date'];
		$birthdate = $data['birthdate'];
		$birth_country = $data['birth_country'];
		$birth_city = $data['birth_city'];
		$birth_state = $data['birth_state'];
		$manages_public_funds = $data['manages_public_funds'];
		$public_recognition = $data['public_recognition'];
		$relationship_with_publicly_exposed_person = $data['relationship_with_publicly_exposed_person'];
		$resource_origin = $data['resource_origin'];
		$currency_type = $data['currency_type'];
		$liabilities = $data['liabilities'];
		$income = $data['income'];
		$other_income = $data['other_income'];
		$other_income_concept = $data['other_income_concept'];
		$foreign_transactions = $data['foreign_transactions'];
		$foreign_transactions_details = $data['foreign_transactions_details'];
		$foreign_financial_products = $data['foreign_financial_products'];
		$foreign_financial_products_details = $data['foreign_financial_products_details'];
		$declarations = $data['declarations'];
		$is_active = $data['is_active'];
		$subscription_expiry_date = $data['subscription_expiry_date'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$activity_type = $data['activity_type'];
		$keywords = $data['keywords'];
		$info_state = $data['info_state'];
		$assets = $data['assets'];
		$expenses = $data['expenses'];
		$equity = $data['equity'];
		$other_expenses = $data['other_expenses'];
		$income_origin = $data['income_origin'];
		$assets_total = $data['assets_total'];
		$liabilities_total = $data['liabilities_total'];
		$income_other = $data['income_other'];
		$eeff = $data['eeff'];
		$eeff_year = $data['eeff_year'];
		$eeff_udate = $data['eeff_udate'];
		$expenses_other = $data['expenses_other'];
		$income_total = $data['income_total'];
		$expenses_total = $data['expenses_total'];
		$utility = $data['utility'];
		$utility_total = $data['utility_total'];
		$financial_expenses = $data['financial_expenses'];
		$income_other_concept = $data['income_other_concept'];
		$industry = $data['industry'];
		$image = $data['image'];
		$policy = $data['policy'];
		$visibility_status = $data['visibility_status'];
		$facebook = $data['facebook'];
		$instagram = $data['instagram'];
		$twitter = $data['twitter'];
		$linkedin = $data['linkedin'];
		$slug = $data['slug'];
		$position = $data['position'];
		$ip = $data['ip'];
		$representative_name2 = $data['representative_name2'];
		$document_type2 = $data['document_type2'];
		$document_number2 = $data['document_number2'];
		$document_issue_place2 = $data['document_issue_place2'];
		$document_issue_date2 = $data['document_issue_date2'];
		$representative_birth_country = $data['representative_birth_country'];
		$representative_birth_country2 = $data['representative_birth_country2'];
		$legal_representative_id2 = $data['legal_representative_id2'];
		$certificate_issue_date = $data['certificate_issue_date'];
		$company_validity = $data['company_validity'];
		$company_validity2 = $data['company_validity2'];
		$registry_state = $data['registry_state'];
		$registry_city = $data['registry_city'];
		$incorporation_certificate = $data['incorporation_certificate'];
		$trade_registry_udate = $data['trade_registry_udate'];
		$incorporation_certificate_udate = $data['incorporation_certificate_udate'];
		$rut_certificate_udate = $data['rut_certificate_udate'];
		$brochure = $data['brochure'];
		$company_size = $data['company_size'];
		$company_size_certificate = $data['company_size_certificate'];
		$company_size_certificate_udate = $data['company_size_certificate_udate'];
		$foreign_currency = $data['foreign_currency'];
		$which_foreign_currency = $data['which_foreign_currency'];
		$foreign_products = $data['foreign_products'];
		$which_foreign_products = $data['which_foreign_products'];
		$tax_liabilities = $data['tax_liabilities'];
		$nontaxable_agent = $data['nontaxable_agent'];
		$supplier_soc_type = $data['supplier_soc_type'];
		$query = "INSERT INTO suppliers( is_legal_entity, filling_date, counterparty_type, supplier_type, company_name, primary_email, economic_activity, ciiu_code, commercial_activity, website, main_address, company_type, identification_nit, city, state, country, landline, mobile_phone, trade_registry, legal_representative_id, rut_certificate, financial_statements, tax_declaration, tax_declaration_year, tax_declaration_udate, number_of_employees, company_date, representative_name, document_type, document_number, document_issue_place, nationality, document_issue_date, birthdate, birth_country, birth_city, birth_state, manages_public_funds, public_recognition, relationship_with_publicly_exposed_person, resource_origin, currency_type, liabilities, income, other_income, other_income_concept, foreign_transactions, foreign_transactions_details, foreign_financial_products, foreign_financial_products_details, declarations, is_active, subscription_expiry_date, created_at, updated_at, activity_type, keywords, info_state, assets, expenses, equity, other_expenses, income_origin, assets_total, liabilities_total, income_other, eeff, eeff_year, eeff_udate, expenses_other, income_total, expenses_total, utility, utility_total, financial_expenses, income_other_concept, industry, image, policy, visibility_status, facebook, instagram, twitter, linkedin, slug, position, ip, representative_name2, document_type2, document_number2, document_issue_place2, document_issue_date2, representative_birth_country, representative_birth_country2, legal_representative_id2, certificate_issue_date, company_validity, company_validity2, registry_state, registry_city, incorporation_certificate, trade_registry_udate, incorporation_certificate_udate, rut_certificate_udate, brochure, company_size, company_size_certificate, company_size_certificate_udate, foreign_currency, which_foreign_currency, foreign_products, which_foreign_products, tax_liabilities, nontaxable_agent, supplier_soc_type) VALUES ( '$is_legal_entity', '$filling_date', '$counterparty_type', '$supplier_type', '$company_name', '$primary_email', '$economic_activity', '$ciiu_code', '$commercial_activity', '$website', '$main_address', '$company_type', '$identification_nit', '$city', '$state', '$country', '$landline', '$mobile_phone', '$trade_registry', '$legal_representative_id', '$rut_certificate', '$financial_statements', '$tax_declaration', '$tax_declaration_year', '$tax_declaration_udate', '$number_of_employees', '$company_date', '$representative_name', '$document_type', '$document_number', '$document_issue_place', '$nationality', '$document_issue_date', '$birthdate', '$birth_country', '$birth_city', '$birth_state', '$manages_public_funds', '$public_recognition', '$relationship_with_publicly_exposed_person', '$resource_origin', '$currency_type', '$liabilities', '$income', '$other_income', '$other_income_concept', '$foreign_transactions', '$foreign_transactions_details', '$foreign_financial_products', '$foreign_financial_products_details', '$declarations', '$is_active', '$subscription_expiry_date', '$created_at', '$updated_at', '$activity_type', '$keywords', '$info_state', '$assets', '$expenses', '$equity', '$other_expenses', '$income_origin', '$assets_total', '$liabilities_total', '$income_other', '$eeff', '$eeff_year', '$eeff_udate', '$expenses_other', '$income_total', '$expenses_total', '$utility', '$utility_total', '$financial_expenses', '$income_other_concept', '$industry', '$image', '$policy', '$visibility_status', '$facebook', '$instagram', '$twitter', '$linkedin', '$slug', '$position', '$ip', '$representative_name2', '$document_type2', '$document_number2', '$document_issue_place2', '$document_issue_date2', '$representative_birth_country', '$representative_birth_country2', '$legal_representative_id2', '$certificate_issue_date', '$company_validity', '$company_validity2', '$registry_state', '$registry_city', '$incorporation_certificate', '$trade_registry_udate', '$incorporation_certificate_udate', '$rut_certificate_udate', '$brochure', '$company_size', '$company_size_certificate', '$company_size_certificate_udate', '$foreign_currency', '$which_foreign_currency', '$foreign_products', '$which_foreign_products', '$tax_liabilities', '$nontaxable_agent', '$supplier_soc_type')";
		$res = $this->_conn->query($query);
		return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un register  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data, $id)
	{

		$is_legal_entity = $data['is_legal_entity'];
		$filling_date = $data['filling_date'];
		$counterparty_type = $data['counterparty_type'];
		$supplier_type = $data['supplier_type'];
		$company_name = $data['company_name'];
		$primary_email = $data['primary_email'];
		$economic_activity = $data['economic_activity'];
		$ciiu_code = $data['ciiu_code'];
		$commercial_activity = $data['commercial_activity'];
		$website = $data['website'];
		$main_address = $data['main_address'];
		$company_type = $data['company_type'];
		$identification_nit = $data['identification_nit'];
		$city = $data['city'];
		$state = $data['state'];
		$country = $data['country'];
		$landline = $data['landline'];
		$mobile_phone = $data['mobile_phone'];
		$trade_registry = $data['trade_registry'];
		$legal_representative_id = $data['legal_representative_id'];
		$rut_certificate = $data['rut_certificate'];
		$financial_statements = $data['financial_statements'];
		$tax_declaration = $data['tax_declaration'];
		$tax_declaration_year = $data['tax_declaration_year'];
		$tax_declaration_udate = $data['tax_declaration_udate'];
		$number_of_employees = $data['number_of_employees'];
		$company_date = $data['company_date'];
		$representative_name = $data['representative_name'];
		$document_type = $data['document_type'];
		$document_number = $data['document_number'];
		$document_issue_place = $data['document_issue_place'];
		$nationality = $data['nationality'];
		$document_issue_date = $data['document_issue_date'];
		$birthdate = $data['birthdate'];
		$birth_country = $data['birth_country'];
		$birth_city = $data['birth_city'];
		$birth_state = $data['birth_state'];
		$manages_public_funds = $data['manages_public_funds'];
		$public_recognition = $data['public_recognition'];
		$relationship_with_publicly_exposed_person = $data['relationship_with_publicly_exposed_person'];
		$resource_origin = $data['resource_origin'];
		$currency_type = $data['currency_type'];
		$liabilities = $data['liabilities'];
		$income = $data['income'];
		$other_income = $data['other_income'];
		$other_income_concept = $data['other_income_concept'];
		$foreign_transactions = $data['foreign_transactions'];
		$foreign_transactions_details = $data['foreign_transactions_details'];
		$foreign_financial_products = $data['foreign_financial_products'];
		$foreign_financial_products_details = $data['foreign_financial_products_details'];
		$declarations = $data['declarations'];
		$is_active = $data['is_active'];
		$subscription_expiry_date = $data['subscription_expiry_date'];
		$created_at = $data['created_at'];
		$updated_at = $data['updated_at'];
		$activity_type = $data['activity_type'];
		$keywords = $data['keywords'];
		$info_state = $data['info_state'];
		$assets = $data['assets'];
		$expenses = $data['expenses'];
		$equity = $data['equity'];
		$other_expenses = $data['other_expenses'];
		$income_origin = $data['income_origin'];
		$assets_total = $data['assets_total'];
		$liabilities_total = $data['liabilities_total'];
		$income_other = $data['income_other'];
		$eeff = $data['eeff'];
		$eeff_year = $data['eeff_year'];
		$eeff_udate = $data['eeff_udate'];
		$expenses_other = $data['expenses_other'];
		$income_total = $data['income_total'];
		$expenses_total = $data['expenses_total'];
		$utility = $data['utility'];
		$utility_total = $data['utility_total'];
		$financial_expenses = $data['financial_expenses'];
		$income_other_concept = $data['income_other_concept'];
		$industry = $data['industry'];
		$image = $data['image'];
		$policy = $data['policy'];
		$visibility_status = $data['visibility_status'];
		$facebook = $data['facebook'];
		$instagram = $data['instagram'];
		$twitter = $data['twitter'];
		$linkedin = $data['linkedin'];
		$slug = $data['slug'];
		$position = $data['position'];
		$ip = $data['ip'];
		$representative_name2 = $data['representative_name2'];
		$document_type2 = $data['document_type2'];
		$document_number2 = $data['document_number2'];
		$document_issue_place2 = $data['document_issue_place2'];
		$document_issue_date2 = $data['document_issue_date2'];
		$representative_birth_country = $data['representative_birth_country'];
		$representative_birth_country2 = $data['representative_birth_country2'];
		$legal_representative_id2 = $data['legal_representative_id2'];
		$certificate_issue_date = $data['certificate_issue_date'];
		$company_validity = $data['company_validity'];
		$company_validity2 = $data['company_validity2'];
		$registry_state = $data['registry_state'];
		$registry_city = $data['registry_city'];
		$incorporation_certificate = $data['incorporation_certificate'];
		$trade_registry_udate = $data['trade_registry_udate'];
		$incorporation_certificate_udate = $data['incorporation_certificate_udate'];
		$rut_certificate_udate = $data['rut_certificate_udate'];
		$brochure = $data['brochure'];
		$company_size = $data['company_size'];
		$company_size_certificate = $data['company_size_certificate'];
		$company_size_certificate_udate = $data['company_size_certificate_udate'];
		$foreign_currency = $data['foreign_currency'];
		$which_foreign_currency = $data['which_foreign_currency'];
		$foreign_products = $data['foreign_products'];
		$which_foreign_products = $data['which_foreign_products'];
		$tax_liabilities = $data['tax_liabilities'];
		$nontaxable_agent = $data['nontaxable_agent'];
		$supplier_soc_type = $data['supplier_soc_type'];
		$query = "UPDATE suppliers SET  is_legal_entity = '$is_legal_entity', filling_date = '$filling_date', counterparty_type = '$counterparty_type', supplier_type = '$supplier_type', company_name = '$company_name', primary_email = '$primary_email', economic_activity = '$economic_activity', ciiu_code = '$ciiu_code', commercial_activity = '$commercial_activity', website = '$website', main_address = '$main_address', company_type = '$company_type', identification_nit = '$identification_nit', city = '$city', state = '$state', country = '$country', landline = '$landline', mobile_phone = '$mobile_phone', trade_registry = '$trade_registry', legal_representative_id = '$legal_representative_id', rut_certificate = '$rut_certificate', financial_statements = '$financial_statements', tax_declaration = '$tax_declaration', tax_declaration_year = '$tax_declaration_year', tax_declaration_udate = '$tax_declaration_udate', number_of_employees = '$number_of_employees', company_date = '$company_date', representative_name = '$representative_name', document_type = '$document_type', document_number = '$document_number', document_issue_place = '$document_issue_place', nationality = '$nationality', document_issue_date = '$document_issue_date', birthdate = '$birthdate', birth_country = '$birth_country', birth_city = '$birth_city', birth_state = '$birth_state', manages_public_funds = '$manages_public_funds', public_recognition = '$public_recognition', relationship_with_publicly_exposed_person = '$relationship_with_publicly_exposed_person', resource_origin = '$resource_origin', currency_type = '$currency_type', liabilities = '$liabilities', income = '$income', other_income = '$other_income', other_income_concept = '$other_income_concept', foreign_transactions = '$foreign_transactions', foreign_transactions_details = '$foreign_transactions_details', foreign_financial_products = '$foreign_financial_products', foreign_financial_products_details = '$foreign_financial_products_details', declarations = '$declarations', is_active = '$is_active', subscription_expiry_date = '$subscription_expiry_date', created_at = '$created_at', updated_at = '$updated_at', activity_type = '$activity_type', keywords = '$keywords', info_state = '$info_state', assets = '$assets', expenses = '$expenses', equity = '$equity', other_expenses = '$other_expenses', income_origin = '$income_origin', assets_total = '$assets_total', liabilities_total = '$liabilities_total', income_other = '$income_other', eeff = '$eeff', eeff_year = '$eeff_year', eeff_udate = '$eeff_udate', expenses_other = '$expenses_other', income_total = '$income_total', expenses_total = '$expenses_total', utility = '$utility', utility_total = '$utility_total', financial_expenses = '$financial_expenses', income_other_concept = '$income_other_concept', industry = '$industry', image = '$image', policy = '$policy', visibility_status = '$visibility_status', facebook = '$facebook', instagram = '$instagram', twitter = '$twitter', linkedin = '$linkedin', slug = '$slug', position = '$position', ip = '$ip', representative_name2 = '$representative_name2', document_type2 = '$document_type2', document_number2 = '$document_number2', document_issue_place2 = '$document_issue_place2', document_issue_date2 = '$document_issue_date2', representative_birth_country = '$representative_birth_country', representative_birth_country2 = '$representative_birth_country2', legal_representative_id2 = '$legal_representative_id2', certificate_issue_date = '$certificate_issue_date', company_validity = '$company_validity', company_validity2 = '$company_validity2', registry_state = '$registry_state', registry_city = '$registry_city', incorporation_certificate = '$incorporation_certificate', trade_registry_udate = '$trade_registry_udate', incorporation_certificate_udate = '$incorporation_certificate_udate', rut_certificate_udate = '$rut_certificate_udate', brochure = '$brochure', company_size = '$company_size', company_size_certificate = '$company_size_certificate', company_size_certificate_udate = '$company_size_certificate_udate', foreign_currency = '$foreign_currency', which_foreign_currency = '$which_foreign_currency', foreign_products = '$foreign_products', which_foreign_products = '$which_foreign_products', tax_liabilities = '$tax_liabilities', nontaxable_agent = '$nontaxable_agent', supplier_soc_type = '$supplier_soc_type' WHERE id = '" . $id . "'";
		$res = $this->_conn->query($query);
	}

	public function updateProfile($id, $data)
	{
		$company_name = $data['company_name'];
		$supplier_soc_type = $data['supplier_soc_type'];
		$birth_country = $data['country'];
		$birth_city = $data['city'];
		$birth_state = $data['state'];
		$commercial_activity = $data['commercial_activity'];
		$position = $data['position'];
		$updated_at = $data['updated_at'];
		$image = $data['image'];

		$query = "UPDATE suppliers SET company_name = '$company_name', supplier_soc_type = '$supplier_soc_type', birth_country = '$birth_country', birth_city = '$birth_city', birth_state = '$birth_state', commercial_activity = '$commercial_activity', position = '$position', updated_at = '$updated_at', image = '$image' WHERE id = '$id'";
		$res = $this->_conn->query($query);
		return $res;
	}

	public function updateProfileCompany($id, $data)
	{
		/* Array
(
    [is_legal_entity] => 1
    [counterparty_type] => 1
    [company_type] => Público
    [activity_type] => Industrial
    [main_address] => 112312312
    [country] => Colombia
    [state] => Santander
    [city] => San Gil
    [mobile_phone] => 3124624763
    [primary_email] => juansesdvsf@gmail.com
    [company_size] => 1
    [company_size_certificate] => 
    [number_of_employees] => 3
    [website] => 
    [brochure] => 
    [facebook] => 
    [instagram] => 
    [twitter] => 
    [linkedin] => 
    [keywords] => 
) */

		$is_legal_entity = $data['is_legal_entity'];
		$counterparty_type = $data['counterparty_type'];
		$company_type = $data['company_type'];
		$activity_type = $data['activity_type'];
		$main_address = $data['main_address'];
		$country = $data['country'];
		$state = $data['state'];
		$city = $data['city'];
		$mobile_phone = $data['mobile_phone'];
		$primary_email = $data['primary_email'];
		$company_size = $data['company_size'];
		$company_size_certificate = $data['company_size_certificate'];
		$number_of_employees = $data['number_of_employees'];
		$website = $data['website'];
		$brochure = $data['brochure'];
		$facebook = $data['facebook'];
		$instagram = $data['instagram'];
		$twitter = $data['twitter'];
		$linkedin = $data['linkedin'];
		$keywords = $data['keywords'];
		$updated_at = $data['updated_at'];

		$query = "UPDATE suppliers SET is_legal_entity = '$is_legal_entity', counterparty_type = '$counterparty_type', company_type = '$company_type', activity_type = '$activity_type', main_address = '$main_address', country = '$country', state = '$state', city = '$city', mobile_phone = '$mobile_phone', primary_email = '$primary_email', company_size = '$company_size', company_size_certificate = '$company_size_certificate', number_of_employees = '$number_of_employees', website = '$website', brochure = '$brochure', facebook = '$facebook', instagram = '$instagram', twitter = '$twitter', linkedin = '$linkedin', keywords = '$keywords', updated_at = '$updated_at' WHERE id = '$id'";
		$res = $this->_conn->query($query);
		return $res;
	}

	public function updateFinancialInfo($id, $data)
	{
		$income_origin = $data['income_origin'];
		$currency_type = $data['currency_type'];
		$equity = $data['equity'];
		$assets = $data['assets'];
		$liabilities = $data['liabilities'];
		$assets_total = $data['assets_total'];
		$liabilities_total = $data['liabilities_total'];
		$income = $data['income'];
		$expenses = $data['expenses'];
		$income_other = $data['income_other'];
		$expenses_other = $data['expenses_other'];
		$income_total = $data['income_total'];
		$expenses_total = $data['expenses_total'];
		$utility = $data['utility'];
		$utility_total = $data['utility_total'];
		$financial_expenses = $data['financial_expenses'];
		$income_other_concept = $data['income_other_concept'];
		$eeff_year = $data['eeff_year'];
		$foreign_currency = $data['foreign_currency'];
		$which_foreign_currency = $data['which_foreign_currency'];
		$foreign_products = $data['foreign_products'];
		$which_foreign_products = $data['which_foreign_products'];
		$nontaxable_agent = $data['nontaxable_agent'];
		$tax_regime = $data['tax_regime'];
		$tax_declaration_year = $data['tax_declaration_year'];
		$eeff = $data['eeff'];
		$tax_declaration = $data['tax_declaration'];
		$updated_at = $data['updated_at'];

		$query = "UPDATE suppliers SET 
		  income_origin = '$income_origin', 
		  currency_type = '$currency_type', 
		  equity = '$equity', 
		  assets = '$assets', 
		  liabilities = '$liabilities', 
		  assets_total = '$assets_total', 
		  liabilities_total = '$liabilities_total', 
		  income = '$income', 
		  expenses = '$expenses', 
		  income_other = '$income_other', 
		  expenses_other = '$expenses_other', 
		  income_total = '$income_total', 
		  expenses_total = '$expenses_total', 
		  utility = '$utility', 
		  utility_total = '$utility_total', 
		  financial_expenses = '$financial_expenses', 
		  income_other_concept = '$income_other_concept', 
		  eeff_year = '$eeff_year', 
		  foreign_currency = '$foreign_currency', 
		  which_foreign_currency = '$which_foreign_currency', 
		  foreign_products = '$foreign_products', 
		  which_foreign_products = '$which_foreign_products', 
		  nontaxable_agent = '$nontaxable_agent',
		  tax_regime = '$tax_regime',
		  tax_declaration_year = '$tax_declaration_year',
		  eeff = '$eeff', 
		  tax_declaration = '$tax_declaration',
		  updated_at = '$updated_at' 
		  WHERE id = '$id'";
		$res = $this->_conn->query($query);
		return $res;
	}
}
