<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form action="<?php echo $this->route; ?>" method="post">
        <div class="content-dashboard">
            <div class="row">
				<div class="col-3">
		            <label>documentType</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="documentType" value="<?php echo $this->getObjectVariable($this->filters, 'documentType') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>nit</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="nit" value="<?php echo $this->getObjectVariable($this->filters, 'nit') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>name</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="name" value="<?php echo $this->getObjectVariable($this->filters, 'name') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>lastname</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="lastname" value="<?php echo $this->getObjectVariable($this->filters, 'lastname') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>email</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="email" value="<?php echo $this->getObjectVariable($this->filters, 'email') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>email_verified_at</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="email_verified_at" value="<?php echo $this->getObjectVariable($this->filters, 'email_verified_at') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>bussinesEmail</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="bussinesEmail" value="<?php echo $this->getObjectVariable($this->filters, 'bussinesEmail') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>phone</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="phone" value="<?php echo $this->getObjectVariable($this->filters, 'phone') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>whatsapp</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="whatsapp" value="<?php echo $this->getObjectVariable($this->filters, 'whatsapp') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>phoneCode</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="phoneCode" value="<?php echo $this->getObjectVariable($this->filters, 'phoneCode') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>company</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="company" value="<?php echo $this->getObjectVariable($this->filters, 'company') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>position</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="position" value="<?php echo $this->getObjectVariable($this->filters, 'position') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>area</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="area" value="<?php echo $this->getObjectVariable($this->filters, 'area') ?>"></input>
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
		            <label>city</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="city" value="<?php echo $this->getObjectVariable($this->filters, 'city') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>password</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="password" value="<?php echo $this->getObjectVariable($this->filters, 'password') ?>"></input>
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
		            <label>rut</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="rut" value="<?php echo $this->getObjectVariable($this->filters, 'rut') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>commerce</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="commerce" value="<?php echo $this->getObjectVariable($this->filters, 'commerce') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>industry_id</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="industry_id" value="<?php echo $this->getObjectVariable($this->filters, 'industry_id') ?>"></input>
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
		            <label>company_nit</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="company_nit" value="<?php echo $this->getObjectVariable($this->filters, 'company_nit') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>nit_type</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="nit_type" value="<?php echo $this->getObjectVariable($this->filters, 'nit_type') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>company_country</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="company_country" value="<?php echo $this->getObjectVariable($this->filters, 'company_country') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>company_state</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="company_state" value="<?php echo $this->getObjectVariable($this->filters, 'company_state') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>company_city</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="company_city" value="<?php echo $this->getObjectVariable($this->filters, 'company_city') ?>"></input>
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
					<td>documentType</td>
					<td>nit</td>
					<td>name</td>
					<td>lastname</td>
					<td>email</td>
					<td>email_verified_at</td>
					<td>bussinesEmail</td>
					<td>phone</td>
					<td>whatsapp</td>
					<td>phoneCode</td>
					<td>company</td>
					<td>position</td>
					<td>area</td>
					<td>country</td>
					<td>city</td>
					<td>password</td>
					<td>created_at</td>
					<td>updated_at</td>
					<td>rut</td>
					<td>commerce</td>
					<td>industry_id</td>
					<td>state</td>
					<td>company_nit</td>
					<td>nit_type</td>
					<td>company_country</td>
					<td>company_state</td>
					<td>company_city</td>
					<td width="100"></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->lists as $content){ ?>
				<?php $id =  $content->id; ?>
					<tr>
						<td><?=$content->documentType;?></td>
						<td><?=$content->nit;?></td>
						<td><?=$content->name;?></td>
						<td><?=$content->lastname;?></td>
						<td><?=$content->email;?></td>
						<td><?=$content->email_verified_at;?></td>
						<td><?=$content->bussinesEmail;?></td>
						<td><?=$content->phone;?></td>
						<td><?=$content->whatsapp;?></td>
						<td><?=$content->phoneCode;?></td>
						<td><?=$content->company;?></td>
						<td><?=$content->position;?></td>
						<td><?=$content->area;?></td>
						<td><?=$content->country;?></td>
						<td><?=$content->city;?></td>
						<td><?=$content->password;?></td>
						<td><?=$content->created_at;?></td>
						<td><?=$content->updated_at;?></td>
						<td><?=$content->rut;?></td>
						<td><?=$content->commerce;?></td>
						<td><?=$content->industry_id;?></td>
						<td><?=$content->state;?></td>
						<td><?=$content->company_nit;?></td>
						<td><?=$content->nit_type;?></td>
						<td><?=$content->company_country;?></td>
						<td><?=$content->company_state;?></td>
						<td><?=$content->company_city;?></td>
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