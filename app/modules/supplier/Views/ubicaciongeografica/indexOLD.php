
<div class="container" style="margin-left: 19%;">

<form class="supplier-register-form form-bx">
  <!-- Vue: @submit.prevent="submitLegalRepresentative" -->

  <div class="text-end mb-2" style="display: none;" id="section-progress-cert">
    Haz completado el <span class="completitud" id="completitud8">-%</span> de esta sección
  </div>

  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Ubicación geográfica</span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div>

  <div class="row">

    <div class="col-md-6">
      <div class="mb-3">
        <label for="buscador" class="form-label ">Buscar por nombre<span></span></label>
        
        <div class="row">

        	<div class="col-lg-8">
		        <select class="form-control select2" id="buscador" name="buscador" required>
		          <option value="" disabled selected>Seleccione una ubicación</option>
		          <?php foreach($this->items as $value){ ?>
		          	<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
		          <?php } ?>
		        </select>        		
        	</div>
        	<div class="col-lg-1">
        		<button type="submit" onclick="agregaritem();" class="btn btn-primary">Agregar</button>
        	</div>
        </div>
               
      </div>
    </div>


    <div class="col-md-6">
      <div class="mb-3">
      	<label for="buscador" class="form-label ">Buscar por región<span></span></label>



<style>
	.dropdown .dropdown-menu{
		width: 80%;
	}

	.dropdown-menu li{
		display: flex;
	}

	.dropdown .dropdown-item{
		width: 80%;
		white-space: break-spaces;
	}

	.dropdown button{
		max-height: 32px;
	}


</style>

<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="false" onclick="$('.regiones').show(); $('.paises').hide(); $('.estados').hide();  $('.ciudades').hide()">
    Seleccionar
  </button>
  <ul class="dropdown-menu">
  	<?php foreach($this->regiones as $region){ ?>
  		<?php if($region!=""){ ?>
    		<li class="mb-1 regiones"><a class="dropdown-item" onclick="$('.regiones').hide(); $('.paises').hide(); $('.pais_<?php echo md5($region);?>').show(); "><?php echo $region; ?></a> <button type="button" class="btn btn-sm btn-primary" onclick="agregar('<?php echo $region; ?>');">Agregar</button></li>
    	

    		<?php $paises = $this->pais_region[$region]; ?>
    		<?php foreach($paises as $pais){ ?>
    			<li class="mb-1 paises pais_<?php echo md5($region); ?>" style="display:none;"><a class="dropdown-item" href="#" onclick="$('.paises').hide(); $('.estado_<?php echo md5($pais['name']);?>').show();"><?php echo $pais['name']; ?></a> <button type="button" class="btn btn-sm btn-primary" onclick="agregar('<?php echo $pais['name']; ?>');">Agregar</button></li>

	    		<?php $estados = $pais['states']; ?>
	    		<?php foreach($estados as $estado){ ?>
	    			<li class="mb-1 estados estado_<?php echo md5($pais['name']); ?>" style="display:none;"><a class="dropdown-item" href="#" onclick="$('.estados').hide(); $('.ciudad_<?php echo md5($estado['name']);?>').show();"><?php echo $estado['name']; ?></a> <button type="button" class="btn btn-sm btn-primary" onclick="agregar('<?php echo $estado['name']; ?>');">Agregar</button></li> 

	    			<?php if(1==0){?>
  		    		<?php $ciudades = $estado['cities']; ?>
  		    		<?php foreach($ciudades as $ciudad){ ?>
  		    			<li class="mb-1 ciudades ciudad_<?php echo md5($estado['name']); ?>" style="display:none;"><a class="dropdown-item" href="#"><?php echo $ciudad['name']; ?></a> <button type="button" class="btn btn-sm btn-primary" onclick="agregar('<?php echo $ciudad['name']; ?>');">Agregar</button></li> 
  		    		<?php } ?> 
		    		<?php } ?> 

	    		<?php } ?> 

    		<?php } ?>

    	<?php } ?>
  	<?php } ?>


  </ul>
</div>



      </div>   

  	</div>

  </div>


</form>

</div>


<script type="text/javascript">
$("#buscador").select2({ placeholder: "Buscar", minimumInputLength:3 });	
</script>



<style>
.select2-container .select2-selection--single {
    height: auto !important;
    border-color: rgb(172, 172, 172) !important;
    border-image: initial !important;
    border-radius: 0 !important;

    padding: 8px 15px;
    margin-bottom: 10px;
    border-radius: 0;
    font-size: 1em !important;

}  
</style>