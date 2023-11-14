<template>
  <div>
    <v-row>
      <v-col>
        <v-card class="mx-auto" max-width="100%" color="#E3F2FD">
          <v-list-item two-line>
            <v-list-item-content>
              <v-list-item-title class="text-h6">
                <p class="text-center">
                  <strong>Nivel Calidad</strong>
                </p>
              </v-list-item-title>
              <v-list-item-subtitle></v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>

          <v-card-text>
            <center>
              <h1 class="tamanio">
                {{ Number(datos[5]) + "%" }}
                <p></p>
                <i class="fa-solid fa-circle-chevron-up fa-lg" style="color: #26822c"></i>
              </h1>
            </center>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col>
        <v-card class="mx-auto" max-width="100%" color="#E3F2FD">
          <v-list-item two-line>
            <v-list-item-content>
              <v-list-item-title class="text-h6">
                <p class="text-center">
                  <strong>Nivel Defectiva</strong>
                </p>
              </v-list-item-title>
              <v-list-item-subtitle></v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>

          <v-card-text>
            <center>
              <h1 style="font-size: 50px">
                {{ Number(datos[6])+"%"}}
                <p></p>
                <i
                  class="fa-solid fa-circle-chevron-down fa-lg"
                  style="color: #ea3e3e"
                ></i>
              </h1>
            </center>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col>
        <v-card class="mx-auto" max-width="100%" color="#E3F2FD">
          <v-list-item two-line>
            <v-list-item-content>
              <v-list-item-title class="text-h6">
                <p class="text-center">
                  <strong>Producción</strong>
                </p>
              </v-list-item-title>
              <v-list-item-subtitle></v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>

          <v-card-text>
            <center>
              <h1 style="font-size: 50px">
                {{ Number(datos[2]) + " pz." }}
                <p></p>
                <i class="fa-solid fa-industry fa-lg" style="color: #c3ab32"></i>
              </h1>
            </center>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col>
        <v-card class="mx-auto" max-width="100%" color="#E3F2FD">
          <v-list-item two-line>
            <v-list-item-content>
              <v-list-item-title class="text-h6">
                <p class="text-center">
                  <strong>Cant. Aceptada</strong>
                </p>
              </v-list-item-title>
              <v-list-item-subtitle></v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>

          <v-card-text>
            <center>
              <h1 style="font-size: 50px">
                {{ Number(datos[3]) + " pz." }}
                <p></p>
                <i class="fa-solid fa-circle-check fa-lg" style="color: #4ab5a5"></i>
              </h1>
            </center>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col>
        <v-card class="mx-auto" max-width="100%" color="#E3F2FD">
          <v-list-item two-line>
            <v-list-item-content>
              <v-list-item-title class="text-h6">
                <p class="text-center">
                  <strong>Cant. Rechazada</strong>
                </p>
              </v-list-item-title>
              <v-list-item-subtitle></v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>

          <v-card-text>
            <center>
              <h1 style="font-size: 50px">
                {{ Number(datos[4]) + " pz." }}
                <p></p>
                <i class="fa-solid fa-circle-xmark fa-lg" style="color: #914540"></i>
              </h1>
            </center>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col>
        <v-card class="mx-auto" max-width="100%" color="#E3F2FD">
          <v-list-item two-line>
            <v-list-item-content>
              <v-list-item-title class="text-h6">
                <p class="text-center">
                  <strong>Reparación</strong>
                </p>
              </v-list-item-title>
              <v-list-item-subtitle></v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>

          <v-card-text>
            <center>
              <h1 style="font-size: 50px">
                {{ Number(datos[7]) + " pz." }}
                <p></p>
                <i
                  class="fa-solid fa-screwdriver-wrench fa-lg"
                  style="color: #4b1f51"
                ></i>
              </h1>
            </center>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
export default {
  props: {
    fecha: String,
    LinMod: String,
  },

  data() {
    return {
      detener: "",
      datos: [],
    };
  },

  mounted() {
    window.Echo.channel(`public.piecast.1`)
      .subscribed(() => {
        console.log("subscribe");
      })
      .listen(".EventPie", (event) => {
        if (event != "") {
          console.log(event);
         

        let dato=event;

          if (dato[0] == this.fecha && dato[1] == this.LinMod) {
            this.datos = [];
            this.datos = event;
          //  clearInterval(this.detener);

          }
        }
      });

    this.capturapie();
   // this.detener = setInterval(this.capturapie, 60000);
  },
  methods: {
    color_custom() {
      if (Number(this.datos[5]) > 84.99) {
        return "green";
      }
      return "red";
    },

    capturapie() {
      let params = { fecha: this.fecha, modline: this.LinMod };
      this.datos = [];

      axios
        .post("./index.php/grafico2", params)
        .then((res) => {
          // console.log('Datos-',res.data)

          this.datos = res.data;

          console.log(this.datos);
        })
        .catch((err) => {
          console.error(err);
        });
    },
  },
};
</script>

<style>
.tamanio {
  font-size: 50px;
  color: v-bind(color_custom());
}
</style>
