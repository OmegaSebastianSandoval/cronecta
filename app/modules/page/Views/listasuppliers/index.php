<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form action="<?php echo $this->route; ?>" method="post">
        <div class="content-dashboard">
            <div class="row">
				<div class="col-3">
		            <label>is_legal_entity</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="is_legal_entity" value="<?php echo $this->getObjectVariable($this->filters, 'is_legal_entity') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
	                <label>filling_date</label>
	                <label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-calendar-alt"></i></span>
						</div>
	                <input type="text" class="form-control" name="filling_date" value="<?php echo $this->getObjectVariable($this->filters, 'filling_date') ?>"></input>
	                    </label>
	            </div>
				<div class="col-3">
		            <label>counterparty_type</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="counterparty_type" value="<?php echo $this->getObjectVariable($this->filters, 'counterparty_type') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>supplier_type</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="supplier_type" value="<?php echo $this->getObjectVariable($this->filters, 'supplier_type') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>company_name</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="company_name" value="<?php echo $this->getObjectVariable($this->filters, 'company_name') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>primary_email</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="primary_email" value="<?php echo $this->getObjectVariable($this->filters, 'primary_email') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>economic_activity</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="economic_activity" value="<?php echo $this->getObjectVariable($this->filters, 'economic_activity') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>ciiu_code</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="ciiu_code" value="<?php echo $this->getObjectVariable($this->filters, 'ciiu_code') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>commercial_activity</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="commercial_activity" value="<?php echo $this->getObjectVariable($this->filters, 'commercial_activity') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>website</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="website" value="<?php echo $this->getObjectVariable($this->filters, 'website') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>main_address</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="main_address" value="<?php echo $this->getObjectVariable($this->filters, 'main_address') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>company_type</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="company_type" value="<?php echo $this->getObjectVariable($this->filters, 'company_type') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>identification_nit</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="identification_nit" value="<?php echo $this->getObjectVariable($this->filters, 'identification_nit') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>city</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="city" value="<?php echo $this->getObjectVariable($this->filters, 'city') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>state</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="state" value="<?php echo $this->getObjectVariable($this->filters, 'state') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>country</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="country" value="<?php echo $this->getObjectVariable($this->filters, 'country') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>landline</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="landline" value="<?php echo $this->getObjectVariable($this->filters, 'landline') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>mobile_phone</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="mobile_phone" value="<?php echo $this->getObjectVariable($this->filters, 'mobile_phone') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>trade_registry</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="trade_registry" value="<?php echo $this->getObjectVariable($this->filters, 'trade_registry') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>legal_representative_id</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="legal_representative_id" value="<?php echo $this->getObjectVariable($this->filters, 'legal_representative_id') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>rut_certificate_name</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="rut_certificate_name" value="<?php echo $this->getObjectVariable($this->filters, 'rut_certificate_name') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>rut_certificate</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="rut_certificate" value="<?php echo $this->getObjectVariable($this->filters, 'rut_certificate') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
	                <label>rut_certificate_date_expedition</label>
	                <label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-calendar-alt"></i></span>
						</div>
	                <input type="text" class="form-control" name="rut_certificate_date_expedition" value="<?php echo $this->getObjectVariable($this->filters, 'rut_certificate_date_expedition') ?>"></input>
	                    </label>
	            </div>
				<div class="col-3">
		            <label>rut_certificate_country</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="rut_certificate_country" value="<?php echo $this->getObjectVariable($this->filters, 'rut_certificate_country') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>rut_certificate_state</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="rut_certificate_state" value="<?php echo $this->getObjectVariable($this->filters, 'rut_certificate_state') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>rut_certificate_city</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="rut_certificate_city" value="<?php echo $this->getObjectVariable($this->filters, 'rut_certificate_city') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>financial_statements</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="financial_statements" value="<?php echo $this->getObjectVariable($this->filters, 'financial_statements') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>tax_declaration</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="tax_declaration" value="<?php echo $this->getObjectVariable($this->filters, 'tax_declaration') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>tax_declaration_year</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="tax_declaration_year" value="<?php echo $this->getObjectVariable($this->filters, 'tax_declaration_year') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>tax_declaration_udate</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="tax_declaration_udate" value="<?php echo $this->getObjectVariable($this->filters, 'tax_declaration_udate') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>number_of_employees</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="number_of_employees" value="<?php echo $this->getObjectVariable($this->filters, 'number_of_employees') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
	                <label>company_date</label>
	                <label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-calendar-alt"></i></span>
						</div>
	                <input type="text" class="form-control" name="company_date" value="<?php echo $this->getObjectVariable($this->filters, 'company_date') ?>"></input>
	                    </label>
	            </div>
				<div class="col-3">
		            <label>representative_name</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="representative_name" value="<?php echo $this->getObjectVariable($this->filters, 'representative_name') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>document_type</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="document_type" value="<?php echo $this->getObjectVariable($this->filters, 'document_type') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>document_number</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="document_number" value="<?php echo $this->getObjectVariable($this->filters, 'document_number') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>document_issue_place</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="document_issue_place" value="<?php echo $this->getObjectVariable($this->filters, 'document_issue_place') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>nationality</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="nationality" value="<?php echo $this->getObjectVariable($this->filters, 'nationality') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
	                <label>document_issue_date</label>
	                <label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-calendar-alt"></i></span>
						</div>
	                <input type="text" class="form-control" name="document_issue_date" value="<?php echo $this->getObjectVariable($this->filters, 'document_issue_date') ?>"></input>
	                    </label>
	            </div>
				<div class="col-3">
	                <label>birthdate</label>
	                <label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-calendar-alt"></i></span>
						</div>
	                <input type="text" class="form-control" name="birthdate" value="<?php echo $this->getObjectVariable($this->filters, 'birthdate') ?>"></input>
	                    </label>
	            </div>
				<div class="col-3">
		            <label>birth_country</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="birth_country" value="<?php echo $this->getObjectVariable($this->filters, 'birth_country') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>birth_city</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="birth_city" value="<?php echo $this->getObjectVariable($this->filters, 'birth_city') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>birth_state</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="birth_state" value="<?php echo $this->getObjectVariable($this->filters, 'birth_state') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>manages_public_funds</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="manages_public_funds" value="<?php echo $this->getObjectVariable($this->filters, 'manages_public_funds') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>public_recognition</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="public_recognition" value="<?php echo $this->getObjectVariable($this->filters, 'public_recognition') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>relationship_with_publicly_exposed_person</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="relationship_with_publicly_exposed_person" value="<?php echo $this->getObjectVariable($this->filters, 'relationship_with_publicly_exposed_person') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>resource_origin</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="resource_origin" value="<?php echo $this->getObjectVariable($this->filters, 'resource_origin') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>currency_type</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="currency_type" value="<?php echo $this->getObjectVariable($this->filters, 'currency_type') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>liabilities</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="liabilities" value="<?php echo $this->getObjectVariable($this->filters, 'liabilities') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>income</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="income" value="<?php echo $this->getObjectVariable($this->filters, 'income') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>other_income</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="other_income" value="<?php echo $this->getObjectVariable($this->filters, 'other_income') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>other_income_concept</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="other_income_concept" value="<?php echo $this->getObjectVariable($this->filters, 'other_income_concept') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>foreign_transactions</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="foreign_transactions" value="<?php echo $this->getObjectVariable($this->filters, 'foreign_transactions') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>foreign_transactions_details</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="foreign_transactions_details" value="<?php echo $this->getObjectVariable($this->filters, 'foreign_transactions_details') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>foreign_financial_products</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="foreign_financial_products" value="<?php echo $this->getObjectVariable($this->filters, 'foreign_financial_products') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>foreign_financial_products_details</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="foreign_financial_products_details" value="<?php echo $this->getObjectVariable($this->filters, 'foreign_financial_products_details') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>declarations</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="declarations" value="<?php echo $this->getObjectVariable($this->filters, 'declarations') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>is_active</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="is_active" value="<?php echo $this->getObjectVariable($this->filters, 'is_active') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
	                <label>subscription_expiry_date</label>
	                <label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-calendar-alt"></i></span>
						</div>
	                <input type="text" class="form-control" name="subscription_expiry_date" value="<?php echo $this->getObjectVariable($this->filters, 'subscription_expiry_date') ?>"></input>
	                    </label>
	            </div>
				<div class="col-3">
		            <label>created_at</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="created_at" value="<?php echo $this->getObjectVariable($this->filters, 'created_at') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>updated_at</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="updated_at" value="<?php echo $this->getObjectVariable($this->filters, 'updated_at') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>activity_type</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="activity_type" value="<?php echo $this->getObjectVariable($this->filters, 'activity_type') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>keywords</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="keywords" value="<?php echo $this->getObjectVariable($this->filters, 'keywords') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>info_state</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="info_state" value="<?php echo $this->getObjectVariable($this->filters, 'info_state') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>assets</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="assets" value="<?php echo $this->getObjectVariable($this->filters, 'assets') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>expenses</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="expenses" value="<?php echo $this->getObjectVariable($this->filters, 'expenses') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>equity</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="equity" value="<?php echo $this->getObjectVariable($this->filters, 'equity') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>other_expenses</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="other_expenses" value="<?php echo $this->getObjectVariable($this->filters, 'other_expenses') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>income_origin</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="income_origin" value="<?php echo $this->getObjectVariable($this->filters, 'income_origin') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>assets_total</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="assets_total" value="<?php echo $this->getObjectVariable($this->filters, 'assets_total') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>liabilities_total</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="liabilities_total" value="<?php echo $this->getObjectVariable($this->filters, 'liabilities_total') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>income_other</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="income_other" value="<?php echo $this->getObjectVariable($this->filters, 'income_other') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>eeff</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="eeff" value="<?php echo $this->getObjectVariable($this->filters, 'eeff') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>eeff_year</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="eeff_year" value="<?php echo $this->getObjectVariable($this->filters, 'eeff_year') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>eeff_udate</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="eeff_udate" value="<?php echo $this->getObjectVariable($this->filters, 'eeff_udate') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>expenses_other</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="expenses_other" value="<?php echo $this->getObjectVariable($this->filters, 'expenses_other') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>income_total</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="income_total" value="<?php echo $this->getObjectVariable($this->filters, 'income_total') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>expenses_total</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="expenses_total" value="<?php echo $this->getObjectVariable($this->filters, 'expenses_total') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>utility</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="utility" value="<?php echo $this->getObjectVariable($this->filters, 'utility') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>utility_total</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="utility_total" value="<?php echo $this->getObjectVariable($this->filters, 'utility_total') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>financial_expenses</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="financial_expenses" value="<?php echo $this->getObjectVariable($this->filters, 'financial_expenses') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>income_other_concept</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="income_other_concept" value="<?php echo $this->getObjectVariable($this->filters, 'income_other_concept') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>industry</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="industry" value="<?php echo $this->getObjectVariable($this->filters, 'industry') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>image</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="image" value="<?php echo $this->getObjectVariable($this->filters, 'image') ?>"></input>
		            </label>
		        </div>
                <div class="col-3">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-block btn-azul"> <i class="fas fa-filter"></i> Filtrar</button>
                </div>
                <div class="col-3">
                    <label>&nbsp;</label>
                    <a class="btn btn-block btn-azul-claro " href="<?php echo $this->route; ?>?cleanfilter=1" > <i class="fas fa-eraser"></i> Limpiar Filtro</a>
                </div>
            </div>
        </div>
    </form>
    <div align="center">
		<ul class="pagination justify-content-center">
	    <?php
	    	$url = $this->route;
	        if ($this->totalpages > 1) {
	            if ($this->page != 1)
	                echo '<li class="page-item" ><a class="page-link"  href="'.$url.'?page='.($this->page-1).'"> &laquo; Anterior </a></li>';
	            for ($i=1;$i<=$this->totalpages;$i++) {
	                if ($this->page == $i)
	                    echo '<li class="active page-item"><a class="page-link">'.$this->page.'</a></li>';
	                else
	                    echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.$i.'">'.$i.'</a></li>  ';
	            }
	            if ($this->page != $this->totalpages)
	                echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.($this->page+1).'">Siguiente &raquo;</a></li>';
	        }
	  	?>
	  	</ul>
	</div>
	<div class="content-dashboard">
	    <div class="franja-paginas">
		    <div class="row">
		    	<div class="col-5">
		    		<div class="titulo-registro">Se encontraron <?php echo $this->register_number; ?> Registros</div>
		    	</div>
		    	<div class="col-3 text-end">
		    		<div class="texto-paginas">Registros por pagina:</div>
		    	</div>
		    	<div class="col-1">
		    		<select class="form-control form-control-sm selectpagination">
		    			<option value="20" <?php if($this->pages == 20){ echo 'selected'; } ?>>20</option>
		    			<option value="30" <?php if($this->pages == 30){ echo 'selected'; } ?>>30</option>
		    			<option value="50" <?php if($this->pages == 50){ echo 'selected'; } ?>>50</option>
		    			<option value="100" <?php if($this->pages == 100){ echo 'selected'; } ?>>100</option>
		    		</select>
		    	</div>
		    	<div class="col-3">
		    		<div class="text-end"><a class="btn btn-sm btn-success" href="<?php echo $this->route."\manage"; ?>"> <i class="fas fa-plus-square"></i> Crear Nuevo</a></div>
		    	</div>
		    </div>
	    </div>
		<div class="content-table">
		<table class=" table table-striped  table-hover table-administrator text-left">
			<thead>
				<tr>
					<td>is_legal_entity</td>
					<td>filling_date</td>
					<td>counterparty_type</td>
					<td>supplier_type</td>
					<td>company_name</td>
					<td>primary_email</td>
					<td>economic_activity</td>
					<td>ciiu_code</td>
					<td>commercial_activity</td>
					<td>website</td>
					<td>main_address</td>
					<td>company_type</td>
					<td>identification_nit</td>
					<td>city</td>
					<td>state</td>
					<td>country</td>
					<td>landline</td>
					<td>mobile_phone</td>
					<td>trade_registry</td>
					<td>legal_representative_id</td>
					<td>rut_certificate_name</td>
					<td>rut_certificate</td>
					<td>rut_certificate_date_expedition</td>
					<td>rut_certificate_country</td>
					<td>rut_certificate_state</td>
					<td>rut_certificate_city</td>
					<td>financial_statements</td>
					<td>tax_declaration</td>
					<td>tax_declaration_year</td>
					<td>tax_declaration_udate</td>
					<td>number_of_employees</td>
					<td>company_date</td>
					<td>representative_name</td>
					<td>document_type</td>
					<td>document_number</td>
					<td>document_issue_place</td>
					<td>nationality</td>
					<td>document_issue_date</td>
					<td>birthdate</td>
					<td>birth_country</td>
					<td>birth_city</td>
					<td>birth_state</td>
					<td>manages_public_funds</td>
					<td>public_recognition</td>
					<td>relationship_with_publicly_exposed_person</td>
					<td>resource_origin</td>
					<td>currency_type</td>
					<td>liabilities</td>
					<td>income</td>
					<td>other_income</td>
					<td>other_income_concept</td>
					<td>foreign_transactions</td>
					<td>foreign_transactions_details</td>
					<td>foreign_financial_products</td>
					<td>foreign_financial_products_details</td>
					<td>declarations</td>
					<td>is_active</td>
					<td>subscription_expiry_date</td>
					<td>created_at</td>
					<td>updated_at</td>
					<td>activity_type</td>
					<td>keywords</td>
					<td>info_state</td>
					<td>assets</td>
					<td>expenses</td>
					<td>equity</td>
					<td>other_expenses</td>
					<td>income_origin</td>
					<td>assets_total</td>
					<td>liabilities_total</td>
					<td>income_other</td>
					<td>eeff</td>
					<td>eeff_year</td>
					<td>eeff_udate</td>
					<td>expenses_other</td>
					<td>income_total</td>
					<td>expenses_total</td>
					<td>utility</td>
					<td>utility_total</td>
					<td>financial_expenses</td>
					<td>income_other_concept</td>
					<td>industry</td>
					<td>image</td>
					<td width="100"></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->lists as $content){ ?>
				<?php $id =  $content->id; ?>
					<tr>
						<td><?=$content->is_legal_entity;?></td>
						<td><?=$content->filling_date;?></td>
						<td><?=$content->counterparty_type;?></td>
						<td><?=$content->supplier_type;?></td>
						<td><?=$content->company_name;?></td>
						<td><?=$content->primary_email;?></td>
						<td><?=$content->economic_activity;?></td>
						<td><?=$content->ciiu_code;?></td>
						<td><?=$content->commercial_activity;?></td>
						<td><?=$content->website;?></td>
						<td><?=$content->main_address;?></td>
						<td><?=$content->company_type;?></td>
						<td><?=$content->identification_nit;?></td>
						<td><?=$content->city;?></td>
						<td><?=$content->state;?></td>
						<td><?=$content->country;?></td>
						<td><?=$content->landline;?></td>
						<td><?=$content->mobile_phone;?></td>
						<td><?=$content->trade_registry;?></td>
						<td><?=$content->legal_representative_id;?></td>
						<td><?=$content->rut_certificate_name;?></td>
						<td><?=$content->rut_certificate;?></td>
						<td><?=$content->rut_certificate_date_expedition;?></td>
						<td><?=$content->rut_certificate_country;?></td>
						<td><?=$content->rut_certificate_state;?></td>
						<td><?=$content->rut_certificate_city;?></td>
						<td><?=$content->financial_statements;?></td>
						<td><?=$content->tax_declaration;?></td>
						<td><?=$content->tax_declaration_year;?></td>
						<td><?=$content->tax_declaration_udate;?></td>
						<td><?=$content->number_of_employees;?></td>
						<td><?=$content->company_date;?></td>
						<td><?=$content->representative_name;?></td>
						<td><?=$content->document_type;?></td>
						<td><?=$content->document_number;?></td>
						<td><?=$content->document_issue_place;?></td>
						<td><?=$content->nationality;?></td>
						<td><?=$content->document_issue_date;?></td>
						<td><?=$content->birthdate;?></td>
						<td><?=$content->birth_country;?></td>
						<td><?=$content->birth_city;?></td>
						<td><?=$content->birth_state;?></td>
						<td><?=$content->manages_public_funds;?></td>
						<td><?=$content->public_recognition;?></td>
						<td><?=$content->relationship_with_publicly_exposed_person;?></td>
						<td><?=$content->resource_origin;?></td>
						<td><?=$content->currency_type;?></td>
						<td><?=$content->liabilities;?></td>
						<td><?=$content->income;?></td>
						<td><?=$content->other_income;?></td>
						<td><?=$content->other_income_concept;?></td>
						<td><?=$content->foreign_transactions;?></td>
						<td><?=$content->foreign_transactions_details;?></td>
						<td><?=$content->foreign_financial_products;?></td>
						<td><?=$content->foreign_financial_products_details;?></td>
						<td><?=$content->declarations;?></td>
						<td><?=$content->is_active;?></td>
						<td><?=$content->subscription_expiry_date;?></td>
						<td><?=$content->created_at;?></td>
						<td><?=$content->updated_at;?></td>
						<td><?=$content->activity_type;?></td>
						<td><?=$content->keywords;?></td>
						<td><?=$content->info_state;?></td>
						<td><?=$content->assets;?></td>
						<td><?=$content->expenses;?></td>
						<td><?=$content->equity;?></td>
						<td><?=$content->other_expenses;?></td>
						<td><?=$content->income_origin;?></td>
						<td><?=$content->assets_total;?></td>
						<td><?=$content->liabilities_total;?></td>
						<td><?=$content->income_other;?></td>
						<td><?=$content->eeff;?></td>
						<td><?=$content->eeff_year;?></td>
						<td><?=$content->eeff_udate;?></td>
						<td><?=$content->expenses_other;?></td>
						<td><?=$content->income_total;?></td>
						<td><?=$content->expenses_total;?></td>
						<td><?=$content->utility;?></td>
						<td><?=$content->utility_total;?></td>
						<td><?=$content->financial_expenses;?></td>
						<td><?=$content->income_other_concept;?></td>
						<td><?=$content->industry;?></td>
						<td><?=$content->image;?></td>
						<td class="text-end">
							<div>
								<a class="btn btn-azul btn-sm" href="<?php echo $this->route;?>/manage?id=<?= $id ?>"  data-bs-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-pen-alt"></i></a>
								<span  data-bs-toggle="tooltip" data-placement="top" title="Eliminar"><a class="btn btn-rojo btn-sm"  data-bs-toggle="modal" data-bs-target="#modal<?= $id ?>"  ><i class="fas fa-trash-alt" ></i></a></span>
							</div>
							<!-- Modal -->
							<div class="modal fade text-left" id="modal<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							  	<div class="modal-dialog" role="document">
							    	<div class="modal-content">
							      		<div class="modal-header">
							        		<h4 class="modal-title" id="myModalLabel">Eliminar Registro</h4>
							        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							      	</div>
							      	<div class="modal-body">
							        	<div class="">¿Esta seguro de eliminar este registro?</div>
							      	</div>
								      <div class="modal-footer">
								        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
								        	<a class="btn btn-danger" href="<?php echo $this->route;?>/delete?id=<?= $id ?>&csrf=<?= $this->csrf;?><?php echo ''; ?>" >Eliminar</a>
								      </div>
							    	</div>
							  	</div>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<input type="hidden" id="csrf" value="<?php echo $this->csrf ?>"><input type="hidden" id="page-route" value="<?php echo $this->route; ?>/changepage">
	</div>
	 <div align="center">
		<ul class="pagination justify-content-center">
	    <?php
	    	$url = $this->route;
	        if ($this->totalpages > 1) {
	            if ($this->page != 1)
	                echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.($this->page-1).'"> &laquo; Anterior </a></li>';
	            for ($i=1;$i<=$this->totalpages;$i++) {
	                if ($this->page == $i)
	                    echo '<li class="active page-item"><a class="page-link">'.$this->page.'</a></li>';
	                else
	                    echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.$i.'">'.$i.'</a></li>  ';
	            }
	            if ($this->page != $this->totalpages)
	                echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.($this->page+1).'">Siguiente &raquo;</a></li>';
	        }
	  	?>
	  	</ul>
	</div>
</div>