<template>
    <div>

        <apexchart  ref="myChart" type="bar" height="600" :options="chartOptions" :series="series"></apexchart>

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

              series: [{
            name: 'Producción',
            data: []
          }, {
            name: 'Metas Por Hora',
            data: []
          }, {
            name: 'Cantidad Acumulada',
            data: []
          }],
          chartOptions: {
            chart: {
              type: 'bar',
              height: 600,
              
            },
            plotOptions: {
              bar: {
                horizontal: false,
                columnWidth: '85%',
                endingShape: 'rounded',
                dataLabels: {
              total: {
                formatter: undefined,
                offsetX: 0,
                offsetY: 0,
                enabled: true,
                style: {
                  fontSize: '50px',
                  color: '#2C3B75',
                  fontFamily: undefined,
                  fontWeight: 600
                }
              }
              
            }
              },
            },
            legend: {
          position: 'left',
          offsetY: 25,
          enabled: false
         
        },
            dataLabels: {
              enabled: false
            },
            stroke: {
              show: true,
              width: 2,
              colors: ['transparent']
            },
            xaxis: {
              categories: [],
            },
            yaxis: {
              title: {
                text: '$ (thousands)'
              }
            },
            fill: {
              opacity: 1
            },
            tooltip: {
              y: {
                formatter: function (val) {
                  return  val 
                }
              }
            },
            colors: ['#2C3B75', '#EE7601', '#ADCEEE'],
            title: {
              text: 'Bihoral',
              align: 'center',
    margin: 5,
    offsetX: 0,
    offsetY: 0,
    floating: false,
    style: {
      fontSize:  '50px',
      fontWeight:  'bold',
      color:  '#263238'
    },    
            },
          },
          
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
if (event!="") {
        console.log(event);
        this.series[0].data=[];
            this.series[1].data=[];
            this.series[2].data=[];
            this.chartOptions.xaxis.categories=[];
            let datos=event; 

console.log(datos[0].Fecha+" "+datos[0].Linea_Modulo);
if (datos[0].Fecha==this.fecha && datos[0].Linea_Modulo==this.LinMod) {
    for (let i = 0; i < datos.length; i++) {

this.series[0].data.push(Math.trunc(datos[i].Produccion) );
this.series[1].data.push(Math.trunc(datos[i].Meta_Por_Hora) );
this.series[2].data.push(Math.trunc(datos[i].Produccion_Acumulada) );

this.chartOptions.xaxis.categories.push(datos[i].Hora_Inicial+"-"+datos[i].Hora_Final);

}

this.$refs.myChart.refresh();
//clearInterval(this.detener);
}
}

       });

      

       this.capturaBihoral(); 
  //   this.detener=setInterval(this.capturaBihoral,60000);

        },
        methods: {
          
          capturaBihoral()
          {
          
            let params={"fecha":this.fecha, "modline":this.LinMod}
          
            this.series[0].data=[];
            this.series[1].data=[];
            this.series[2].data=[];
            this.chartOptions.xaxis.categories=[];

                    axios.post("./index.php/bihoral",params)
          .then(res => {
            console.log(res.data)
  
            let datos=res.data;           

            for (let i = 0; i < datos.length; i++) {

this.series[0].data.push(Math.trunc(datos[i].Produccion) );
this.series[1].data.push(Math.trunc(datos[i].Meta_Por_Hora) );
this.series[2].data.push(Math.trunc(datos[i].Produccion_Acumulada) );

this.chartOptions.xaxis.categories.push(datos[i].Hora_Inicial+"-"+datos[i].Hora_Final);

}

this.$refs.myChart.refresh();
           
          })
          .catch(err => {
            console.error(err); 
          })
          
          }
          
          
                  },


    }
</script>