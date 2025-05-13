
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
					<label class="control-label">segment_id</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  " ><i class="far fa-list-alt"></i></span>
						</div>
						<select class="form-control" name="segment_id"   >
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_segment_id AS $key => $value ){?>
								<option <?php if($this->getObjectVariable($this->content,"segment_id") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
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
				<div class="col-12 form-group">
					<label class="control-label">industry_id</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  " ><i class="far fa-list-alt"></i></span>
						</div>
						<select class="form-control" name="industry_id"   >
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_industry_id AS $key => $value ){?>
								<option <?php if($this->getObjectVariable($this->content,"industry_id") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
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