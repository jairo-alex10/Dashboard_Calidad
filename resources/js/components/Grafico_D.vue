<template>
    <div>

<v-img
  :lazy-src="imagen"
  :max-height="largo"
  :max-width="ancho"
  :src="imagen"
></v-img>

    </div>
</template>

<script>

export default {
        props: {
        fecha:String,
        LinMod:String
    },

    data(){
        return {
        imagen:null,
        ancho: 0,
        largo: 0
        }
      },


  /*data() {
    return {
      imagen:'T-shirt-gif/T-shirt_G.gif',
      ancho: 0,
      largo: 0
  }

  },*/
  mounted() {
    
    
    let params={"numero":1};
      
      axios.post("GraficoPlayera",params)
      .then(res => {
          let datos=res.data;
          for (let i = 0; i < datos.length; i++) {
            this.imagen = 'img/T-shirt-gif/T-shirt_'+ datos[i][0]+ '.gif';

          }

      });
    

    switch (screen.width) {
      case 1920:
        this.ancho=500;
        this.largo=500;
        break;

      default:
        this.ancho=50;
        this.largo=50;
        break;
    }
  },
}
</script>