<script src="/skins/page/js/profile-submit-form.js"></script>

    <div class="profile-documents-form-container mt-0 border-top-0" v-if="activeTab == 'documents'">
      <form action="/page/profile/save_documents" class="profile-form row" method="post" enctype="multipart/form-data" id="documentsForm">
        <!-- Sección de Empresa -->
        <div class="form-section">
          <div class="col-12">
            <div class="row">
              <div class="form-group col-lg-6">
                <label for="rut">Cargar RUT</label>
                <input type="file" id="rut" name="rut" class="form-control mt-2"
                   accept="application/pdf, image/*" />
                <div class="file-links-bx">
                  <a href="/files/<?php echo $this->content->rut; ?>" target="_blank" class="file-link" id="enlace_rut"> <i
                      class="fa-solid fa-file"></i> Ver archivo actual <i
                      class="fa-solid fa-arrow-down download-icon"></i></a>
                </div>
              </div>

              <!-- Campo para subir archivo de comercio -->
              <div class="form-group col-lg-6">
                <label for="commerce">Cargar cámara de comercio</label>
                <input type="file" id="commerce" name="commerce" class="form-control mt-2"
                   accept="application/pdf, image/*" />
                <div class="file-links-bx">
                  <a href="/files/<?php echo $this->content->commerce; ?>" target="_blank" class="file-link" id="enlace_commerce"> <i
                      class="fa-solid fa-file"></i> Ver archivo actual <i
                      class="fa-solid fa-arrow-down download-icon"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Botón para enviar el formulario de perfil -->
        <div class="form-group form-submit wk-right">
          <button type="submit" class="bg-orange text-white px-4 py-2" id="btnSubmit_documents">
            Actualizar Documentos
          </button>
        </div>
      </form>
    </div>