<template>
    <div>
     
<apexchart  ref="myChart" type="line" height="350" :options="chartOptions" :series="series"></apexchart>
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
            name: 'Tipos de Defectiva',
            type: 'column',
            data: []
          }, {
            name: 'Línea Porcentual Acumulada',
            type: 'line',
            data: []
          }],
          chartOptions: {
            chart: {
              height: 350,
              type: 'line',
            },
            stroke: {
              width: [0, 4]
            },
            title: {
              text: 'Defectiva General'
            },
            dataLabels: {
              enabled: true,
              enabledOnSeries: [1],
               formatter: function (val, opts) {
      return val
  }
            },
            labels: [],
            xaxis: {
              type: 'category',
              labels: {
    rotate: -90
  }

            },
            yaxis: [{
              title: {
                text: 'Cantidad Defectos',
                
              },
              type: 'category'
            
            }, {
              opposite: true,
              title: {
                text: 'Porcentaje Acumulado'
              }
            }]
          },
          
        

            }
        },
        mounted() {


           let params={"fecha":this.fecha, "modline":this.LinMod}


            axios.post("pareto",params)
.then(res => {
    console.log(res.data)

let datos=res.data;

let totalfrecuencia=0;

for (let i = 0; i < datos.length; i++) {
  totalfrecuencia+=datos[i][2];
  this.series[0].data.push(Math.trunc(datos[i][2]) );
 this.chartOptions.labels.push(datos[i][0]+"-"+datos[i][1]);
 
}


          for (let i = 0; i < datos.length; i++) {
            if (i == 0) {
             this.series[1].data.push(parseFloat(((datos[i][2] / totalfrecuencia) * 100).toFixed(2)));
            }
            else {
              let newPercent = ((datos[i][2] / totalfrecuencia) * 100) + this.series[1].data[i-1];
             this.series[1].data.push(parseFloat(newPercent.toFixed(2)));
            }
          }
        

this.$refs.myChart.refresh()
console.log(this.series[0].data);

})
.catch(err => {
    console.error(err); 
})


        }
    }
</script>