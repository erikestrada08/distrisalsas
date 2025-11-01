<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <div>
        <Head title="Register" />
        <GuestLayout>
            <div class="flex gap-1 min-h-full flex-col items-center pt-6 sm:justify-center sm:pt-0">
                <div class="w-full overflow-hidden bg-white p-6 shadow-md sm:max-w-md sm:rounded-lg flex flex-col items-center justify-center">
                    <form 
                    class="w-full flex flex-col gap-1"
                    @submit.prevent="submit">
                        <div>
                            <InputLabel for="name" value="Nombre" />
        
                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                            />
        
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
        
                        <div class="">
                            <InputLabel for="email" value="Correo electrónico" />
        
                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required
                                autocomplete="username"
                            />
        
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
        
                        <div class="">
                            <InputLabel for="password" value="Contraseña" />
        
                            <TextInput
                                id="password"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.password"
                                required
                                autocomplete="new-password"
                            />
        
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>
        
                        <div class="">
                            <InputLabel
                                for="password_confirmation"
                                value="Confirma la contraseña"
                            />
        
                            <TextInput
                                id="password_confirmation"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                            />
        
                            <InputError
                                class="mt-2"
                                :message="form.errors.password_confirmation"
                            />
                        </div>
        
                        <Link
                            :href="route('login')"
                            class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Ya estás registrado?
                        </Link>
                        <div class=" flex items-center justify-center">
        
                            <!-- <PrimaryButton
                                class="ms-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Register
                            </PrimaryButton> -->
                            <button class="relative w-2/3 p-2 rounded-full border border-gray-500 shadow-md flex hover:bg-gray-100 h-10">
                                <span class="absolute top-1/2 right-1/2 translate-x-1/2 -translate-y-1/2 text-sm font-bold text-nowrap">Registrarse</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        
        </GuestLayout>
    </div>
</template>

