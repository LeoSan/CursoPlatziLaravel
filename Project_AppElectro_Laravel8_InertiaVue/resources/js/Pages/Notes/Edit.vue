<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modulo de Notas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px0">
                                   <h3 class="text-lg text-gray-900">Editar una nota</h3>
                                   <p class="text-sm text-gray-600">Editar no podras volver deshacer tus cambios </p> 
                            </div>
                        </div>

                    </div>
                    <div class="md: col-span-2 mt-5 md:mt-0">
                        <div class="shadow bg-while md:rounded-md p-4">
                            <form>
                                <label class="block font-medium text-sm text-gray-700">Resumen</label>
                                <textarea 
                                    class="form-input w-full rounded-md shadow-sm"
                                    v-model="form.excerpt"
                                    ></textarea>                                
                                <label class="block font-medium text-sm text-gray-700">Contenido</label>
                                <textarea 
                                    class="form-input w-full rounded-md shadow-sm"
                                    v-model="form.content"
                                    rows="8"
                                    ></textarea>
                                    <button 
                                        class="bg-blue-500 hover:bg-blue-700 rounded-md text-white font-bold py-2 px-4"
                                    
                                    >Editar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import {  Link } from '@inertiajs/inertia-vue3';
    

    export default defineComponent({
        components: {
            AppLayout,
            Link
        },
        props:{
            //Definimos valor
            note:Object,
        },
        data(){
            return{
                form:{
                   excerpt: this.note.excerpt,
                   content: this.note.content,
                }

            }
        }
    })
</script>
