<template>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuthor() && !id_curso">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Cursos</h3>

                        <div class="card-tools">
                             <button class="btn btn-success" @click="newModal">Agregar Curso <i class="fas fa-user-plus fa-fw"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        Tipo
                        <select name="type" v-model="filtro_tipo" id="type" class="form-control">
                            <option value="">Filtrar tipo de curso</option>
                            <option value="1">Cursos cortos</option>
                            <option value="2">Diplomado</option>                            
                        </select>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <th>Curso</th>
                                    <th>Tipo</th>
                                    <th>Categoria</th>
                                    <th>Tutor</th>
                                    <th>Duracion</th>                                    
                                    <th>Estado</th>        
                                    <th>Módulos</th>
                                    <th></th>                        
                                    <!-- <th>Registrado</th>
                                    <th>Modificado</th>-->
                                </tr>
                                <tr v-for="curso in cursos.data" :key="curso.id">
                                    <td>{{curso.id}}</td>
                                    <td>{{curso.nombre}}</td>
                                    <td>{{curso.tipo == '1' ? 'Curso corto' : 'Dipolomado'}}</td>
                                    <td>{{categorias[curso.categoria][0]}}</td>
                                    <td>{{ tutores[curso.tutor][0]}}</td>
                                    <td>{{curso.duracion + ' ' + tipos_duracion[curso.tipo_duracion]}}</td>
                                    <td v-if="curso.estado == '1'" >Activo</td>
                                    <td v-else >Inactivo</td> 
                                    <td>
                                        <button type="button" class="btn btn-info" @click="ver_modulo(curso)">
                                            <i class="fas fa-server"></i>
                                            Modulos
                                        </button>
                                    </td>                              
                                    <!-- <td>{{curso.created_at | myDate}}</td>
                                    <td>{{curso.update_at | myDate}}</td>-->
                                    <td>
                                        <a href="#" @click="editModal(curso)">
                                            <i class="fa fa-edit blue"></i>
                                        </a>
                                        /
                                        <a href="#" @click="borrar(curso.id)">
                                            <i class="fa fa-trash red"></i>
                                        </a>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="cursos" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            <!-- /.card -->
            </div>
        </div>
        <div class="row mt-5" v-if="$gate.isAdminOrAuthor() && id_curso">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Módulos curso: <b>{{curso.nombre}}</b></h3>

                        <div class="card-tools">
                             <button class="btn btn-success" @click="newModalModulo">Agregar Modulo <i class="fas fa-plus fa-fw"></i></button>
                        </div>
                    </div>

                     <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <th>Modulo</th>
                                    <th>Estado</th>
                                    <th>Documentos</th>
                                    <th>Examen</th>
                                    <th></th>               
                                    <!-- <th>Registrado</th>
                                    <th>Modificado</th>-->
                                </tr>
                                <tr v-for="modulo in modulos.data" :key="modulo.id">
                                    <td>{{modulo.id}}</td>
                                    <td>{{modulo.modulo}}</td>                                   
                                    <td v-if="modulo.estado == '1'" >Activo</td>
                                    <td v-else >Inactivo</td> 
                                    <td>
                                        <button type="button" class="btn btn-info" @click="ver_documentos(modulo.id)">
                                            <i class="fas fa-file-alt"></i>
                                            Documentos
                                        </button>
                                    </td>       
                                    <td>
                                        <button type="button" class="btn btn-info" @click="ver_examen(modulo.id)">
                                            <i class="fas fa-graduation-cap"></i>
                                            Examen
                                        </button>
                                    </td>                       
                                    <!-- <td>{{curso.created_at | myDate}}</td>
                                    <td>{{curso.update_at | myDate}}</td>-->
                                    <td>
                                        <a href="#" @click="editModalModulo(modulo)">
                                            <i class="fa fa-edit blue"></i>
                                        </a>
                                        /
                                        <a href="#" @click="borrarModulo(modulo.id)">
                                            <i class="fa fa-trash red"></i>
                                        </a>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="modulos" @pagination-change-page="getResultsModulos"></pagination>
                    </div>
                </div>
            </div>        
        </div>
        <div v-if="!$gate.isAdminOrAuthor()">
            <not-found></not-found>
        </div>
        
        <!-- Modal Cursos-->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Agregar Curso</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Actualizar Curso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? editar() : crear()">
                        <div class="modal-body row">
                            <div class="form-group  col-12 col-sm-6 col-md-6 col-lg-6">
                                <label for='nombre'>Nombre</label>
                                <input v-model="form.nombre" type="text" name="nombre" id="nombre" required
                                    placeholder="Nombre"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('nombre') }">
                                <has-error :form="form" field="nombre"></has-error>
                            </div>

                            <div class="form-group  col-sm-6 col-md-6 col-lg-6">
                                <label for='categoria'>Categoria</label>
                                <select v-model="form.categoria" id="categoria" name="categoria" required
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('categoria') }"
                                >
                                    <option v-for="categoria in categorias" :key="categoria[1]" :value="categoria[1]" v-text="categoria[0]"></option>
                                </select>
                                <has-error :form="form" field="categoria"></has-error>
                            </div>

                            <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6">
                                <label for='tutor'>Tutor</label>
                                <select v-model="form.tutor" id="tutor" name="tutor" required
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('tutor') }"
                                >
                                    <option v-for="tutor in tutores" :key="tutor[1]" :value="tutor[1]" v-text="tutor[0]"></option>
                                </select>
                                <has-error :form="form" field="tutor"></has-error>
                            </div>
                            <div class="form-group  col-6 col-sm-4 col-md-4 col-lg-4">
                                <label for='duracion'>Duración</label>
                                <input v-model="form.duracion" type="number" min='1' name="duracion" id="duracion"
                                    placeholder="Duracion" required
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('duracion') }">
                                <has-error :form="form" field="duracion"></has-error>
                            </div>
                            <div class="form-group col-6 col-sm-2 col-md-2 col-lg-2">     
                                <label for='duracion'>Tipo duración</label>            
                                <select name="tipo_duracion" v-model="form.tipo_duracion" id="tipo_duracion" class="form-control" :class="{ 'is-invalid': form.errors.has('tipo_duracion') }">
                                    
                                    <option value="1">Horas</option>
                                    <option value="2">Dias</option>
                                    <option value="3">Meses</option>
                                </select>
                                
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-12 col-lg-12">
                                <label for='duracion'>Descripción</label>
                                <textarea v-model="form.descripcion" required name="descripcion" id="descripcion"
                                placeholder="Descripcion"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('descripcion') }"></textarea>
                                <has-error :form="form" field="descripcion"></has-error>
                            </div>
                            <div class="form-group  col-6 col-sm-6 col-md-6 col-lg-6">
                                <label for='valor'>Valor</label>
                                <input v-model="form.valor" type="number"  min='1' name="valor" id="valor" required
                                    placeholder="Valor"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('valor') }">
                                <has-error :form="form" field="valor"></has-error>
                            </div>
                            <div v-show="editmode" class="form-group col-12 col-sm-6 col-md-6 col-lg-6">
                                <label for="photo" >Foto del curso</label>
                                <div class="col-sm-12">
                                    <input type="file" @change="updateFoto" name="photo" id="photo" class="form-input">
                                </div>

                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6 ">
                                <label for='tipo'>Tipo</label>
                                <select name="tipo" v-model="form.tipo" id="tipo" class="form-control" required>
                                   
                                    <option value="1">Curso corto</option>
                                    <option value="2">Diplomado</option>                            
                                </select>
                            </div>

                            <div class="form-group  col-6 col-sm-4 col-md-4 col-lg-4">
                                <label for='validez'>Validez</label>
                                <input v-model="form.validez" type="number" min='1' name="validez" id="validez"
                                    placeholder="Validez" required
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('validez') }">
                                <has-error :form="form" field="validez"></has-error>
                            </div>
                            <div class="form-group col-6 col-sm-2 col-md-2 col-lg-2">     
                                <label for='tipo_validez'>Tipo Validez</label>            
                                <select name="tipo_validez" v-model="form.tipo_validez" id="tipo_validez" class="form-control" :class="{ 'is-invalid': form.errors.has('tipo_validez') }">
                                    
                                    <option value="1">Horas</option>
                                    <option value="2">Dias</option>
                                    <option value="3">Meses</option>
                                </select>
                                
                            </div>
                            

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button v-show="editmode" type="submit" class="btn btn-success">Actualizar</button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary">Crear</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        <!-- Modal Modulos-->
        <div class="modal fade" id="addNewModulo" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Agregar Módulo</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Actualizar Módulo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmodeModule ? editarModulo() : crearModulo()">
                        <div class="modal-body row">
                            <div class="form-group  col-12 col-sm-6 col-md-6 col-lg-6">
                                <label for='modulo'>Modulo</label>
                                <input v-model="form_modulo.modulo" type="text" name="modulo" id="modulo" required
                                    placeholder="Modulo"
                                    class="form-control" :class="{ 'is-invalid': form_modulo.errors.has('modulo') }">
                                <has-error :form="form_modulo" field="modulo"></has-error>
                            </div>
                            <div class="form-group  col-12 col-sm-6 col-md-6 col-lg-6">
                                <label for='video'>Video</label>
                                <input v-model="form_modulo.video" type="text" name="video" id="video" required
                                    placeholder="Video"
                                    class="form-control" :class="{ 'is-invalid': form_modulo.errors.has('video') }">
                                <has-error :form="form_modulo" field="video"></has-error>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-12 col-lg-12">
                                <label for='contenido'>Contenido</label>
                               <textarea v-model="form_modulo.contenido" name="contenido" id="contenido"
                                placeholder="Contenido"
                                class="form-control" :class="{ 'is-invalid': form_modulo.errors.has('contenido') }"></textarea>
                                <has-error :form="form_modulo" field="contenido"></has-error>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-12 col-lg-12">
                                <label for='texto_prueba'>Texto a mostrar en el examen</label>
                               <textarea v-model="form_modulo.texto_prueba" name="texto_prueba" id="texto_prueba"
                                placeholder="Texto examen"
                                class="form-control" :class="{ 'is-invalid': form_modulo.errors.has('texto_prueba') }"></textarea>
                                <has-error :form="form_modulo" field="texto_prueba"></has-error>
                            </div>
                            <div class="form-group col-6 col-sm-2 col-md-2 col-lg-2">     
                                <label for='estado'>Estado</label>            
                                <select name="tipo_duracion" v-model="form_modulo.estado" id="estado" class="form-control" :class="{ 'is-invalid': form_modulo.errors.has('estado') }">                                    
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>                                
                                </select>
                                <has-error :form="form_modulo" field="estado"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button v-show="editmodeModule" type="submit" class="btn btn-success">Actualizar</button>
                            <button v-show="!editmodeModule" type="submit" class="btn btn-primary">Crear</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        <!-- Modal Documentos-->
        <div class="modal fade" id="lista_documentos" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"  id="addNewLabel">Documentos</h5>
                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- /.card-body -->
                    <form @submit.prevent="crearDocumento()">
                        <div class="modal-body row">
                            <div class="form-group  col-12 col-sm-6 col-md-6 col-lg-6">
                                <label for='nombre'>Nombre Documento</label>
                                <input v-model="form_documento.nombre" type="text" name="modulo" id="modulo" required
                                    placeholder="Nombre Documento"
                                    class="form-control" :class="{ 'is-invalid': form_documento.errors.has('nombre') }">
                                <has-error :form="form_documento" field="nombre"></has-error>
                            </div>
                            <div class="form-group  col-12 col-sm-6 col-md-6 col-lg-6">
                                <label for='ruta'>Documento</label>
                                <input type="file" id="ruta" name="ruta" required class="form-input" :class="{ 'is-invalid': form_documento.errors.has('ruta') }">
                                <has-error :form="form_documento" field="ruta"></has-error>
                            </div>
                            
                        </div> 
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button v-show="editmodeDocumento" type="submit" class="btn btn-success">Actualizar</button>
                            <button v-show="!editmodeDocumento" type="submit" class="btn btn-primary">Crear</button>
                        </div>

                    </form>
                    <div class="modal-body row">
                        <div class="card-body table-responsive p-2">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <th>Documento</th>
                                        <th>Ver</th>
                                        <th></th>               
                                        <!-- <th>Registrado</th>
                                        <th>Modificado</th>-->
                                    </tr>
                                    
                                    <tr v-for="documento in documentos.data" :key="documento.id">
                                        <td>{{documento.id}}</td>
                                        <td>{{documento.nombre}}</td>                                   
                                        <td><a class="btn btn-info" v-bind:href="'documentos/'+ documento.ruta" target="_blank">
                                            <i class="fas fa-eye"></i>
                                            Ver</a>
                                        </td>   
                                        <!-- <td>{{curso.created_at | myDate}}</td>
                                        <td>{{curso.update_at | myDate}}</td>-->
                                    
                                        <td>
                                            <a href="#" @click="borrarDocumento(documento.id)">
                                                <i class="fa fa-trash red"></i>
                                            </a>

                                        </td>
                                    </tr>
                                </tbody>
                            </table> 
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Preguntas-->
        <div class="modal fade" id="lista_documentos" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"  id="addNewLabel">Documentos</h5>
                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- /.card-body -->
                    <form @submit.prevent="crearPregunta()">
                        <div class="modal-body row">
                            <div class="form-group  col-12 col-sm-6 col-md-6 col-lg-6">
                                <label for='nombre'>Nombre Documento</label>
                                <input v-model="form_documento.nombre" type="text" name="modulo" id="modulo" required
                                    placeholder="Nombre Documento"
                                    class="form-control" :class="{ 'is-invalid': form_documento.errors.has('nombre') }">
                                <has-error :form="form_documento" field="nombre"></has-error>
                            </div>
                            <div class="form-group  col-12 col-sm-6 col-md-6 col-lg-6">
                                <label for='ruta'>Documento</label>
                                <input type="file" id="ruta" name="ruta" required class="form-input" :class="{ 'is-invalid': form_documento.errors.has('ruta') }">
                                <has-error :form="form_documento" field="ruta"></has-error>
                            </div>
                            
                        </div> 
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button v-show="editmodeDocumento" type="submit" class="btn btn-success">Actualizar</button>
                            <button v-show="!editmodeDocumento" type="submit" class="btn btn-primary">Crear</button>
                        </div>

                    </form>
                    <div class="modal-body row">
                        <div class="card-body table-responsive p-2">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <th>Documento</th>
                                        <th>Ver</th>
                                        <th></th>               
                                        <!-- <th>Registrado</th>
                                        <th>Modificado</th>-->
                                    </tr>
                                    
                                    <tr v-for="documento in documentos.data" :key="documento.id">
                                        <td>{{documento.id}}</td>
                                        <td>{{documento.nombre}}</td>                                   
                                        <td><a class="btn btn-info" v-bind:href="'documentos/'+ documento.ruta" target="_blank">
                                            <i class="fas fa-eye"></i>
                                            Ver</a>
                                        </td>   
                                        <!-- <td>{{curso.created_at | myDate}}</td>
                                        <td>{{curso.update_at | myDate}}</td>-->
                                    
                                        <td>
                                            <a href="#" @click="borrarDocumento(documento.id)">
                                                <i class="fa fa-trash red"></i>
                                            </a>

                                        </td>
                                    </tr>
                                </tbody>
                            </table> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                editmode: false,
                editmodeModule: false,
                editmodeDocumento: false,
                editmodePregunta: false,
                cursos : {},
                curso: {},
                modulos: {},
                modulo: {},
                documentos: {},
                preguntas: {},                
                categorias: {},
                tutores: {},
                photo: '',
                tipos_duracion: {},
                filtro_tipo: '',
                id_curso: '',

                form: new Form({
                    id:'',
                    nombre : '',
                    categoria: '',
                    tutor: '',
                    duracion: 1,
                    tipo_duracion: '',
                    img: '',
                    valor: '',
                    descripcion: '',
                    tipo: '1',
                    validez: '',
                    tipo_validez: '1'                  
                }),
                form_modulo: new Form({
                    id:'',
                    id_curso : '',
                    modulo: '',
                    contenido: '',
                    video: '',
                    estado: '',   
                    texto_prueba: '',                             
                }),
                form_documento: new Form({
                    id:'',                   
                    id_modulo: '',
                    nombre: '',
                    ruta: ''                                              
                }),
                form_pregunta: new Form({
                    id:'',                   
                    id_modulo: '',
                    nombre: '',
                    ruta: ''                                              
                })
            }
        },
        methods: {
            getResults(page = 1) {
                axios.get('api/curso?page=' + page)
                .then(response => {
                    this.cursos = response.data;
                });
            },

            getResultsModulos(page = 1) {
                axios.get('api/modulo?page=' + page)
                .then(response => {
                    this.modulos = response.data;
                });
            },

            

            ver_modulo(curso){
                this.curso = curso;
                this.id_curso = curso.id; 
                this.getModulos(curso.id);
            },

            getModulos(id_curso) {
                axios.get("api/getModules/"+id_curso).then(({ data }) => (this.modulos = data));
            },
            crear(){
                this.$Progress.start();

                this.form.post('api/curso')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')

                    toast({
                        type: 'success',
                        title: 'Curso creado correctamente'
                        })
                    this.$Progress.finish();

                })
                .catch(()=>{

                })
            },
            editar(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/curso/'+this.form.id)
                .then(() => {
                    // success
                    $('#addNew').modal('hide');
                     swal(
                        'Actualizado!',
                        'La información ha sido actualizada.',
                        'success'
                        )
                        this.$Progress.finish();
                         Fire.$emit('AfterCreate');
                })
                .catch(() => {
                    this.$Progress.fail();
                });

            },
            editModal(curso){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(curso);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },

            borrar(id){
                swal({
                    title: 'Estas seguro?',
                    text: "No podras revertir este proceso!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {

                        // Send request to the server
                         if (result.value) {
                                this.form.delete('api/curso/'+id).then(()=>{
                                        swal(
                                        'Borrado!',
                                        'Tu registro ha sido borrado.',
                                        'Exito'
                                        )
                                    Fire.$emit('AfterCreate');
                                }).catch(()=> {
                                    swal("Failed!", "Algo ha salido mal.", "warning");
                                });
                         }
                    })
            },

            crearModulo(){
                this.$Progress.start();

                this.form_modulo.post('api/modulo')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNewModulo').modal('hide')

                    toast({
                        type: 'success',
                        title: 'Modulo creado correctamente'
                        })
                    this.$Progress.finish();

                })
                .catch(()=>{

                })
            },

            editarModulo(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form_modulo.put('api/modulo/'+this.form_modulo.id)
                .then(() => {
                    // success
                    $('#addNewModulo').modal('hide');
                     swal(
                        'Actualizado!',
                        'El modulo ha sido actualizado.',
                        'success'
                        )
                        this.$Progress.finish();
                         Fire.$emit('AfterCreate');
                })
                .catch(() => {
                    this.$Progress.fail();
                });

            },

            
            editModalModulo(modulo){
                this.editmodeModule = true;
                this.form_modulo.reset();
                $('#addNewModulo').modal('show');
                this.form_modulo.fill(modulo);
            },

            newModalModulo(){
                this.editmodeModule = false;
                this.form_modulo.reset();
                this.form_modulo.estado = 1;
                $('#addNewModulo').modal('show');
            },
            
            borrarModulo(id){
                swal({
                    title: 'Estas seguro?',
                    text: "No podras revertir este proceso!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Borrarlo!'
                    }).then((result) => {

                        // Send request to the server
                         if (result.value) {
                                this.form_modulo.delete('api/modulo/'+id).then(()=>{
                                        swal(
                                        'Borrado!',
                                        'Tu registro ha sido borrado.',
                                        'Exito'
                                        )
                                    Fire.$emit('AfterCreate');
                                }).catch(()=> {
                                    swal("Failed!", "Algo ha salido mal.", "warning");
                                });
                         }
                    })
            },

            ver_documentos(modulo) {
                this.form_documento.reset();
                this.getDocumentos(modulo);
                $('#lista_documentos').modal('show');
               // console.log('documentos');
               // console.log(this.documentos);
            },

            borrarDocumento(id){
                swal({
                    title: 'Estas seguro?',
                    text: "No podras revertir este proceso!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Borrarlo!'
                    }).then((result) => {

                        // Send request to the server
                         if (result.value) {
                                this.form_modulo.delete('api/documento/'+id).then(()=>{
                                        swal(
                                        'Borrado!',
                                        'Tu registro ha sido borrado.',
                                        'Exito'
                                        )
                                    Fire.$emit('AfterCreate');
                                }).catch(()=> {
                                    swal("Failed!", "Algo ha salido mal.", "warning");
                                });
                         }
                    })
            },
            crearDocumento(){

            },
            ver_preguntas(modulo) {
                this.form_preguntas.reset();
                this.getPreguntas(modulo);
                $('#lista_preguntas').modal('show');
               // console.log('documentos');
               // console.log(this.documentos);
            },
            crearPregunta(){

            },
            borrarPregunta(id){
                swal({
                    title: 'Estas seguro?',
                    text: "No podras revertir este proceso!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Borrarlo!'
                    }).then((result) => {

                        // Send request to the server
                         if (result.value) {
                                this.form_modulo.delete('api/pregunta/'+id).then(()=>{
                                        swal(
                                        'Borrado!',
                                        'Tu registro ha sido borrado.',
                                        'Exito'
                                        )
                                    Fire.$emit('AfterCreate');
                                }).catch(()=> {
                                    swal("Failed!", "Algo ha salido mal.", "warning");
                                });
                         }
                    })
            },

            cargar(){
                if(this.$gate.isAdminOrAuthor()){
                    axios.get("api/curso").then(({ data }) => (this.cursos = data));
                }
            },

            getCategorias() {
                
               
                let me = this;
                 axios.get("api/categoria")
                 .then(function (response) {
                    let auxCats = response.data.data;                    
                   
                     $.each(auxCats, function(key, value) {
                       
                        me.categorias[value.id] = [value.categoria, value.id]; 
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getTutores() {               
               
                let me = this;
                 axios.get("api/getTutors")
                 .then(function (response) {
                    let auxTuts = response.data.users;                    
                    console.log(response)
                     $.each(auxTuts, function(key, value) {
                       
                        me.tutores[value.id] = [value.name, value.id] 
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDocumentos(id_modulo) {               
               axios.get("api/getDocumentos/"+id_modulo).then(({ data }) => (this.documentos = data));
            },
            getPreguntas(id_modulo) {               
               axios.get("api/getPreguntas/"+id_modulo).then(({ data }) => (this.preguntas = data));
            },
            updateFoto(e){
                let file = e.target.files[0];
                let reader = new FileReader();

                let limit = 1024 * 1024 * 2;
                if(file['size'] > limit){
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You are uploading a large file',
                    })
                    return false;
                }

                reader.onloadend = (file) => {
                    this.form.img = reader.result;
                }
                reader.readAsDataURL(file);
            }
            
        },
        created() {
            this.getCategorias();
            this.getTutores();
            this.tipos_duracion[0] = 'Horas';
            this.tipos_duracion[1] = 'Días';
            this.tipos_duracion[2] = 'Meses';
            let me = this;
            Fire.$on('searching',() => {

                let query = this.$parent.search;

                if(me.id_curso){
                    axios.get('api/findModulo?q=' + query)
                    .then((data) => {
                        this.cursos = data.data
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
                else {
                     axios.get('api/findCurso?q=' + query)
                    .then((data) => {
                        this.cursos = data.data
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
                
               
            })
           this.cargar();
           Fire.$on('AfterCreate',() => {
               this.cargar();
           });
        //    setInterval(() => this.loadUsers(), 3000);
        }

    }
</script>
