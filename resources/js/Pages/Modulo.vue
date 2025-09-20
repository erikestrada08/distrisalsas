<template>
    <Head title="Modulos" />

    <div>
        <!-- card con el formulario de administracion de modulos -->
        <div class="bg-white w-2/3 m-2 rounded-sm shadow-sm flex flex-col gap-2 p-2">
            <input 
            class="border-gray-200 rounded-sm p-1 focus:ring-2 focus:ring-blue-200"
            type="text"
            name="" 
            id=""
            placeholder="Nombre del módulo..."
            v-model.trim="modulo.nombre"
            >
            <div class="flex gap-2 items-center">
                <input 
                class="border-gray-200 rounded-sm p-1 focus:ring-2 focus:ring-blue-200 w-full"
                type="text"
                name="" 
                id=""
                placeholder="Icono del módulo..."
                v-model.trim="modulo.icono"
                >
                <i 
                class="text-xl px-2"
                :class="modulo.icono"
                ></i>
            </div>
            <button 
            class="bg-green-500 text-white rounded-sm shadow-sm hover:bg-white hover:text-green-500 hover:border-2 hover:border-green-500 py-2 flex gap-2 items-center justify-center"
            @click.prevent="guardarModulo"
            >
                <i class="fa-solid fa-save"></i>
                <span class="font-bold">Guardar</span>
            </button>
        </div>
        <div class="bg-white m-2 p-2">
            <table class="w-full border border-gray-300 rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border border-gray-300 text-center">Id</th>
                        <th class="border border-gray-300 px-2 text-left">Nombre</th>
                        <th class="border border-gray-300 text-center">Icono</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                    v-for="(modulo,i) in modulos"
                    :key="i"
                    >
                        <td class="text-center border border-gray-300">
                            <span 
                            role="button"
                            class="text-blue-700 underline hover:text-blue-900"
                            :title="`Editar módulo '${modulo.nombre}'`"
                            @click.prevent="abrirModal(modulo.id)"
                            >
                                {{ modulo.id }}
                            </span>
                        </td>
                        <td class="text-left border border-gray-300 px-2">{{ modulo.nombre }}</td>
                        <td class="text-center border border-gray-300">
                            <i :class="modulo.icono"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- modal -->
        <div v-show="isOpen" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center transition-opacity duration-300">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                
                <input 
                class="border-gray-200 rounded-sm p-1 focus:ring-2 focus:ring-blue-200"
                type="text"
                name="" 
                id=""
                placeholder="Nombre del módulo..."
                v-model.trim="modulo.nombre"
                >
                <input 
                class="border-gray-200 rounded-sm p-1 focus:ring-2 focus:ring-blue-200"
                type="text"
                name="" 
                id=""
                placeholder="Nombre del módulo..."
                v-model.trim="modulo.nombre"
                >

                <button @click="isOpen = false" class="mt-4 bg-red-500 text-white px-4 py-2 rounded">Cerrar</button>
            </div>
        </div>
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
            titulo: 'modulos',
            modulo:{
                nombre: null,
                icono: null
            },
            modulos:[],
            isOpen: false,
            moduloSeleccionado:null
        }
    },
    methods: {
        async guardarModulo(){
            const VALIDO = Object.values(this.modulo).every(campo=>!!campo);
            if(!VALIDO){
                this.$swal.fire({
                    toast: true,
                    timer: 5000,
                    position: 'top',
                    text: 'Todos los campos son obligatorios',
                    icon: 'warning',
                    showConfirmButton:false
                })
                return;
            }
            await axios.post('/modulo/crear', this.modulo).then(response=>{
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

        async obtenerModulos(){
            await axios.get('/modulo/listar').then(response=>{
                this.modulos = response.data.data;
            }).catch(error=>{
                console.error(error);
            });
        },
        abrirModal(_id){
            this.moduloSeleccionado = this.modulos.find(modulo=>modulo.id==_id);
            this.isOpen = !this.isOpen;
        }
    },
    mounted() {
        this.obtenerModulos();
    },
}
</script>
<style scoped>

</style>