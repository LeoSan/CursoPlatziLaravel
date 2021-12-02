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
                <h3 class="text-lg text-gray-900">Listado de Notas</h3>
                <p class="text-sm text-gray-600">
                  Toma el registro (ver, Editar, Eliminar)
                </p>
              </div>
            </div>
          </div>
          <div class="md: col-span-2 mt-5 md:mt-0">
            <div class="shadow bg-while md:rounded-md p-4">
              <table>
                <tr v-for="note in notes" v-bind:key="note.id">
                  <td class="border px-4 py-2">
                    {{ note.excerpt }}
                  </td>
                  <td class="px-4 py-2">
                    <diV
                      class="
                        bg-green-500
                        rounded
                        px-3
                        hover:shadow-lg
                        hover:text-gray-300
                      "
                    >
                      <Link :href="route('notes.show', note.id)"> ver </Link>
                    </diV>
                  </td>
                  <td class="px-4 py-2">
                    <diV
                      class="
                        bg-yellow-500
                        rounded
                        px-3
                        hover:shadow-lg
                        hover:text-gray-300
                      "
                    >
                      <Link :href="route('notes.edit', note.id)"> Editar </Link>
                    </diV>
                  </td>
                </tr>
              </table>
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
  props: {
    //Definimos valor
    notes: Array,
  },
});
</script>
