<template>
    <div>
        <v-navigation-drawer
      v-model="drawer"
      :mini-variant.sync="mini"
      permanent
      style=" position: fixed; z-index: 1000;"
    >
      <v-list-item class="px-2">
        <v-list-item-avatar>
          <v-img src="img/logotipos/4.png"></v-img>
        </v-list-item-avatar>

        <v-list-item-title>Hoosier Manufacturing</v-list-item-title>

        <v-btn
          icon
          @click.stop="mini = !mini"
        >
          <v-icon>mdi-chevron-left</v-icon>
        </v-btn>
      </v-list-item>

      <v-divider></v-divider>

      <v-list dense>
        <v-list-item
          v-for="item in items"
          :key="item.title"
          link
          @click="opcion=item.id"
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-row style="padding-left: 100px; padding-top: 50px;">
        
          <v-col>
            <v-dialog
              ref="dialog"
              v-model="modal"
              :return-value.sync="date"
              persistent
              width="360px"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  v-model="date"
                  label="Fecha Producción"
                  prepend-inner-icon="mdi-calendar"
                  v-bind="attrs"
                  v-on="on"
                  filled
            rounded
            dense
                ></v-text-field>
              </template>

              <v-date-picker v-model="date" locale="es-es" scrollable>
                <v-spacer></v-spacer>
                <v-btn text color="primary" @click="modal = false"> Cancelar </v-btn>
                <v-btn text color="primary" @click="$refs.dialog.save(date)">
                  Aceptar
                </v-btn>
              </v-date-picker>
            </v-dialog>
          </v-col>

          <v-col>
            <v-autocomplete
              v-model="ubicar"
              :items="ubicaciones"
              label="Selecciona una Ubicacion"
              filled
            rounded
            dense
            ></v-autocomplete>
          </v-col>
          <v-col>
            <v-btn depressed color="primary" @click="limpiar()" rounded> Limpiar </v-btn>
          </v-col>
          <v-col>
            <center>
              <v-img
  max-height="150"
  max-width="250"
  src="img/logotipos/Hoosier Logo.png"
></v-img>
            </center>
            
          </v-col>

        </v-row>


        <v-row style="padding-left: 150px; padding-right: 150px;">
  <v-col>
  
    <Grafico2 :fecha="date" :LinMod="ubicar" v-if="ubicar != ''"></Grafico2>
   
    </v-col>
</v-row>
<br>
<Calidad :date="date" :ubicar="ubicar"  v-if="opcion==1"></Calidad>
<Produccion :date="date" :ubicar="ubicar"  v-if="opcion==2"></Produccion>
<br>
<br>
<v-footer  v-if="opcion>0 && ubicar!=''" style="padding-left: 100px; padding-top: 50px;">
  <v-row>
    
    <v-col style="display: flex; justify-content: flex-end">
      <img src="img/logotipos/slogan.png"
    height="200"
  width="200"
    />
    </v-col>
  </v-row>
    
  </v-footer>
    </div>
</template>

<script>
  export default {
    data () {
      return {
        drawer: true,
        items: [
        
          { title: 'Calidad', icon: 'fa-solid fa-certificate', id: 1 },
          { title: 'Produccion', icon: 'fa-solid fa-gears' , id: 2 },
         /* { title: 'Users', icon: 'mdi-account-group-outline', id: 3 },*/
        ],
        mini: true,
        date: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
        .toISOString()
        .substr(0, 10),
      menu: false,
      modal: false,
      menu2: false,
      ubicaciones: [],
      ubicar: "",
      opcion: 1
      }
    },
mounted() {

    axios
      .get("./index.php/LineaModulo")
      .then((res) => {
        // console.log(res.data);
        this.ubicaciones = res.data;
      })
      .catch((err) => {
        console.error(err);
      });


setInterval(() => {
  
if (this.opcion==1) {
  this.opcion=2;
  console.log(this.opcion);
}
else
{
  this.opcion=1;
  console.log(this.opcion);
}


}, 900000);


  },
  methods: {
    limpiar() {
      this.ubicar = "";
    },
  },

  }
</script>