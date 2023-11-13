<template>
    <div>

        <v-card>
    <v-card-title class="bg-blue">
        <span class="text-h6"><strong>BiHoral Calidad</strong></span>
        <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Buscar"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>
    <v-data-table
      :headers="headersdetalle"
      :items="dataBihoral"
      :search="search"
      :footer-props="{
         'items-per-page-text':'Filas por Página',
                }"
      no-data-text="No hay datos disponibles"          
    ></v-data-table>
  </v-card>

    </div>
</template>

<script>
       export default {
        props: {
        fecha:String,
        LinMod:String
    },
        data() {
            return {

search: '',

headersdetalle: [
            { text: 'Hora_Inicial', align: 'start', sortable: false, value: 'Hora_Inicial', },
            { text: 'Hora_Final', value: 'Hora_Final' },
            { text: 'Produccion', value: 'Produccion' },
            { text: 'Produccion_Acumulada', value: 'Produccion_Acumulada' },
            { text: 'Meta_Por_Hora', value: 'Meta_Por_Hora' },
            { text: 'Cantidad_Defectos', value: 'Cantidad_Defectos' },
        ],
        dataBihoral: [],
            }
        },
        mounted() {

            let params={"fecha":this.fecha, "modline":this.LinMod}

            axios.post("bihoral",params)
.then(res => {
    console.log(res.data)
    this.dataBihoral=res.data
})
.catch(err => {
    console.error(err); 
})


        }

    }
</script>