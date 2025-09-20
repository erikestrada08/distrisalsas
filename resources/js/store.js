import { createStore } from 'vuex';

const store = createStore({
    state() {
        return {
            carrito: [], // Estado para almacenar los productos del carrito
        };
    },
    mutations: {
        agregarAlCarrito(state, producto) {
            state.carrito.push(producto); // Agregar un producto al carrito
        },
        eliminarDelCarrito(state, productoId) {
            state.carrito = state.carrito.filter(producto => producto.id !== productoId); // Eliminar un producto del carrito
        },
    },
    actions: {
        agregarAlCarrito({ commit }, producto) {
            commit('agregarAlCarrito', producto); // Llamada a la mutación para agregar al carrito
        },
        eliminarDelCarrito({ commit }, productoId) {
            commit('eliminarDelCarrito', productoId); // Llamada a la mutación para eliminar del carrito
        },
    },
    getters: {
        obtenerCarrito(state) {
            return state.carrito; // Obtener todos los productos del carrito
        },
        totalCarrito(state) {
            return state.carrito.reduce((total, producto) => total + producto.precio, 0); // Calcular el total del carrito
        },
    },
});

export default store;
