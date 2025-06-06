<?php 
/**
* clase que genera la insercion y edicion  de suppliers en la base de datos
*/
class Page_Model_DbTable_Listasuppliers extends Db_Table
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
	 * insert recibe la informacion de un suppliers y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$brochure = $data['brochure'];
		$certificate_issue_date = $data['certificate_issue_date'];
		$certificate_issue_name = $data['certificate_issue_name'];
		$company_size = $data['company_size'];
		$company_size_certificate = $data['company_size_certificate'];
		$company_size_certificate_udate = $data['company_size_certificate_udate'];
		$company_validity = $data['company_validity'];
		$company_validity2 = $data['company_validity2'];
		$document_issue_date2 = $data['document_issue_date2'];
		$document_issue_place2 = $data['document_issue_place2'];
		$document_number2 = $data['document_number2'];
		$document_type2 = $data['document_type2'];
		$facebook = $data['facebook'];
		$foreign_currency = $data['foreign_currency'];
		$foreign_products = $data['foreign_products'];
		$incorporation_certificate = $data['incorporation_certificate'];
		$incorporation_certificate_udate = $data['incorporation_certificate_udate'];
		$instagram = $data['instagram'];
		$ip = $data['ip'];
		$legal_representative_id2 = $data['legal_representative_id2'];
		$linkedin = $data['linkedin'];
		$nontaxable_agent = $data['nontaxable_agent'];
		$policy = $data['policy'];
		$position = $data['position'];
		$registry_city = $data['registry_city'];
		$registry_country = $data['registry_country'];
		$registry_state = $data['registry_state'];
		$representative_birth_country = $data['representative_birth_country'];
		$representative_birth_country2 = $data['representative_birth_country2'];
		$representative_name2 = $data['representative_name2'];
		$rut_certificate_udate = $data['rut_certificate_udate'];
		$slug = $data['slug'];
		$supplier_soc_type = $data['supplier_soc_type'];
		$tax_liabilities = $data['tax_liabilities'];
		$tax_regime = $data['tax_regime'];
		$trade_registry_udate = $data['trade_registry_udate'];
		$twitter = $data['twitter'];
		$visibility_status = $data['visibility_status'];
		$which_foreign_currency = $data['which_foreign_currency'];
		$which_foreign_products = $data['which_foreign_products'];
		$worldwide = $data['worldwide'];
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
		$rut_certificate_name = $data['rut_certificate_name'];
		$rut_certificate = $data['rut_certificate'];
		$rut_certificate_date_expedition = $data['rut_certificate_date_expedition'];
		$rut_certificate_country = $data['rut_certificate_country'];
		$rut_certificate_state = $data['rut_certificate_state'];
		$rut_certificate_city = $data['rut_certificate_city'];
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
		$query = "INSERT INTO suppliers( brochure, certificate_issue_date, certificate_issue_name, company_size, company_size_certificate, company_size_certificate_udate, company_validity, company_validity2, document_issue_date2, document_issue_place2, document_number2, document_type2, facebook, foreign_currency, foreign_products, incorporation_certificate, incorporation_certificate_udate, instagram, ip, legal_representative_id2, linkedin, nontaxable_agent, policy, position, registry_city, registry_country, registry_state, representative_birth_country, representative_birth_country2, representative_name2, rut_certificate_udate, slug, supplier_soc_type, tax_liabilities, tax_regime, trade_registry_udate, twitter, visibility_status, which_foreign_currency, which_foreign_products, worldwide, is_legal_entity, filling_date, counterparty_type, supplier_type, company_name, primary_email, economic_activity, ciiu_code, commercial_activity, website, main_address, company_type, identification_nit, city, state, country, landline, mobile_phone, trade_registry, legal_representative_id, rut_certificate_name, rut_certificate, rut_certificate_date_expedition, rut_certificate_country, rut_certificate_state, rut_certificate_city, financial_statements, tax_declaration, tax_declaration_year, tax_declaration_udate, number_of_employees, company_date, representative_name, document_type, document_number, document_issue_place, nationality, document_issue_date, birthdate, birth_country, birth_city, birth_state, manages_public_funds, public_recognition, relationship_with_publicly_exposed_person, resource_origin, currency_type, liabilities, income, other_income, other_income_concept, foreign_transactions, foreign_transactions_details, foreign_financial_products, foreign_financial_products_details, declarations, is_active, subscription_expiry_date, created_at, updated_at, activity_type, keywords, info_state, assets, expenses, equity, other_expenses, income_origin, assets_total, liabilities_total, income_other, eeff, eeff_year, eeff_udate, expenses_other, income_total, expenses_total, utility, utility_total, financial_expenses, income_other_concept, industry, image) VALUES ( '$brochure', '$certificate_issue_date', '$certificate_issue_name', '$company_size', '$company_size_certificate', '$company_size_certificate_udate', '$company_validity', '$company_validity2', '$document_issue_date2', '$document_issue_place2', '$document_number2', '$document_type2', '$facebook', '$foreign_currency', '$foreign_products', '$incorporation_certificate', '$incorporation_certificate_udate', '$instagram', '$ip', '$legal_representative_id2', '$linkedin', '$nontaxable_agent', '$policy', '$position', '$registry_city', '$registry_country', '$registry_state', '$representative_birth_country', '$representative_birth_country2', '$representative_name2', '$rut_certificate_udate', '$slug', '$supplier_soc_type', '$tax_liabilities', '$tax_regime', '$trade_registry_udate', '$twitter', '$visibility_status', '$which_foreign_currency', '$which_foreign_products', '$worldwide', '$is_legal_entity', '$filling_date', '$counterparty_type', '$supplier_type', '$company_name', '$primary_email', '$economic_activity', '$ciiu_code', '$commercial_activity', '$website', '$main_address', '$company_type', '$identification_nit', '$city', '$state', '$country', '$landline', '$mobile_phone', '$trade_registry', '$legal_representative_id', '$rut_certificate_name', '$rut_certificate', '$rut_certificate_date_expedition', '$rut_certificate_country', '$rut_certificate_state', '$rut_certificate_city', '$financial_statements', '$tax_declaration', '$tax_declaration_year', '$tax_declaration_udate', '$number_of_employees', '$company_date', '$representative_name', '$document_type', '$document_number', '$document_issue_place', '$nationality', '$document_issue_date', '$birthdate', '$birth_country', '$birth_city', '$birth_state', '$manages_public_funds', '$public_recognition', '$relationship_with_publicly_exposed_person', '$resource_origin', '$currency_type', '$liabilities', '$income', '$other_income', '$other_income_concept', '$foreign_transactions', '$foreign_transactions_details', '$foreign_financial_products', '$foreign_financial_products_details', '$declarations', '$is_active', '$subscription_expiry_date', '$created_at', '$updated_at', '$activity_type', '$keywords', '$info_state', '$assets', '$expenses', '$equity', '$other_expenses', '$income_origin', '$assets_total', '$liabilities_total', '$income_other', '$eeff', '$eeff_year', '$eeff_udate', '$expenses_other', '$income_total', '$expenses_total', '$utility', '$utility_total', '$financial_expenses', '$income_other_concept', '$industry', '$image')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un suppliers  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$brochure = $data['brochure'];
		$certificate_issue_date = $data['certificate_issue_date'];
		$certificate_issue_name = $data['certificate_issue_name'];
		$company_size = $data['company_size'];
		$company_size_certificate = $data['company_size_certificate'];
		$company_size_certificate_udate = $data['company_size_certificate_udate'];
		$company_validity = $data['company_validity'];
		$company_validity2 = $data['company_validity2'];
		$document_issue_date2 = $data['document_issue_date2'];
		$document_issue_place2 = $data['document_issue_place2'];
		$document_number2 = $data['document_number2'];
		$document_type2 = $data['document_type2'];
		$facebook = $data['facebook'];
		$foreign_currency = $data['foreign_currency'];
		$foreign_products = $data['foreign_products'];
		$incorporation_certificate = $data['incorporation_certificate'];
		$incorporation_certificate_udate = $data['incorporation_certificate_udate'];
		$instagram = $data['instagram'];
		$ip = $data['ip'];
		$legal_representative_id2 = $data['legal_representative_id2'];
		$linkedin = $data['linkedin'];
		$nontaxable_agent = $data['nontaxable_agent'];
		$policy = $data['policy'];
		$position = $data['position'];
		$registry_city = $data['registry_city'];
		$registry_country = $data['registry_country'];
		$registry_state = $data['registry_state'];
		$representative_birth_country = $data['representative_birth_country'];
		$representative_birth_country2 = $data['representative_birth_country2'];
		$representative_name2 = $data['representative_name2'];
		$rut_certificate_udate = $data['rut_certificate_udate'];
		$slug = $data['slug'];
		$supplier_soc_type = $data['supplier_soc_type'];
		$tax_liabilities = $data['tax_liabilities'];
		$tax_regime = $data['tax_regime'];
		$trade_registry_udate = $data['trade_registry_udate'];
		$twitter = $data['twitter'];
		$visibility_status = $data['visibility_status'];
		$which_foreign_currency = $data['which_foreign_currency'];
		$which_foreign_products = $data['which_foreign_products'];
		$worldwide = $data['worldwide'];
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
		$rut_certificate_name = $data['rut_certificate_name'];
		$rut_certificate = $data['rut_certificate'];
		$rut_certificate_date_expedition = $data['rut_certificate_date_expedition'];
		$rut_certificate_country = $data['rut_certificate_country'];
		$rut_certificate_state = $data['rut_certificate_state'];
		$rut_certificate_city = $data['rut_certificate_city'];
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
		$query = "UPDATE suppliers SET  brochure = '$brochure', certificate_issue_date = '$certificate_issue_date', certificate_issue_name = '$certificate_issue_name', company_size = '$company_size', company_size_certificate = '$company_size_certificate', company_size_certificate_udate = '$company_size_certificate_udate', company_validity = '$company_validity', company_validity2 = '$company_validity2', document_issue_date2 = '$document_issue_date2', document_issue_place2 = '$document_issue_place2', document_number2 = '$document_number2', document_type2 = '$document_type2', facebook = '$facebook', foreign_currency = '$foreign_currency', foreign_products = '$foreign_products', incorporation_certificate = '$incorporation_certificate', incorporation_certificate_udate = '$incorporation_certificate_udate', instagram = '$instagram', ip = '$ip', legal_representative_id2 = '$legal_representative_id2', linkedin = '$linkedin', nontaxable_agent = '$nontaxable_agent', policy = '$policy', position = '$position', registry_city = '$registry_city', registry_country = '$registry_country', registry_state = '$registry_state', representative_birth_country = '$representative_birth_country', representative_birth_country2 = '$representative_birth_country2', representative_name2 = '$representative_name2', rut_certificate_udate = '$rut_certificate_udate', slug = '$slug', supplier_soc_type = '$supplier_soc_type', tax_liabilities = '$tax_liabilities', tax_regime = '$tax_regime', trade_registry_udate = '$trade_registry_udate', twitter = '$twitter', visibility_status = '$visibility_status', which_foreign_currency = '$which_foreign_currency', which_foreign_products = '$which_foreign_products', worldwide = '$worldwide', is_legal_entity = '$is_legal_entity', filling_date = '$filling_date', counterparty_type = '$counterparty_type', supplier_type = '$supplier_type', company_name = '$company_name', primary_email = '$primary_email', economic_activity = '$economic_activity', ciiu_code = '$ciiu_code', commercial_activity = '$commercial_activity', website = '$website', main_address = '$main_address', company_type = '$company_type', identification_nit = '$identification_nit', city = '$city', state = '$state', country = '$country', landline = '$landline', mobile_phone = '$mobile_phone', trade_registry = '$trade_registry', legal_representative_id = '$legal_representative_id', rut_certificate_name = '$rut_certificate_name', rut_certificate = '$rut_certificate', rut_certificate_date_expedition = '$rut_certificate_date_expedition', rut_certificate_country = '$rut_certificate_country', rut_certificate_state = '$rut_certificate_state', rut_certificate_city = '$rut_certificate_city', financial_statements = '$financial_statements', tax_declaration = '$tax_declaration', tax_declaration_year = '$tax_declaration_year', tax_declaration_udate = '$tax_declaration_udate', number_of_employees = '$number_of_employees', company_date = '$company_date', representative_name = '$representative_name', document_type = '$document_type', document_number = '$document_number', document_issue_place = '$document_issue_place', nationality = '$nationality', document_issue_date = '$document_issue_date', birthdate = '$birthdate', birth_country = '$birth_country', birth_city = '$birth_city', birth_state = '$birth_state', manages_public_funds = '$manages_public_funds', public_recognition = '$public_recognition', relationship_with_publicly_exposed_person = '$relationship_with_publicly_exposed_person', resource_origin = '$resource_origin', currency_type = '$currency_type', liabilities = '$liabilities', income = '$income', other_income = '$other_income', other_income_concept = '$other_income_concept', foreign_transactions = '$foreign_transactions', foreign_transactions_details = '$foreign_transactions_details', foreign_financial_products = '$foreign_financial_products', foreign_financial_products_details = '$foreign_financial_products_details', declarations = '$declarations', is_active = '$is_active', subscription_expiry_date = '$subscription_expiry_date', created_at = '$created_at', updated_at = '$updated_at', activity_type = '$activity_type', keywords = '$keywords', info_state = '$info_state', assets = '$assets', expenses = '$expenses', equity = '$equity', other_expenses = '$other_expenses', income_origin = '$income_origin', assets_total = '$assets_total', liabilities_total = '$liabilities_total', income_other = '$income_other', eeff = '$eeff', eeff_year = '$eeff_year', eeff_udate = '$eeff_udate', expenses_other = '$expenses_other', income_total = '$income_total', expenses_total = '$expenses_total', utility = '$utility', utility_total = '$utility_total', financial_expenses = '$financial_expenses', income_other_concept = '$income_other_concept', industry = '$industry', image = '$image' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}