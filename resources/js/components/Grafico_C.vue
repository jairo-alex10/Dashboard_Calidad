<template>
    <div>
     
<apexchart ref="myChart" type="donut" height="500" :options="chartOptions" :series="series"></apexchart>
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

       series: [],
          chartOptions: {
            chart: {
              width: 500,
              type: 'donut',
            },

            title: {
              text: 'Resumen FTT: ' + this.LinMod
            },

            labels: [],

            colors: [function({ value, seriesIndex, w }) {
          if (Number(w.config.series[seriesIndex]) < 84.99) {
              return '#80e85a'
          } else {
              return '#c74942'
          }
        }, function({ value, seriesIndex, w }) {
          if (Number(w.config.series[seriesIndex]) > 85) {
              return '#80e85a'
          } else {
              return '#c74942'
          }
}],

            dataLabels: {
              enabled: true,
formatter: function(value, { seriesIndex, dataPointIndex, w }) {
/*    return w.config.labels[seriesIndex]+' -'+" % "+w.config.series[seriesIndex]*/
    return w.config.series[seriesIndex]+"%"
  },
  textAnchor: 'middle',
  style: {
      fontSize: '15px',
      fontFamily: 'Helvetica, Arial, fantasy',
      fontWeight: 'bold',
      colors: ['#edede8']
  },
            },


plotOptions: {
  pie: {
    donut: {
      size: '55%',
      background: 'transparent',
      labels: {
        show: true,
        name: {
          show: true,
          fontFamily: 'Helvetica, Arial, fantasy',
          fontWeight: 'bold',
          color: undefined,
        },
        value: {
          show: true,
          fontFamily: 'Helvetica, Arial, fantasy',
          fontWeight: 'bold',
          color: undefined,
        },
        total: {
          show: true,
          showAlways: false,
          fontSize: '22px',
          label: 'Total',
          fontFamily: 'Helvetica, Arial, fantasy',
          fontWeight: 'bold',
          color: undefined,
          formatter: function (w) {
            return w.globals.seriesTotals.reduce((a, b) => {
              return a + b
            }, 0)
          }
        }
      }
    }
  }
},

            responsive: [{
              breakpoint: 480,
              options: {
                chart: {
                  width: 200
                },
               
                legend: {
                  position: 'bottom'
                }
              
              }
            }],

          },

            }
        },


mounted() {
 
            let params={"fecha":this.fecha, "modline":this.LinMod}


axios.post("grafico2",params)
.then(res => {
    console.log('Datos-',res.data)

let datos=res.data;

for (let i = 0; i < datos.length; i++) {
 this.series.push(Number(datos[i][5]));
 this.series.push(Number(datos[i][6]));
 this.chartOptions.labels.push("Nivel De Calidad");
 this.chartOptions.labels.push("Defectos");
 this.chartOptions.labels.push("Produccion: "+datos[i][2]); 
 this.chartOptions.labels.push("Cantidad Defectos: "+datos[i][3]); 
 this.chartOptions.labels.push("Cantidad Aceptada: "+datos[i][4]); 
 //this.chartOptions.labels.push("Producción: "+datos[i][2]+"-"+datos[i][2]);

}

this.$refs.myChart.refresh()
console.log('ver Data---',this.series);
console.log('ver Nombres', this.chartOptions.labels)


})
.catch(err => {
    console.error(err); 
})
        }
        
    }
</script>