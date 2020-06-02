<template>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
            <div class="col-md-12" v-if="!id_inscripcion">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Mis cursos</h3>

                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead> 
                                <tr>
                                    <th>ID</th>                                                                 
                                    <th>Curso</th>
                                    <th>Fecha Solicita</th>                                    
                                    <th>Fecha Acepta</th>                                    
                                    <th>Fecha Cancelado</th>
                                    <th>Fecha Finalizado</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                    <th>Certificado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="inscripcion in inscripciones.data" :key="inscripcion.id">
                                    <td>{{inscripcion.id}}</td>
                                    <td>{{inscripcion.curso}}</td>
                                    <td>{{inscripcion.fecha}}</td>
                                    
                                    <td>
                                        {{inscripcion.fec_activa}}
                                    </td>
                        
                                    <td v-if="inscripcion.estado == 1 || inscripcion.estado == 2">
                                        <button type="button" class="btn btn-danger" @click="cancelarInscripcion(inscripcion.id)">Cancelar</button>
                                    </td >
                                    <td v-else>
                                        {{inscripcion.fec_cancela}}
                                    </td>
                                    
                                    <td>{{inscripcion.fec_termina}}</td>
                                    <td v-if="inscripcion.estado==1">En solicitud</td>
                                    <td v-if="inscripcion.estado==2">En progreso</td>
                                    <td v-if="inscripcion.estado==3">Finalizado</td>
                                    <td v-if="inscripcion.estado==0">Cancelado</td>
                                     <td >
                                        <button class="btn btn-info" @click="irCurso(inscripcion)">Ir al curso</button>
                                    </td>
                                    <td >
                                        <button v-if="inscripcion.fec_termina" class="btn btn-info">Certificado</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12" v-if="id_inscripcion">
                <div class="card">
                    <div class="card-header">
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
                modulos : {},
                cursos : {},
                curso: {},
                id_curso: '',
                inscripciones : {},
                inscripcion: {},
                id_inscripcion: '',
                id_alumno: '',
                form: new Form({
                    id:'',
                    name : '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
                })
            }
        },
        methods: {
            getResults(page = 1) {
                axios.get(this.$parent.ruta + 'api/findMisInscripciones?page=' + page)
                .then(response => {
                    this.inscripciones = response.data;
                });
            },
            verCurso(inscripcion){
                this.inscripcion = inscripcion;
                this.id_inscripcion = inscripcion.id;
            },
            cancelarIns(id) {
                let me = this;
                 swal({
                    title: 'Estas seguro?',
                    text: "No podras revertir este proceso!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, cancelar!'
                    }).then((result) => {
                        axios.get(this.$parent.ruta + 'api/cancelarMisInscripciones/' + id)
                        .then(response => {
                            me.loadCursos();
                            swal(
                                'Cancelada!',
                                'La inscripción ha sido cancelada.',
                                'success'
                                )
                            Fire.$emit('AfterCreate');
                        });
                    });
            },
            loadCursos(){
                if(this.$gate.isAdminOrAuthor()){
                    axios.get(this.$parent.ruta + "api/findMisInscripciones").then(({ data }) => (this.inscripciones = data));
                }
            },
            irCurso(curso) {
                this.curso = curso;
            },
            createUser(){
                this.$Progress.start();

                this.form.post(this.$parent.ruta + 'api/user')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')

                    toast({
                        type: 'success',
                        title: 'User Created in successfully'
                        })
                    this.$Progress.finish();

                })
                .catch(()=>{

                })
            }
        },
        created() {
            
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get(this.$parent.ruta + 'api/findMisInscripciones/' + query)
                .then((data) => {
                    this.inscripciones = data.data
                })
                .catch(() => {

                })
            })
           this.loadCursos();
           Fire.$on('AfterCreate',() => {
               this.loadUsers();
           });
        //    setInterval(() => this.loadUsers(), 3000);
        }

    }
</script>
