<template>
  <app-layout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Modulo de Graficas
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
              <div class="px-4 sm:px0">
                <h3 class="text-lg text-gray-900">Listado de Graficas</h3>
                <p class="text-sm text-gray-600">
                  Repertorio de Graficas
                </p>
              </div>
            </div>
          </div>
          <div class="md: col-span-2 mt-5 md:mt-0">
            <div class="shadow bg-while md:rounded-md p-4">
                Grafica 1 
                  
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
  components: {
    AppLayout,
    Link,
  },


});
</script>
