
<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform;?>"  data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->id; ?>" />
			<?php }?>
			<div class="row">
				<div class="col-12 form-group">
					<label for="country"  class="control-label">country</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->country; ?>" name="country" id="country" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="bank"  class="control-label">bank</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->bank; ?>" name="bank" id="bank" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="office"  class="control-label">office</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->office; ?>" name="office" id="office" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="account_type"  class="control-label">account_type</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->account_type; ?>" name="account_type" id="account_type" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="account_number"  class="control-label">account_number</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->account_number; ?>" name="account_number" id="account_number" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="holder"  class="control-label">holder</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->holder; ?>" name="holder" id="holder" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="account_certificate"  class="control-label">account_certificate</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->account_certificate; ?>" name="account_certificate" id="account_certificate" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="account_certificate_udate"  class="control-label">account_certificate_udate</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->account_certificate_udate; ?>" name="account_certificate_udate" id="account_certificate_udate" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="swift_number"  class="control-label">swift_number</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->swift_number; ?>" name="swift_number" id="swift_number" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="routing_number"  class="control-label">routing_number</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->routing_number; ?>" name="routing_number" id="routing_number" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="iban"  class="control-label">iban</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->iban; ?>" name="iban" id="iban" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="bic"  class="control-label">bic</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->bic; ?>" name="bic" id="bic" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="intermediary_bank"  class="control-label">intermediary_bank</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->intermediary_bank; ?>" name="intermediary_bank" id="intermediary_bank" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label class="control-label">supplier_id</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  " ><i class="far fa-list-alt"></i></span>
						</div>
						<select class="form-control" name="supplier_id"   >
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_supplier_id AS $key => $value ){?>
								<option <?php if($this->getObjectVariable($this->content,"supplier_id") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="created_at"  class="control-label">created_at</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->created_at; ?>" name="created_at" id="created_at" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="updated_at"  class="control-label">updated_at</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->updated_at; ?>" name="updated_at" id="updated_at" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>