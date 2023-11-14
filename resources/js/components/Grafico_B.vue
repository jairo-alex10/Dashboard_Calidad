<template>
    <div>

        <v-card color="#E3F2FD">
    <v-card-title class="bg-blue" height="1000">
        <span class="text-h4"><strong>BiHoral Calidad</strong></span>
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
            { text: 'Hora_Inicial', align: 'start', sortable: false, value: 'Hora_Inicial'},
            { text: 'Hora_Final', value: 'Hora_Final' },
            { text: 'Produccion', value: 'Produccion' },
            { text: 'Produccion_Acumulada', value: 'Produccion_Acumulada' },
            { text: 'Meta_Por_Hora', value: 'Meta_Por_Hora' },
            { text: 'Cantidad_Defectos', value: 'Cantidad_Defectos' },
        ],
        dataBihoral: [],
        detener: ''
            }
        },
        mounted() {

            window.Echo.channel(`public.biocast.1`)
       .subscribed(()=>{
        console.log("subscribe");
       })
       .listen('.eventBiHoral',(event)=>{
console.log(event);

let dato=event;
console.log(dato[0].Fecha+" "+dato[0].Linea_Modulo);
if (dato[0].Fecha==this.fecha && dato[0].Linea_Modulo==this.LinMod) {
    this.dataBihoral=event;
//clearInterval(this.detener);
}


       });

       this.capturaBihoral(); 
  //   this.detener=setInterval(this.capturaBihoral,60000);

        },
        methods: {
          
          capturaBihoral()
          {
          
            let params={"fecha":this.fecha, "modline":this.LinMod}
                    
                    axios.post("./index.php/bihoral",params)
          .then(res => {
           // console.log(res.data)
            this.dataBihoral=res.data
          })
          .catch(err => {
            console.error(err); 
          })
          
          }
          
          
                  },


    }
</script>