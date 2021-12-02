<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div>
                <jet-application-logo class="block h-12 w-auto" />
            </div>

            <div class="mt-8 text-2xl">
                Bienvenido Usuario
            </div>

            <div class="mt-6 text-gray-500">
                Laravel Jetstream proporciona un punto de partida hermoso y robusto para su próxima aplicación de Laravel. Laravel está diseñado
                para ayudarle a crear su aplicación utilizando un entorno de desarrollo simple, potente y agradable. Creemos
                te encantará expresar tu creatividad a través de la programación, por eso hemos dedicado tiempo a crear cuidadosamente el Laravel
                ecosistema para ser un soplo de aire fresco. Esperamos que te guste.
            </div>
        </div>

            <div class="md:flex flex min-h-screen">
                    <div class="md:w-2/5 xl:w-1/5 bg-green-600">
                            <div class="p-6">
                                   <p class="uppercase text-white text-2xl tracking-wide text-center font-bold" >Menú

                                   </p>

                                   <p class="mt-2 text-white text-xl font-bold">Catalagos</p>

                                   <nav class="mt-2" >

                                          <div class="flex flex-nowrap hover:bg-gray-500 hover:cursor-pointer">

                                                 <div class=" px-1 py-1  text-white mr-2"  >
                                                        Ver Categorias
                                                 </div>
                                          </div>




                                   </nav>
                                   <p class="mt-2 text-white text-xl font-bold">Funcionalidad</p>

                                   <nav class="mt-2" >


                                          <div class="flex flex-nowrap hover:bg-yellow-500 hover:cursor-pointer">

                                                 <div class=" px-1 py-1  text-white mr-2" >
                                                        Acto
                                                 </div>
                                          </div>


                                   </nav>
                                   <p class="mt-2 text-white text-xl font-bold">Notificaciones</p>

                                   <nav class="mt-2" >
                                          <div class="flex flex-nowrap hover:cursor-pointer hover:bg-gray-500">

                                                 <div class=" px-1 py-1  text-white mr-2 ">
                                                        Alarmas
                                                 </div>
                                          </div>


                                   </nav>


                            </div>

                </div>
                <div class="md:w-3/5 xl:w-4/5 p-6">

                  <div>
                    
                                    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-300 to-blue-400">

                                
                                    <div class="w-64 bg-white rounded shadow-2xl">
                                
                                    
                                    <div class="h-32 bg-gray-200 rounded-tr rounded-tl animate-pulse"></div>
                                
                                    <div class="p-5">
                                    
                                        <div class="h-6 rounded-sm bg-gray-200 animate-pulse mb-4"></div>
                                
                                    
                                        <div class="grid grid-cols-4 gap-1">
                                        <div class="col-span-3 h-4 rounded-sm bg-gray-200 animate-pulse"></div>
                                        <div class="h-4 rounded-sm bg-gray-200 animate-pulse"></div>
                                
                                        <div class="col-span-2 h-4 rounded-sm bg-gray-200 animate-pulse"></div>
                                        <div class="col-span-2 h-4 rounded-sm bg-gray-200 animate-pulse"></div>
                                
                                        <div class="h-4 rounded-sm bg-gray-200 animate-pulse"></div>
                                        <div class="col-span-3 h-4 rounded-sm bg-gray-200 animate-pulse"></div>
                                        <div class="col-span-2 h-4 rounded-sm bg-gray-200 animate-pulse"></div>
                                        <div class="h-4 rounded-sm bg-gray-200 animate-pulse"></div>
                                        </div>
                                
                                    </div>
                                
                                    </div>
                                
                                </div>                     
                  </div>
                    
                </div>
           </div>         


    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetApplicationLogo from '@/Jetstream/ApplicationLogo.vue'

    export default defineComponent({
        components: {
            JetApplicationLogo,
        },
    })
</script>
