<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Plantilla from '@/Layouts/Plantilla.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    
    <Head title="Log in" />
    <Plantilla>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <div class="flex gap-1 min-h-full flex-col items-center pt-6 sm:justify-center sm:pt-0 dark:bg-gray-900">
            <div class="w-full overflow-hidden bg-white p-6 shadow-md sm:max-w-md sm:rounded-lg dark:bg-gray-800 flex flex-col items-center justify-center">
                <!-- <div>
                    <Link href="/">
                        <ApplicationLogo class="h-20 w-20 fill-current text-gray-500"/>
                    </Link>
                </div> -->
                <form class="w-full flex flex-col gap-1" @submit.prevent="submit">
                    <div>
                        <InputLabel for="email" value="Correo electrónico" />
        
                        <!-- value="estrada.erik321@gmail.com" -->
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="username"
                        />
        
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
        
                    <div class="">
                        <InputLabel for="password" value="Contraseña" />
        
                        <!-- value="2124Edep" -->
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                        />
        
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>
        
                    <div class="flex justify-between">
                        <label class="flex items-center">
                            <Checkbox name="remember" v-model:checked="form.remember" />
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400"
                                >
                                    Recordar mis credenciales
                                </span>
                            </label>
                        <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                        >
                            Olvidé mi contraseña?
                        </Link>
                    </div>

                    <!-- boton google -->
                    <div class="flex flex-col gap-1 justify-center items-center">
                        <span class="mt-4">- Iniciar sesión con -</span>
                        <button class="relative w-2/3 p-2 rounded-full border border-gray-500 shadow-md flex hover:bg-gray-100 h-10">
                            <span class="absolute top-1/2 right-1/2 translate-x-1/2 -translate-y-1/2 text-sm font-bold text-nowrap">Iniciar Sesión</span>
                        </button>
                        <button class="relative w-2/3 p-2 rounded-full border border-gray-500 shadow-md flex hover:bg-gray-100">
                            <img src="/imagenes/logo-google.svg" alt="google" class="w-6">
                            <span class="absolute top-1/2 right-1/2 translate-x-1/2 -translate-y-1/2 text-sm font-bold text-nowrap">Iniciar sesión con Google</span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="w-full overflow-hidden bg-white p-6 shadow-md sm:max-w-md sm:rounded-lg dark:bg-gray-800 flex gap-2 items-center justify-center">
                ¿No tienes cuenta?
                <Link 
                :href="route('register')"
                class="text-blue-500 underline">Registrate</Link>
            </div>
        </div>
    </Plantilla>
</template>
