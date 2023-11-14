<template>
    <div >
      
            <v-row>
          <v-col style="padding-left: 160px; padding-right: 160px;">
            <v-card v-if="ubicar != ''" color="#E3F2FD" width="100%">
            <Grafico-Bihoral :fecha="date" :LinMod="ubicar" v-if="ubicar != ''" ></Grafico-Bihoral>
            </v-card>
          </v-col>    
        </v-row>
     
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
       
      };
    },
    mounted() {
      
    },
    methods: {
     
    },
  };
  </script>
  