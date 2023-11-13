<template>
  <div class="container">
    <v-card class="mx-auto" variant="flat" width="600px">
      <v-card-text>
        <v-row>
          <v-col>

            <v-dialog ref="dialog" v-model="modal" :return-value.sync="date" persistent width="360px">
              <template v-slot:activator="{ on, attrs }">
                <v-text-field v-model="date" label="Fecha Producción" prepend-icon="mdi-calendar" readonly v-bind="attrs"
                  v-on="on"></v-text-field>
              </template>

              <v-date-picker v-model="date" locale="es-es" scrollable>

                <v-spacer></v-spacer>
                <v-btn text color="primary" @click="modal = false">
                  Cancelar
                </v-btn>
                <v-btn text color="primary" @click="$refs.dialog.save(date)">
                  Aceptar
                </v-btn>
              </v-date-picker>

            </v-dialog>

          </v-col>

          <v-col>

            <v-autocomplete v-model="ubicar" :items="ubicaciones" dense filled label="Selecciona una Ubicacion"
              @change="limpiar()"></v-autocomplete>

          </v-col>

        </v-row>

      </v-card-text>

    </v-card>

    <v-container fluid>
      <v-row dense>
        <v-col>
          <v-card v-if="opcion == true">

            <Pareto :fecha="date" :LinMod="ubicar2" v-if="opcion == true"></Pareto>
          </v-card>
          <br>

          <v-row >

            <v-col height = 750>

              <v-card v-if="opcion == true">
                <Grafico2 :fecha="date" :LinMod="ubicar2" v-if="opcion == true"></Grafico2>

              </v-card>

            </v-col>
            <v-col>
  <v-card>
<Playera :fecha="date" :LinMod="ubicar2" v-if="opcion == true"></Playera>
  </v-card>
  
</v-col>

          </v-row>

        </v-col>




        <v-col>


          
          <v-card>
            <Bihoral :fecha="date" :LinMod="ubicar2" v-if="ubicar2!='' && opcion == true"></Bihoral>
          </v-card>

        </v-col>



      </v-row>
    </v-container>


  </div>
</template>

<script>
export default {
  data() {
    return {
      date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
      menu: false,
      modal: false,
      menu2: false,
      ubicaciones: [],
      ubicar: '',
      ubicar2:'',
      opcion: false
    }
  },
  mounted() {

    axios.get("LineaModulo")
      .then(res => {
        console.log(res.data);
        this.ubicaciones = res.data;
      })
      .catch(err => {
        console.error(err);
      })

  },
  methods: {
    limpiar() {
     this.ubicar2="";
     this.opcion=false;
     if (this.ubicar2=="") {
       this.opcion=true;
      this.ubicar2=this.ubicar;
      this.ubicar="";
     }
    }
  },


}
</script>

