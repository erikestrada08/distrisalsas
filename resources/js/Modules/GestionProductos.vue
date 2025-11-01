<template>
    <!-- <Head title="Productos" />
    <PlantillaAdministrativa> -->
                
        <div class="flex flex-col gap-1 bg-background text-foreground">

            <!-- etiquetas informativas -->
            <div class="flex gap-1 sticky top-0 z-10 overflow-x-auto pb-1">

                <!-- productos -->
                <div 
                class="flex border hover:border-lime-500 rounded shadow w-[200px] h-[100px] items-center justify-center gap-4 bg-card text-foreground border-border cursor-pointer"
                :class="{
                    'bg-muted/20': moduloActivo == 'productos'
                }"
                @click.prevent="moduloActivo = 'productos'"
                >
                    <div class="border rounded-full p-2 bg-lime-500 w-[50px] h-[50px] relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-9 text-white absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-[20px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </div>
    
                    <div class="flex flex-col leading-none items-center justify-center">
                        <span class="h-2/3 flex items-center text-6xl font-bold">{{ productos.length }}</span>
                        <span class="flex-1 flex items-center">Productos</span>
                    </div>
                </div>

                <!-- categorias -->
                <div 
                class="flex border hover:border-emerald-500 rounded shadow w-[200px] h-[100px] items-center justify-center gap-4 bg-card text-foreground border-border cursor-pointer"
                :class="{
                    'bg-muted/20': moduloActivo == 'categorias'
                }"
                @click.prevent="moduloActivo = 'categorias'"
                >
                    <div class="border rounded-full p-2 bg-emerald-500 w-[50px] h-[50px] relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-9 text-white absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-[18px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                        </svg>

                    </div>
    
                    <div class="flex flex-col leading-none items-center justify-center">
                        <span class="h-2/3 flex items-center text-6xl font-bold">{{ categorias.length }}</span>
                        <span class="flex-1 flex items-center">Categorias</span>
                    </div>
                </div>

                <!-- marcas -->
                <div 
                class="flex border hover:border-cyan-500 rounded shadow w-[200px] h-[100px] items-center justify-center gap-4 bg-card text-foreground border-border cursor-pointer"
                :class="{
                    'bg-muted/20': moduloActivo == 'marcas'
                }"
                @click.prevent="moduloActivo = 'marcas'"
                >
                    <div class="border rounded-full p-2 bg-cyan-500 w-[50px] h-[50px] relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-9 text-white absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-[18px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                        </svg>

                    </div>
    
                    <div class="flex flex-col leading-none items-center justify-center">
                        <span class="h-2/3 flex items-center text-6xl font-bold">{{ marcas.length }}</span>
                        <span class="flex-1 flex items-center">Marcas</span>
                    </div>
                </div>
    
            </div>
            
            <!-- submodulos -->
            
            <!-- productos -->
            <Transition
            enter-active-class="transition-all duration-300 transform"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            >
                <div 
                v-show="moduloActivo == 'productos'"
                class="flex gap-1">
                    
                    <!-- Lightbox -->
                    <vue-easy-lightbox
                    :visible="visible"
                    :imgs="imagenPreview"
                    :index="index"
                    @hide="handleHide"
                    />
        
                    <!-- fomulario -->
                    <div>
                        <div class="formulario flex flex-col gap-1 p-2 rounded-md min-w-[300px] max-w-[300px] shadow-md bg-card text-foreground border border-border">
            
                            <div class="flex justify-center">
            
                                <div class="relative flex items-center justify-center rounded-full w-[100px] h-[100px]">
                                    <img 
                                    v-if="producto.imagen" 
                                    :src="imagenPreview[0]"
                                    @click="showLightbox(0)"
                                    alt="foto producto"
                                    class="w-full h-full object-cover rounded-full cursor-pointer"
                                    >
            
                                    <div 
                                    v-else 
                                    class="bg-cyan-400 w-full h-full rounded-full flex items-center justify-center text-6xl font-bold text-white cursor-pointer"
                                    title="Sin foto">
                                        SF
                                    </div>

                                    <div 
                                    @click.prevent="$refs.imagen.click()"
                                    class="absolute bottom-0 right-0 rounded-full w-[30px] h-[30px] flex items-center justify-center bg-card border border-border cursor-pointer hover:bg-muted/20"
                                    title="Subir imagen">
                                        <i class="fa-solid fa-camera text-xl text-gray-600"></i>
                                    </div>
            
                                    <input
                                    ref="imagen"
                                    type="file" 
                                    id="imagen" 
                                    class="border border-border bg-background text-foreground rounded-md p-1" @change="obtenerImagen"
                                    hidden>
            
                                </div>
                            </div>
            
                            <div class="flex flex-col">
                                <label for="producto" class="text-sm">Nombre del producto</label>
                                <div class="relative">
                                    <input type="text" id="producto" class="border border-border bg-background text-foreground rounded-md py-1 pl-7 pr-1 w-full" v-model.trim="producto.producto">
                                    <i class="fa-solid fa-tag absolute top-1/2 left-2 -translate-y-1/2"></i>
                                </div>
                            </div>
            
                            <div class="flex flex-col">
                                <label for="descripcion" class="text-sm">Descripción</label>
                                <textarea rows="3"  id="descripcion" style="resize: none;" class="border border-border bg-background text-foreground rounded-md p-1" v-model.trim="producto.descripcion"></textarea>
                            </div>
                            <div class="flex flex-col">
                                <label for="codigo-barras" class="text-sm">Código de barras</label>
                                <div class="relative">
                                    <input type="text" id="codigo-barras" class="border border-border bg-background text-foreground rounded-md py-1 pl-7 pr-1 w-full" v-model.trim="producto.codigo_barras">
                                    <i class="fa-solid fa-barcode absolute top-1/2 left-2 -translate-y-1/2 text-sm"></i>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <label for="codigo-barras" class="text-sm">Marca</label>
                                <div class="relative">
                                    <select 
                                    id="marca"
                                    class="border border-border bg-background text-foreground rounded-md py-1 pl-7 pr-1 w-full"
                                    v-model.trim="producto.marca_id">
                                        <option disabled value="">Seleccione una marca</option>
                                        <option 
                                        v-for="marca,i in marcas"
                                        :key="i"
                                        :value="marca.id">
                                            {{ marca.marca }}
                                        </option>
                                    </select>
                                    <i class="fa-solid fa-bookmark absolute top-1/2 left-2 -translate-y-1/2 text-sm"></i>
                                    <button
                                    v-if="producto.marca_id"
                                    title="Limpiar selección"
                                    @click.prevent="limpiarSelect('marca_id')"
                                    class="absolute top-1/2 right-8 -translate-y-1/2 text-sm cursor-pointer hover:text-red-500 flex items-center"
                                    >
                                        <i class="fa-solid fa-xmark text-md"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <label for="codigo-barras" class="text-sm">Categoria</label>
                                <div class="relative">
                                    <div class="relative">
                                        <select 
                                        id="categoria"
                                        class="border border-border bg-background text-foreground rounded-md py-1 pl-7 pr-1 w-full"
                                        v-model.trim="producto.categoria_id">
                                            <option disabled value="">Seleccione una categoría</option>
                                            <option 
                                            v-for="categoria,i in categorias"
                                            :key="i"
                                            :value="categoria.id">
                                                {{ categoria.categoria }}
                                            </option>
                                        </select>
                                        <i class="fa-solid fa-folder absolute top-1/2 left-2 -translate-y-1/2 text-sm"></i>
                                        <button
                                        v-if="producto.categoria_id"
                                        @click.prevent="limpiarSelect('categoria_id')"
                                        title="Limpiar selección"
                                        class="absolute top-1/2 right-8 -translate-y-1/2 text-sm cursor-pointer hover:text-red-500 flex items-center"
                                        >
                                            <i class="fa-solid fa-xmark text-md"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <label for="precio" class="text-sm">Precio</label>
                                <div class="relative">
                                    <input type="number" id="precio" class="border border-border bg-background text-foreground rounded-md py-1 pl-7 pr-1 w-full" v-model.trim="producto.precio">
                                    <i class="fa-solid fa-dollar-sign absolute top-1/2 left-2 -translate-y-1/2"></i>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <label for="costo" class="text-sm">Costo</label>
                                <div class="relative">
                                    <input type="number" id="costo" class="border border-border bg-background text-foreground rounded-md py-1 pl-7 pr-1 w-full" v-model.trim="producto.costo">
                                    <i class="fa-solid fa-dollar-sign absolute top-1/2 left-2 -translate-y-1/2"></i>
                                </div>
                            </div>
                            <div class="flex items-center gap-1">
                                <label for="costo" class="text-sm">Disponible</label>
                                <label class="relative inline-block w-11 h-6">
                                    <input
                                    type="checkbox"
                                    id="activo"
                                    class="sr-only peer"
                                    v-model="producto.activo"
                                    />

                                    <!-- Fondo del switch -->
                                    <div class="absolute inset-0 bg-gray-300 rounded-full peer-checked:bg-green-500 transition-colors"></div>

                                    <!-- Círculo del switch -->
                                    <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-card rounded-full shadow-md transition-transform transform peer-checked:translate-x-5"></div>
                                </label>
                            </div>
                
                            <div class="flex justify-center gap-1">
                                <button class="bg-green-500 py-1 px-2 rounded-md text-white flex gap-1 items-center justify-center hover:bg-green-600 flex-1" @click.prevent="guardarActualizar('/producto/crear')">
                                    <i class="fas fa-save"></i>
                                    {{ !producto.id ? 'guardar' : 'Actualizar' }}
                                </button>
                                <button class="bg-cyan-500 py-1 px-2 rounded-md text-white flex gap-1 items-center justify-center hover:bg-cyan-600 flex-1" @click.prevent="limpiarFormulario('producto')">
                                    <i class="fa-solid fa-broom"></i>
                                    Limpiar
                                </button>
                            </div>
                
                        </div>
                    </div>
                    <!-- tabla -->

                    <div class="flex flex-col gap-1">

                        <!-- atributos del producto -->
                        <div class="flex flex-col gap-1 rounded-md p-2 shadow-md overflow-x-auto bg-card text-foreground border border-border">

                            <label for="atributo" class="text-sm">Atributos</label>

                            <div class="flex gap-1">
                                <div class="relative flex-1">
                                    <input type="text" id="atributo" class="border border-border bg-background text-foreground rounded-md py-1 pl-8 pr-1 w-full" v-model.trim="atributo">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 absolute top-1/2 left-2 -translate-y-1/2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                </div>
                                <button 
                                title="agregar atributo"
                                class="bg-green-500 w-10 flex justify-center items-center"
                                @click.prevent="agregarAtributo"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                    </svg>
                                </button>
                            </div>

                            <div 
                            v-if="listaAtributos.length > 0"
                            class="flex flex-col gap-1"
                            >
                                <div 
                                v-for="(atributo, i) in listaAtributos"
                                :key="i"
                                class="flex items-center gap-1"
                                >
                                    <span class="w-1/4">{{ atributo }}:</span> 
                                    <input 
                                    type="text" 
                                    class="border border-border bg-background text-foreground rounded-md p-1 w-3/4"
                                    v-model.trim="producto.atributos[atributo]"
                                    >
                                    <button 
                                    class="bg-red-400 h-full w-10 flex justify-center items-center"
                                    @click.prevent="eliminarAtributo(atributo)"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>

                                    </button>
                                </div>
                            </div>

                        </div>

                        <div class="rounded-md p-2 shadow-md overflow-x-auto bg-card text-foreground border border-border">
                            <DataTable 
                            :value="productosComputada" 
                            dataKey="id" 
                            tableStyle="min-width: 50rem"
                            size="small"
                            class="cursor-pointer"
                            selectionMode="single"
                            removableSort
                            :pt="pt"
                            @row-click="(event) => cargarDatosEnFormulario(event, 'producto')"
                            >
                                <Column field="id" header="Id" sortable/>
                                <Column field="producto" header="Producto" class="text-nowrap" sortable/>
                                <Column field="descripcion" header="Descripción" sortable/>
                                <Column field="codigo_barras" header="Cod. barras" sortable/>
                                <Column field="precio" header="Precio" sortable/>
                                <Column field="costo" header="Costo" sortable/>
                                <Column field="marca" header="Marca" sortable/>
                                <Column field="categoria" header="Categoría" sortable/>
                                <Column field="activo" header="Disponible" sortable>
                                    <template #body="slotProps">
                                        <span 
                                        class="inline-block rounded-md text-white font-bold w-[30px] text-center"
                                        :class="{
                                            'bg-red-500': slotProps.data.activo == 'No',
                                            'bg-green-600': slotProps.data.activo == 'Si'
                                        }"
                                        >
                                            {{ slotProps.data.activo }}
                                        </span>
                                    </template>
                                </Column>
                            </DataTable>
                        </div>
                    </div>
                </div>
            </Transition>

            <!-- categorias -->
            <Transition
            enter-active-class="transition-all duration-300 transform"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            >
                <div 
                v-show="moduloActivo == 'categorias'"
                class="flex gap-1"
                >
                    <!-- fomulario -->
                    <div>
                        <div class="formulario flex flex-col gap-1 p-2 rounded-md bg-card text-foreground border border-border min-w-[300px] max-w-[300px] shadow-md">

                            <div class="flex flex-col">
                                <label for="producto" class="text-sm">Nombre de la categoría</label>
                                <div class="relative">
                                    <input type="text" id="producto" class="border border-border bg-background text-foreground rounded-md py-1 pl-7 pr-1 w-full" v-model.trim="categoria.categoria">
                                    <i class="fa-solid fa-tag absolute top-1/2 left-2 -translate-y-1/2"></i>
                                </div>
                            </div>
            
                            <div class="flex flex-col">
                                <label for="descripcion" class="text-sm">Descripción</label>
                                <textarea rows="3"  id="descripcion" style="resize: none;" class="border border-border bg-background text-foreground rounded-md p-1" v-model.trim="categoria.descripcion"></textarea>
                            </div>

                            <div class="flex justify-center gap-1">
                                <button class="bg-green-500 py-1 px-2 rounded-md text-white flex gap-1 items-center justify-center hover:bg-green-600 flex-1" @click.prevent="guardarActualizar('/categoria/crear')">
                                    <i class="fas fa-save"></i>
                                    {{ !categoria.id ? 'guardar' : 'Actualizar' }}
                                </button>
                                <button class="bg-cyan-500 py-1 px-2 rounded-md text-white flex gap-1 items-center justify-center hover:bg-cyan-600 flex-1" @click.prevent="limpiarFormulario('categoria')">
                                    <i class="fa-solid fa-broom"></i>
                                    Limpiar
                                </button>
                            </div>
                
                        </div>
                    </div>
                    <!-- tabla -->
                    <div class="bg-card text-foreground border border-border rounded-md p-2 shadow-md overflow-x-auto">
                        <DataTable 
                        :value="categorias"
                        dataKey="id" 
                        size="small"
                        class="cursor-pointer"
                        :pt="pt"
                        @row-click="(event) => cargarDatosEnFormulario(event, 'categoria')"
                        selectionMode="single"
                        >
                            <Column field="id" header="Id" sortable/>
                            <Column field="categoria" header="Categoría" sortable/>
                            <Column field="descripcion" header="Descripción"/>
                        </DataTable>   
                    </div>
                </div>
            </Transition>

            <!-- marcas -->
            <Transition
            enter-active-class="transition-all duration-300 transform"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            >
                <div
                v-show="moduloActivo == 'marcas'"
                class="flex gap-1"
                >
                    <!-- fomulario -->
                    <div>
                        <div class="formulario flex flex-col gap-1 p-2 rounded-md bg-card text-foreground border border-border min-w-[300px] max-w-[300px] shadow-md">

                            <div class="flex flex-col">
                                <label for="producto" class="text-sm">Nombre de la marca</label>
                                <div class="relative">
                                    <input type="text" id="producto" class="border border-border bg-background text-foreground rounded-md py-1 pl-7 pr-1 w-full" v-model.trim="marca.marca">
                                    <i class="fa-solid fa-tag absolute top-1/2 left-2 -translate-y-1/2"></i>
                                </div>
                            </div>

                            <div class="flex justify-center gap-1">
                                <button class="bg-green-500 py-1 px-2 rounded-md text-white flex gap-1 items-center justify-center hover:bg-green-600 flex-1" @click.prevent="guardarActualizar('/marca/crear')">
                                    <i class="fas fa-save"></i>
                                    {{ !marca.id ? 'guardar' : 'Actualizar' }}
                                </button>
                                <button class="bg-cyan-500 py-1 px-2 rounded-md text-white flex gap-1 items-center justify-center hover:bg-cyan-600 flex-1" @click.prevent="limpiarFormulario('marca')">
                                    <i class="fa-solid fa-broom"></i>
                                    Limpiar
                                </button>
                            </div>
                
                        </div>
                    </div>
                    <!-- tabla -->
                    <div class="bg-card text-foreground border border-border rounded-md p-2 shadow-md overflow-x-auto">
                        <DataTable 
                        :value="marcas"
                        dataKey="id" 
                        size="small"
                        class="cursor-pointer"
                        :pt="pt"
                        @row-click="(event) => cargarDatosEnFormulario(event, 'marca')"
                        selectionMode="single"
                        >
                            <Column field="id" header="Id" sortable/>
                            <Column field="marca" header="Marca" sortable/>
                        </DataTable>   
                    </div>
                </div>
            </Transition>
        </div>

</template>
<script>
import VueEasyLightbox from 'vue-easy-lightbox';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { datatablePt } from '@/utils/themePrimevue';

export default {
    components:{
        VueEasyLightbox,
        DataTable,
        Column
    },
    data(){
        return {
            modulo: 'Gestión de productos',
            producto: {
                id: null,
                producto: null,
                descripcion: null,
                precio: null,
                costo: null,
                imagen: null,
                marca_id: null,
                categoria_id: null,
                activo: true,
                atributos: {}
            },
            marcas: [],
            productos: [],
            categorias: [],
            imagenPreview: [],
            visible: false,
            index: 0,
            moduloActivo: 'productos',
            categoria: {
                id: null,
                categoria: null,
                descripcion: null
            },
            marca: {
                id: null,
                marca: null
            },
            filtro: null,
            filters: {
                global: { value: null, matchMode: 'contains' }
            },
            atributo: null,
            listaAtributos: []
        }
    }, 
    computed: {
        pt() { return datatablePt(); }
    },
    methods: {
        obtenerImagen(event){
            const IMAGEN = event.target.files[0];
            if (IMAGEN) {
                console.log(IMAGEN);
                const IMAGENES_PERMITIDAS = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!IMAGENES_PERMITIDAS.includes(IMAGEN.type)) {
                    console.error('Error');
                    return;
                }
                if (!(IMAGEN.size <= 6 * 1024 * 1024)) {
                    console.error("Error");l
                    return;
                }
                this.producto.imagen = IMAGEN;
                
                this.imagenPreview = [URL.createObjectURL(this.producto.imagen)];
            }
        },
        async consulta(ruta, metodo = 'get', data){
            try {
                const RESPONSE = await axios[metodo](ruta, data,
                { headers: { 'Content-Type': 'multipart/form-data' } }
                );
                if (metodo != 'get') {
                    this.$swal.fire({
                        text: RESPONSE.data.message,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 5000,
                        toast: true,
                        position: 'top'
                    });
                }
                return RESPONSE;
            } catch (error) {
                console.error(error.response);
                this.$swal.fire({
                    title: 'Error!',
                    text: error.response.data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        },
        async guardarActualizar(_ruta){

            switch (_ruta) {
                case '/categoria/crear': // GUARDAR O ACTUALIZAR CATEGORIA

                    const { data: { data: CATEGORIA }, status: STATUS_CATEGORIA } = await this.consulta(_ruta, 'post', this.categoria);
                    if (STATUS_CATEGORIA == 201) {
                        console.log(CATEGORIA);
                        
                        this.categorias.push({
                            id: CATEGORIA.id,
                            categoria: CATEGORIA.categoria,
                            descripcion: CATEGORIA.descripcion
                        });
                        this.categoria = CATEGORIA;
                    }else if (STATUS_CATEGORIA == 200) {
                        const INDEX = this.categorias.findIndex(categoria => categoria.id == CATEGORIA.id);
                        this.categorias[INDEX] = CATEGORIA;
                    }

                    break;
                case '/producto/crear': // GUARDAR O ACTUALIZAR PRODUCTO

                    const formData = new FormData();
                    Object.entries( this.producto ).forEach( ([key, value]) => {
                        if (value) formData.append(key, value);
                    } );
                    const { data: { data: PRODUCTO }, status: STATUS_PRODUCTO  } = await this.consulta(_ruta,'post',formData);
                    if (STATUS_PRODUCTO == 201) { // si creó un nuevo recurso
                        this.productos.push({
                            id: PRODUCTO.id,
                            producto: PRODUCTO.producto,
                            descripcion: PRODUCTO.descripcion,
                            codigo_barras: PRODUCTO.codigo_barras,
                            precio: PRODUCTO.precio,
                            costo: PRODUCTO.costo,
                            imagen: PRODUCTO.imagen
                        });
                        this.producto = PRODUCTO;
                    } else if (STATUS_PRODUCTO == 200) { // si actualizó un recurso existente
                        const INDEX = this.productos.findIndex(producto => producto.id == PRODUCTO.id);
                        console.log(INDEX);
                        this.productos[INDEX] = PRODUCTO;
                    }

                    break;
                case '/marca/crear': // GUARDAR O ACTUALIZAR MARCA
                    
                    console.log('crear o actualizar marca');
                    const { data: { data: MARCA }, status: STATUS_MARCA } = await this.consulta(_ruta, 'post', this.marca);
                    if (STATUS_MARCA == 201) {
                        console.log(MARCA);
                        
                        this.marcas.push({
                            id: MARCA.id,
                            marca: MARCA.marca,
                        });
                        this.marca = MARCA;
                    }else if (STATUS_MARCA == 200) {
                        const INDEX = this.marcas.findIndex(marca => marca.id == MARCA.id);
                        this.marcas[INDEX] = MARCA;
                    }

                    break;
                default:
                    break;
            }
        },
        async obtenerProductos(){
            const { data: { data: RESPONSE } } = await this.consulta('/producto/listar');
            this.productos = RESPONSE;            
        },
        async obtenerMarcas(){
            const { data: { data: RESPONSE } } = await this.consulta('/marca/listar');
            this.marcas = RESPONSE;            
        },
        async obtenerCategorias(){
            const { data: { data: RESPONSE } } = await this.consulta('/categoria/listar');
            this.categorias = RESPONSE;            
        },
        limpiarSelect(_selector){
            this.producto[_selector] = null;
        },
        handleHide() {
            this.visible = false
        },
        showLightbox(i) {
            if(this.imagenPreview.length > 0){
                this.index = i;
                this.visible = true;
            }
        },
        cargarDatosEnFormulario(_event, _modulo){
            const OBJETO = this.$data[`${_modulo}s`].find(pbj => pbj.id == _event.data.id);
            if(OBJETO){
                Object.entries(OBJETO).forEach(([key, value]) => {
                    if(key == 'imagen') this.imagenPreview = [value];
                    this.$data[_modulo][key] = value; 
                });
            }
        },
        seleccionarFila(_fila){

        },
        /**
         * Metodo para borrar los campos del formulario
         * @param _formulario 
         */
        limpiarFormulario(_formulario){
            Object.entries( this.$data[_formulario] ).forEach( ([key, value]) => {
                this.$data[_formulario][key] = null;
            } );
        },

        agregarAtributo(){
            this.listaAtributos.push(this.atributo);
            this.atributo = null;
        },

        eliminarAtributo(_atributo){
            this.listaAtributos = this.listaAtributos.filter(atributo => atributo != _atributo);
            delete this.producto.atributos[_atributo];
        }

    },
    mounted() {
        this.obtenerMarcas(); 
        this.obtenerCategorias(); 
        this.obtenerProductos(); 
    },
    computed: {
        productosComputada() {
            const PRODUCTOS = this.productos.map(({marca_id, categoria_id, imagen, activo, ...producto}) => {
                const categoria = this.categorias.find(categoria => categoria.id == categoria_id)?.categoria;
                const marca = this.marcas.find(marca => marca.id == marca_id)?.marca;
                return {
                    ...producto,
                    activo: activo ? 'Si': 'No',
                    categoria: categoria ?? null,
                    marca: marca ?? null
                }
            });
            return PRODUCTOS;
        }
    }
}
</script>
<style scoped>

</style>

