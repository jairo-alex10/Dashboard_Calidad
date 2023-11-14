<template>
  <div>
    <v-carousel cycle interval="3000" hide-delimiters width="100%" >
      <v-carousel-item v-for="(obj, i) in datos">

        <center>
          <img :height="largo" :width="ancho" :key="i" :src="obj.img" width="100%" />
        </center>

      </v-carousel-item>
    </v-carousel>
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
      imagen: null,
      ancho: 0,
      largo: 0,
      datos: "",
      detener: ''
    };
  },

  mounted() {

    window.Echo.channel(`public.measlescast.1`)
       .subscribed(()=>{
        console.log("subscribe");
       })
       .listen('.EventMeaselsChart',(event)=>{
        
      
        console.log(event);
       
        

          })



    //let params = { numero: 1 };
    let params={"fecha":this.fecha, "modline":this.LinMod}

    axios
      .post("./index.php/GraficoPlayera", params)
      .then((res) => {
        this.datos = res.data;

        console.log("Datos de Prenda: ", res.data);

        /*
      for (let i = 0; i < datos.length; i++) {

        this.imagen = "img/T-shirt-gif/T-shirt_" + datos[i][0] + ".gif";
       // this.imagen = "img/T-shirt-gif/T-shirt_G.gif";
      }
    */
      })
      .catch((err) => {
        console.error(err);
      });

    switch (screen.width) {
      case 1920:
        this.ancho = 540;
        this.largo = 560;
        break;

      default:
        this.ancho = 265;
        this.largo = 225;
        break;
    }
  },
};
</script>
