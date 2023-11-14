<template>
  <div>
    <v-container fluid>
     
      <br>
      <v-row style="padding-left: 130px; padding-right: 130px;">
        <v-col>
          <v-card ref="paretoss"  v-if="ubicar != ''" color="#E3F2FD" :height="largo" :width="ancho">
            <Pareto :fecha="date" :LinMod="ubicar" v-if="ubicar != ''"></Pareto>
          </v-card>
          <br />
        </v-col>

            <v-col>
              <v-card  ref="playera" v-if="ubicar != ''" color="#E3F2FD"  :width="ancho">
                <br><br/>
                <Playera :fecha="date" :LinMod="ubicar" v-if="ubicar != ''"></Playera>
                <br><br/>
                <br><br/>
              </v-card>
            </v-col>

  
      </v-row>
    </v-container>
  </div>
</template>

<script>
export default {
  props: {
    date:String,
        ubicar:String
    },
  data() {
    return {
     ancho: '100%',
     largo: 630
    };
  },
  mounted() {
    
    var width = window.innerWidth;
var resolucion = $(window).width();

console.log(width);
console.log(resolucion);

if (resolucion>1280 && resolucion<=1680) {

  this.ancho=1270;
  this.largo=650;
  this.scrollpagina();
}
else if (resolucion>1024 && resolucion<=1280) {
  this.ancho=1220;
  this.largo=670;
  this.scrollpagina();
} 
else if(resolucion>800 && resolucion<=1024)
{
  this.ancho=1170;
  this.largo=690;
  this.scrollpagina();
}
else if (resolucion>640 && resolucion<=800) {
  this.ancho=1020;
  this.largo=700;
  this.scrollpagina();
} else {
  this.ancho='100%';
  this.largo=630;
}

  },
  methods: {

scrollpagina()
{
  let posicion=0
  setInterval(()=>{

if (posicion==1) {
  
  this.$refs.paretoss.$el.scrollIntoView({ behavior: 'smooth' });  
posicion=2;
}
else if (posicion==2) 
{
  this.$refs.playera.$el.scrollIntoView({ behavior: 'smooth' });  
posicion=0;
}
else
{
  window.scrollTo(0, 0);
  posicion=1;
}

  }
     ,30000);
}


   
  },
};
</script>
