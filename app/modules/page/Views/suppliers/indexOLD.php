<div class="container-fluid">
  <div class="section-title">
    <h5>
      <i class="fas fa-industry"></i>
      Buscador de proveedores
    </h5>
  </div>

  <form action="/page/suppliers/?page=1" method="post">
    <div class="p-5 py-2">
      <div class="row">
        <div class="col-md-12">
          <!-- <h3 class="title title-2 primary">Proveedores</h3> -->
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex w-100">
              <div class="row w-100 align-items-end">
                <div class="col-12">
                  <div class="d-flex justify-content-center">
                    <div class="col-md-6">
                      <!-- Boton de buscar -->
                      <div class="input-group my-3">
                        <button @click="search" class="input-group-text" id="basic-addon1">
                          <i class="fas fa-search"></i>
                        </button>
                        <input type="text" class="form-control py-2" placeholder="Busca por palabras clave" name="keyWords" value="<?php echo $this->getObjectVariable($this->filters, 'keyWords') ?>"  />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-3 col-lg-3">
                  <label for="">Industria</label>
                  <select class="form-control" name="industry" id="industry"  placeholder="Selecciona una opción" onchange="get_segmentos();" >
                    <option value=""></option>
                    <?php foreach($this->list_industry as $key => $industry){ ?>
                      <option value="<?php echo $key; ?>" <?php if($this->getObjectVariable($this->filters, 'industry')==$key){ echo 'selected'; }?>><?php echo $industry; ?></option>
                    <?php }?>
                  </select>
                </div>

                <div class="col-md-3 col-lg-3">
                  <label for="">Segmentos</label>
                  <select class="form-control" name="segments" id="segments" placeholder="Selecciona uno o más segmentos" >
                  </select>
                </div>

                <div class="col-md-3 col-lg-3">
                  <label for="">País</label>
                  <select class="form-control" name="country" id="country" onchange="filtrar_ciudad();">
                    <option value="" disabled selected>Seleccione un país</option>
                    <?php foreach($this->countries as $country){ ?>
                      <option value="<?php echo $country['name']; ?>" <?php if($this->getObjectVariable($this->filters, 'country')==$country['name']){ echo 'selected'; }?>><?php echo $country['name']; ?></option>
                    <?php }?>
                  </select>
                </div>

                <div class="col-md-3 col-lg-3">
                  <label for="">Ciudad</label>
                  <select class="form-control" name="city" id="city">
                    <option value="" disabled selected>Seleccione una ciudad</option>
                  </select>
                </div> 


                <div class="col-md-3 col-lg-3">
                  <label for="">Tipo de empresa</label>
                  <select class="form-control" name="is_legal_entity" id="is_legal_entity">
                    <option value=""  >Seleccione un tipo</option>
                      <option value="1" <?php if($this->getObjectVariable($this->filters, 'is_legal_entity')==1){ echo 'selected'; }?>>Natural</option>
                      <option value="2" <?php if($this->getObjectVariable($this->filters, 'is_legal_entity')==2){ echo 'selected'; }?>>Jurídica</option>
                  </select>
                </div>

                <div class="col-md-3 col-lg-3">
                  <label for="">Status del perfil</label>
                  <select class="form-control" name="completeness" id="completeness">
                    <option value=""  >Seleccione un tipo</option>
                      <option value="1" <?php if($this->getObjectVariable($this->filters, 'completeness')==1){ echo 'selected'; }?>>Completo</option>
                      <option value="2" <?php if($this->getObjectVariable($this->filters, 'completeness')==2){ echo 'selected'; }?>>En progreso</option>
                  </select>
                </div>                

                <div class="d-flex justify-content-center">
                  <div class="col-md-2 col-3 ps-0 mt-3">
                    <label for="">
                      <br />
                    </label>
                    <button class="form-btn w-100 btn btn-primary" type="submit">Buscar</button>
                  </div>
                  <div class="col-md-2 col-5 ps-1 pe-0 mt-3">
                    <label for="">
                      <br />
                    </label>
                    <a href="<?php echo $this->route;?>?page=1&cleanfilter=1"><button class="secondary-btn w-100 btn" type="button">Limpiar filtros</button>
                  </div>
                </div>
              </div>
            </div>
            <a id="page" name="page"></a>
          </div>

          <?php
          $total = $this->pages;
          if($this->register_number<$total){
            $total = $this->register_number;
          }
          ?>
          
          <div class="col-12 pagination d-flex justify-content-between align-items-center mt-4">
            <div>
              <span>
                Mostrando <?php echo $total; ?> de <?php echo $this->register_number; ?> proveedores.
              </span>
            </div>
            <div>
              <button class="btn" type="button" onclick="anterior()">
                <i class="fa-solid fa-chevron-left"></i>
              </button>
              <span class="mx-2">Página <?php echo $this->page; ?> de <?php echo $this->totalpages; ?></span>
              <button class="btn" type="button" onclick="siguiente()">
                <i class="fa-solid fa-chevron-right" ></i>
              </button>
            </div>
          </div>

          <div class="card mb-2">
            <div class="card-body" style="background-color: #377abe; color: #FFF;">
              <div class="row">
                <div class="col-3">
                  <h4><strong>Empresa</strong></h4>
                </div>
                <div class="col-6">
                  <h4><strong>Descripción</strong></h4>
                </div>
                <div class="col-3">
                  <h4><strong></strong></h4>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
         

            <?php foreach($this->lists as $supplier){ ?>
            
            <div class="supplier-card col-12 mb-2">

              <div class="card">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-3" style="cursor: pointer;" @click="openDetailModal(supplier)">
                      <div class="card-title">
                        <div class="image-container1 logo_company">

                          <i class="fa-solid fa-medal medalla <?php if($supplier->user->completeness=="100"){ echo 'verde'; } ?>" <?php if($supplier->user->completeness=="100"){ echo 'title="Actualizado"'; } else { echo 'title="En proceso"'; } ?> data-bs-toggle="tooltip" data-bs-placement="top" ></i>

                          <?php if($supplier->image==""){ ?>
                            <img src="https://plus.unsplash.com/premium_photo-1661914978519-52a11fe159a7?q=80&w=1935&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D">
                          <?php } else { ?>
                            <img src="/images/<?php echo $supplier->image; ?>" alt="" />
                          <?php } ?>

                          
                        </div>
                        <h5 class="company_title font-bold text-slate-600"><?php echo $supplier->company_name ?><br>
                        <span class="country"><?php echo $supplier->country ?> - <?php echo $supplier->city ?></span></h5>
                      </div>
                    </div>
                    <div class="col-6">

                        <div class="card-text leading-5">
                          <div class="description" >
                            <b>Descripción:</b><br>
                            <?php echo $supplier->commercial_activity ?>
                          </div>

                          <div class="description">
                            <b>Cobertura geográfica:</b>
                            <?php foreach($supplier->geolocations as $key_geo => $geolocation){
                              echo $geolocation->name;
                              if($key_geo+1 < count((array)$supplier->geolocations)){ echo ', '; }
                            } ?>
                          </div>


                          <div class="description">
                            <b>Experiencia por sector:</b>
                            <?php foreach($supplier->experiencias as $key_exp => $experiencia){
                              echo $experiencia;
                              if($key_exp+1 < count((array)$supplier->experiencias)){ echo ', '; }
                            } ?>
                          </div>                          

                        </div>



                    </div>
                    <div class="col-3">
                      <div class="card-bottom">
                        <div class="card-buttons">

                          <button type="button" class="btn btn-sm btn-primary fondo_naranja w-100 mb-2" data-bs-toggle="modal" data-bs-target="#modal_proveedor<?php echo $supplier->id; ?>"> <i class="fa-solid fa-eye margin-eye"></i> Vista rápida</button>
                          </button>                          
                

                          <button type="button" class="btn btn-sm btn-primary w-100" @click="openModal(supplier.id)">
                            Contactar Proveedor
                          </button>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="modal fade" id="modal_proveedor<?php echo $supplier->id; ?>" tabindex="-1" aria-labelledby="modal_proveedor<?php echo $supplier->id; ?>Label" aria-hidden="true">
              <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content cv-modal">
                  <div class="modal-header" align="right">
                    <a target="_blank" href="/detail/<?php echo $supplier->company_name; ?>/" title="Ver perfil completo" class="boton_expandir" data-bs-toggle="tooltip" data-bs-placement="top" ><i class="fa-solid fa-expand"></i></a>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">

                    <div class="cv-container">
                      <div class="cv-header">
                        <div class="cv-banner">
                          <div class="banner-bg">
                          </div>
                          <div class="banner-logo">
                            <?php if($supplier->image!=""){ ?>
                              <img v-if="supplier.image" src="/images/<?php echo $supplier->image; ?>" alt="Logo del proveedor" class="" />
                            <?php }else{ ?>
                              <img src="https://plus.unsplash.com/premium_photo-1661914978519-52a11fe159a7?q=80&w=1935&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                              class="" alt="" />
                            <?php } ?>
                          </div>
                          <div class="banner-social">
                            <?php if($supplier->facebook || $supplier->twitter || $supplier->instagram || $supplier->linkedin){ ?>
                              <span>Siguenos</span>
                            <?php } ?>
                            <?php if($supplier->facebook){ ?>
                              <a href="<?php echo $supplier->facebook ?>" target="_blank" class="social-link">
                                <i class="fa-brands fa-facebook"></i>
                              </a>
                            <?php } ?>
                            <?php if($supplier->twitter){ ?>
                              <a href="<?php echo $supplier->twitter ?>" target="_blank" class="social-link">
                                <i class="fa-brands fa-x-twitter"></i>
                              </a>
                            <?php } ?>
                            <?php if($supplier->instagram){ ?>
                              <a href="<?php echo $supplier->instagram ?>" target="_blank" class="social-link">
                                <i class="fa-brands fa-instagram"></i>
                              </a>
                            <?php } ?>
                            <?php if($supplier->linkedin){ ?>
                              <a href="<?php echo $supplier->linkedin ?>" target="_blank" class="social-link">
                                <i class="fa-brands fa-linkedin"></i>
                              </a>
                            <?php } ?>
                          </div>
                        </div>
                        <div class="cv-header-info">
                          <div class="row">
                            <div class="col-12">
                              <h4 class="cv-name"><?php echo  $supplier->company_name ?></h4>
                            </div>
                            <div class="col-12">
                              <div class="cv-nit">NIT: <?php echo  $supplier->identification_nit ?></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row mt-4">
                        <div class="col-md-7">
                          <div class="cv-bx">
                            <div class="row">
                              <div class="col-12">
                                <h4 class="cv-title">
                                  Información principal
                                </h4>
                              </div>
                              <div class="col-12">
                                <p class="cv-description">
                                  <b>Actividades:</b><br>
                                  <div v-html="supplier.commercial_activity"></div>
                                </p>
                                <p class="cv-description">
                                  <b>Ubicaciones:</b><br>
                                  <?php echo  $supplier->ubicaciones ?></p>
                                <p class="cv-description">
                                  <b>Cobertura:</b><br>
                                  <?php echo  $supplier->cobertura ?></p>
                                <p class="cv-description">
                                  <b>Certificaciones:</b><br>
                                  <?php echo  $supplier->certificaciones ?></p> 
                                <p class="cv-description">
                                  <b>Tipo de clientes:</b><br>
                                  <span v-if="supplier.counterparty_type=='1'">Nacional</span>
                                  <span v-if="supplier.counterparty_type=='2'">Extranjero</span>
                                </p>
                                <p class="cv-description">
                                  <b>Tipo de empresa:</b><br>
                                  <?php echo  $supplier->company_type ?></p>       
                              </div>



                            </div>
                          </div>
                        </div>
                        
                        <div class="col-md-5">
                          <div class="cv-bx px-4">
                            <div class="row">
                              <div class="col-12">
                                <h4 class="cv-title">
                                  Información de contacto
                                </h4>
                              </div>
                              <div class="col-12">
                                <p class="cv-contact-row">
                                  <i class="fa-regular fa-user"></i> <?php echo  $supplier->user->name ?>
                                </p>
                                <p class="cv-contact-row">
                                  <i class="fa-solid fa-phone"></i> <?php echo  $supplier->user->phone ?>
                                </p>
                                <p class="cv-contact-row">
                                  <i class="fa-solid fa-envelope"></i> <?php echo  $supplier->primary_email ?>
                                </p>
                                <p class="cv-contact-row">
                                  <i class="fa-solid fa-location-dot"></i> <?php echo  $supplier->main_address ?> <span v-if="supplier.city">, <?php echo  $supplier->city ?></span> <span v-if="supplier.country">, <?php echo  $supplier->country ?></span>
                                </p>
                                <p class="cv-contact-row">
                                  <i class="fa-solid fa-globe"></i> <a :href="supplier.website"><?php echo  $supplier->website ?></a>
                                </p>
                              </div>


                            </div>
                          </div>
                        </div>

                        <div class="col-md-12 mt-4">
                          <div class="cv-bx px-4">
                            <div class="row">
                              <div class="col-12">
                                <h4 class="cv-title">
                                  Industria y segmentos
                                </h4>
                              </div>
                              <div class="col-12">
                                <span class="segments">
                                  
                                  <?php foreach($supplier->industries as $industry){ ?>
                                  <span class="badge rounded-pill text-dark border-2 border-info bg-cyan-200/50 me-1 mb-2">
                                    <?php echo $industry->name; ?>
                                  </span>
                                  <?php } ?>

                                  <?php foreach($supplier->segments as $segment){ ?>
                                  <span class="badge rounded-pill text-dark border-2 border-info bg-cyan-200/50 me-1 mb-2">
                                    <?php echo $segment->name; ?>
                                  </span>
                                  <?php } ?>
                                </span>
                              </div>


                            </div>
                          </div>
                        </div>

                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>


            <?php } ?>
          </div>

          <?php if($this->register_number==0){ ?>
            <div class="row">
              <div class="col-12">
                <div class="alert alert-info">
                  No se encontraron proveedores con los filtros seleccionados.
                </div>
              </div>
            </div>
          <?php } ?>

          <div class="col-12 pagination d-flex justify-content-between align-items-center mt-4">
            <div>
              <span>
                Mostrando <?php echo $total; ?> de <?php echo $this->register_number; ?> proveedores.
              </span>
            </div>
            <div>
              <button class="btn" type="button" onclick="anterior()">
                <i class="fa-solid fa-chevron-left"></i>
              </button>
              <span class="mx-2">Página <?php echo $this->page; ?> de <?php echo $this->totalpages; ?></span>
              <button class="btn">
                <i class="fa-solid fa-chevron-right" type="button" onclick="siguiente()"></i>
              </button>
            </div>
          </div>


        </div>
      </div>
    </div>
  </form>

  <!-- Modal -->

    <?php if(1==0){?>

    <div class="modal fade" v-if="showModal" :class="{ show: showModal }" tabindex="-1" role="dialog"
      style="display: block" @click.self="closeModal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Contactar Proveedor
            </h5>
            <button type="button" class="btn-close" @click="closeModal"></button>
          </div>
          <div class="modal-body">
            <ContactSupplierForm :clientId="userInfo.client.id" :supplierId="activeSupplier" @closeModal="closeModal" />
          </div>
        </div>
      </div>
    </div>





    <?php }?>



</div>




<style>
/* Transición para el modal */
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.3s ease;
}

.modal-fade-enter,
.modal-fade-leave-to {
  opacity: 0;
}

/* Transición para el backdrop del modal */
.backdrop-fade-enter-active,
.backdrop-fade-leave-active {
  transition: opacity 0.3s ease;
}

.backdrop-fade-enter,
.backdrop-fade-leave-to {
  opacity: 0;
}

.pagination {
  margin-bottom: 10px;
}

.pagination .btn {
  background-color: #f77904;
  border-radius: 0;
  color: #FFF;
}
.recommend .card{
  border: 2px solid #f77904;
  position: relative;
}

.supplier-card .card{
  background-color:#f6f6f6;
  --bs-card-bg: #f6f6f6;
  background-color: #f6f6f6;
}

.recommend button{
  background-color: #f77904 !important;
}
.recommend .recommend-tag{
  position: absolute;
  display: block;
  top: 0;
  right: 0;
  background-color: #f77904;
  color: #FFF;
  font-size: 12px;
  padding: 5px;
  border-radius: 0 0 0 5px;
}

.logo_company{
  background-color:#FFFFFF;
  border-radius:5px;
  padding: 10px;
  width: 120px;
  height: 120px;
  display: flex;
  justify-content: center;
  align-items: center;    
}

.logo_company img{
  max-width: 100%;
  max-height: 100px;
  margin-left: auto;
  margin-right: auto;
}

.company_title{
  font-size: 14px;
  max-width:150px;
}

.description {
  max-height: 140px;
  max-height: 83px;
  overflow:hidden;
  font-size: 13px;
  text-align: left;
}

.supplier-card .card-bottom .card-buttons .btn-primary {
  padding:10px 10px;
}
.supplier-card .card-bottom .card-buttons {
  min-width: 161px;
}
.rounded-pill {
  white-space:break-spaces;
}
.supplier-card .card-text .description {
  text-align: left;
}

.ver_perfil {
  text-decoration:underline;
  font-size: 12px;
  cursor: pointer;
}

.supplier-card .country {
  color: #6e6e6e;
  font-weight: 700;
  font-size: 13px;
  color: #aaa;
}

.caja_detalle {
  width: 30px;
  position: absolute;
  top: 99px;
  text-align: center;
  border-left:1px solid;
  height: 30px;
  left: 95.5%;
}

.caja_detalle i{
  margin-top: 7px;
}

.borde-izq{
  border-left:1px solid white !important;
  width: 40px;
}

.ancho_ver_perfil{
  width: 123px;
}

.supplier-card .segments {
  height: 122px;
  overflow:hidden;
}

.fondo_naranja{
  background-color:#f77904 !important;
}

.boton_expandir{
  position: absolute;
  top: 24px;
  right: 53px;
  *filter: invert(1);
  opacity: 1;

  top: 12px;
  right: 44px;


}
.boton_expandir i{
  font-size: 22px;
}


.card-body h4{
  font-size: 15px;
  margin-bottom: 0px;
}
.form-btn {
  background-color: #23366c;
  color: #fff;
  padding: 6px 20px;
  border: 1px solid #23366c;
  border-radius: 0;
  cursor: pointer;
  transition: all .3s ease;
}
.secondary-btn {
  background-color: #fff;
  color: #6e6e6e;
  padding: 6px 20px;
  border: 1px solid #6e6e6e;
  border-radius: 0;
  cursor: pointer;
  transition: all .3s ease;
}
.supplier-card .card-bottom .card-buttons .btn-primary {
  background-color: #23366c;
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 0;
  cursor: pointer;
  transition: all .3s ease;
}
.fondo_naranja {
  background-color: #f77904 !important;
}

.margin-eye{
  margin-right: 6px;
}

.medalla {
  position: absolute;
  left: 102px;
  z-index: 1;
  top: 2px;
  font-size: 20px;
  color: orange;
}

.medalla .verde{
  color: green;
}


</style>

<style scoped>
.supplier-info {
  font-family: Arial, sans-serif;
  padding: 20px;
  background-color: #fff;
  border-radius: 8px;
  max-width: 800px;
  margin: 20px auto;
  line-height: 1.6;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.supplier-header {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
}

.supplier-logo {
  width: 80px;
  height: auto;
  margin-right: 20px;
  border-radius: 8px;
  object-fit: contain;
}

.header-text {
  flex: 1;
}

.supplier-header h1 {
  font-size: 24px;
  margin-bottom: 5px;
}

.supplier-header p {
  font-size: 14px;
  color: #7f8c8d;
}

h3 {
  color: #34495e;
  margin-bottom: 10px;
  font-size: 18px;
}

.details-column {
  display: inline-block;
  vertical-align: top;
  width: 45%;
  padding-right: 20px;
}

p {
  font-size: 14px;
  color: #2c3e50;
  margin-bottom: 10px;
}

a {
  color: #3498db;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}

.supplier-address {
  margin-top: 20px;
}

.social-link{
  background: #f77904;
  height: 27px;
  padding: 3px;
  border-radius: 50%;  
  color: #FFFFFF;
  width: 29px;
  text-align: center;
  font-size: 20px;
}
.social-link i{
  vertical-align: text-top;
}
.cv-modal .cv-container .cv-header .cv-banner{
  height: 250px;
}

.cv-modal .cv-container .cv-header .cv-banner .banner-social i:hover {
  color: #377abe;
}
.cv-modal .cv-container .cv-header .cv-banner .banner-logo {
  width: 180px;
  height: 180px;
  overflow: hidden;
  margin-top: -90px;
  margin-left: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 10px;
  background-color: #fff;
  box-shadow: 0 10px 10px 5px #00000020;
}
.cv-modal .cv-container .cv-header .cv-banner .banner-logo img {
  max-width: 100%;
  height: auto;
  object-fit: contain;
}
.cv-modal .cv-container .cv-header .cv-banner .banner-bg {
  background-color: #377abe;
  width: 100%;
  height: 150px;
  border-radius: 10px 10px 0 0;
}

.cv-modal .cv-container .cv-header .cv-banner .banner-social {
  display: flex;
  gap: 10px;
  padding: 15px 40px;
  justify-content: end;
  top: -78px;
}
.cv-modal .cv-container .cv-bx {
  border-radius: 10px;
  padding: 20px 40px;
  box-shadow: 0 0 10px 1px #00000030;
  height: 100%;
}
.cv-modal .cv-container .cv-header {
  border-radius: 10px;
  box-shadow: 0 0 10px 5px #00000020;
}
.cv-modal .cv-container .cv-header .cv-header-info {
  padding: 20px 40px;
}
.cv-modal .cv-container .cv-header .cv-header-info .cv-name {
  color: #23366c;
  font-size: 1.7rem;
  font-weight: bolder;
}
.cv-modal .cv-container .cv-bx .cv-title {
  color: #204697;
  font-weight: bolder;
  font-size: 1.2rem;
  margin-bottom: 15px;
}
.cv-modal .cv-container .cv-header .cv-header-info .cv-nit {
  color: #6e6e6e;
  font-size: 1rem;
}
.cv-modal .cv-container .cv-bx .cv-description {
  color: #6e6e6e;
  font-size: 1rem;
  line-height: 1.4;
}
</style>

<script type="text/javascript">
  function get_segmentos(){
    var industrias = $("#industry").val();
    $.post("/page/suppliers/get_segmentos/",{"industrias":industrias },function(res){
      if(res.opciones!=""){
        $("#segments").html(res.opciones);
      }
    });
  }

  get_segmentos();

  function filtrar_ciudad(){
    var pais = $("#country").val();
    $.post("/page/suppliers/get_ciudades/",{"pais":pais },function(res){
      if(res.opciones!=""){
        $("#city").html(res.ciudades);
      }
    });
  }  

  filtrar_ciudad();

  function anterior(){
    var page = Number('<?php echo $this->page; ?>');
    if(page>1){
      page=page-1;
      window.location="/page/suppliers/?page="+page+"#page";
    }
  }

  function siguiente(){
    var page = Number('<?php echo $this->page; ?>');
    var total = Number('<?php echo $this->totalpages; ?>');
    if(page<total){
      page=page+1;
      window.location="/page/suppliers/?page="+page+"#page";
    }
  }  
</script>