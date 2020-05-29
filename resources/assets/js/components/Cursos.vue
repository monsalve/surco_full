<template>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
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
                                    <!-- <th>Registrado</th>
                                    <th>Modificado</th>-->
                                </tr>
                                <tr v-for="curso in cursos.data" :key="curso.id">
                                    <td>{{curso.id}}</td>
                                    <td>{{curso.nombre}}</td>
                                    <td>{{curso.tipo == '1' ? 'Curso corto' : 'Dipolomado'}}</td>
                                    <td>{{categorias[curso.categoria][0]}}</td>
                                    <td>{{ tutores[curso.tutor][0]}}</td>
                                    <td>{{curso.duracion + ' ' + curso.tipo_duracion}}</td>
                                    <td v-if="curso.estado == '1'" >Activo</td>
                                    <td v-else >Inactivo</td>                                   
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

        <div v-if="!$gate.isAdminOrAuthor()">
            <not-found></not-found>
        </div>

    <!-- Modal -->
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
                    <form @submit.prevent="editmode ? actualizar() : crear()">
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
    </div>
</template>

<script>
    export default {
        data() {
            return {
                editmode: false,
                cursos : {},
                categorias: {},
                tutores: {},
                photo: '',
                filtro_tipo: '',
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
            cargar(){
                if(this.$gate.isAdminOrAuthor()){
                    axios.get("api/curso").then(({ data }) => (this.cursos = data));
                }
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
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('api/findCurso?q=' + query)
                .then((data) => {
                    this.cursos = data.data
                })
                .catch(() => {

                })
            })
           this.cargar();
           Fire.$on('AfterCreate',() => {
               this.cargar();
           });
        //    setInterval(() => this.loadUsers(), 3000);
        }

    }
</script>
