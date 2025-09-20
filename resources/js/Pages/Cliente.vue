<template>
    <Head title="Clientes" />

    <div class="bg-white w-2/3 m-2 rounded-sm shadow-sm flex flex-col gap-2 p-2">
        <input 
        :class="['border rounded-sm p-1 focus:ring-2 focus:ring-blue-200', pintarCamposObligatorios('nombre')]"
        type="text"
        name="" 
        id=""
        placeholder="nombre del cliente..."
        v-model.trim="cliente.nombre"
        >
        <input 
        class="border-gray-200 rounded-sm p-1 focus:ring-2 focus:ring-blue-200"
        type="text"
        name="" 
        id=""
        placeholder="tipo de cliente..."
        v-model.trim="cliente.tipo"
        >
        <input 
        class="border-gray-200 rounded-sm p-1 focus:ring-2 focus:ring-blue-200"
        type="text"
        name="" 
        id=""
        placeholder="identificación..."
        v-model.trim="cliente.identificacion"
        >
        <input 
        :class="['border rounded-sm p-1 focus:ring-2 focus:ring-blue-200', pintarCamposObligatorios('telefono')]"
        type="text"
        name="" 
        id=""
        placeholder="teléfono..."
        v-model.trim="cliente.telefono"
        >
        <input 
        :class="['border rounded-sm p-1 focus:ring-2 focus:ring-blue-200', pintarCamposObligatorios('email')]"
        type="text"
        name="" 
        id=""
        placeholder="email..."
        v-model.trim="cliente.email"
        >
        <input 
        :class="['border rounded-sm p-1 focus:ring-2 focus:ring-blue-200', pintarCamposObligatorios('direccion')]"
        type="text"
        name="" 
        id=""
        placeholder="direccion..."
        v-model.trim="cliente.direccion"
        >
        <input 
        class="border-gray-200 rounded-sm p-1 focus:ring-2 focus:ring-blue-200  "
        type="file"
        name="" 
        id=""
        placeholder="logo..."
        >
        <!-- v-model.trim="cliente.logo" -->
        <button 
        class="bg-green-500 text-white rounded-sm shadow-sm hover:bg-white hover:text-green-500 hover:border-2 hover:border-green-500 py-2 flex gap-2 items-center justify-center"
        @click.prevent="guardarCliente"
        >
            <i class="fa-solid fa-save"></i>
            <span class="font-bold">Guardar</span>
        </button>
    </div>
    
</template>
<script>
import { Head } from '@inertiajs/vue3';

export default {
    components:{
        Head
    },
    data(){
        return {
            titulo: 'clientes',
            cliente:{
                nombre:null,
                tipo:null,
                identificacion:null,
                telefono:null,
                email:null,
                direccion:null,
                logo:null
            },
            camposObligatorios:[
                'nombre',
                'telefono',
                'direccion',
                'email',
                'direccion'
            ]
        }
    },
    methods: {
        async guardarCliente(){
            //validar datos del cliente
            const VALIDO = this.camposObligatorios.every(campo => this.cliente[campo]);
            if(!VALIDO){
                this.$swal.fire({
                    toast: true,
                    timer: 5000,
                    position: 'top',
                    text: 'Todos los campos en rojo son obligatorios',
                    icon: 'warning',
                    showConfirmButton:false
                })
                return;
            }

            await axios.post('/cliente/crear', this.cliente).then(response=>{
                this.$swal.fire({
                    title: '¡Éxito!',
                    text: response.data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            }).catch(error=>{
                console.error(error.response);
                this.$swal.fire({
                    title: 'Error!',
                    text: error.response.data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        },
        async obtenerClientes(){
            await axios.get('/clientes/obtener').then(response=>{
                console.log(response.data);
            }).catch(error=>{
                console.error(error);
            });
        },
        pintarCamposObligatorios(_campo){
            return this.camposObligatorios.includes(_campo) && !this.cliente[_campo]
                ? 'border-red-500 ring-2 ring-red-300'
                : 'border-green-500 ring-2 ring-green-300'
        }
    },
}
</script>
<style scoped>

</style>