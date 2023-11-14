<template>
    <div>
     
<apexchart  ref="myChart" type="line" height="630" width="100%" :options="chartOptions" :series="series"></apexchart>
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
              stacked: true,
          toolbar: {
            show: true
          },
          zoom: {
            enabled: false
          }


            },
            
            title: {
              text: 'Defectiva General',
              align: 'center',
    margin: 10,
    offsetX: 0,
    offsetY: 0,
    floating: false,
    style: {
      fontSize:  '32px',
      fontWeight:  'bold',
      color:  '#263238'
    },    
            },
            dataLabels: {
              enabled: true,
              enabledOnSeries: [1],
          textAnchor: 'middle',
  distributed: false,
  offsetX: 0,
  offsetY: 0,
  style: {
      fontSize: '24px',
      fontFamily: 'Helvetica, Arial, sans-serif',
      fontWeight: 'bold',
      
  },
  background: {
    enabled: true,
    foreColor: '#fff',
    padding: 4,
    borderRadius: 2,
    borderWidth: 1,
    borderColor: '#fff',
    opacity: 0.9,
    dropShadow: {
      enabled: false,
      top: 1,
      left: 1,
      blur: 1,
      color: '#000',
      opacity: 0.45
    }
  },
  dropShadow: {
      enabled: false,
      top: 1,
      left: 1,
      blur: 1,
      color: '#000',
      opacity: 0.45
  }  
            },
            
            labels: [],
            xaxis: {
              type: 'category',
              labels: {
    rotate: -90
  },
  labels: {
          style: {
              colors: [],
              fontSize: '18px',
              cssClass: 'apexcharts-xaxis-label',
          },
          },

            },
            yaxis: [{
              title: {
                text: '',  
              },
              type: 'category'
            
            }, {
              opposite: false,
              title: {
                text: ''
              }
            }],
            legend: {
          position: 'top',
          offsetY: -100,
          enabled: false
         
        },
        colors: ['#2C3B75', '#EE7601'],

        plotOptions: {
          bar: {
            horizontal: false,
          borderRadius: 0,
          borderRadiusApplication: 'around',
          borderRadiusWhenStacked: 'last',
          columnWidth: '70%',
          barHeight: '70%',
          distributed: false,
          rangeBarOverlap: false,
          rangeBarGroupRows: false,
          hideZeroBarsWhenGrouped: false,
          isDumbbell: false,
          dumbbellColors: undefined,
          isFunnel: false,
          isFunnel3d: false,
            position: 'top',
            maxItems: 100,
            hideOverflowingLabels: true,
            horizontal: false,
            colors: {
              ranges: [{
                  from: 0,
                  to: 0,
                  color: undefined
              }],
              backgroundBarColors: [],
              backgroundBarOpacity: 1,
              backgroundBarRadius: 0,
          },
            dataLabels: {
              total: {
                formatter: undefined,
                offsetX: 0,
                offsetY: 0,
                enabled: true,
                style: {
                  fontSize: '35px',
                  color: '#2C3B75',
                  fontFamily: undefined,
                  fontWeight: 600
                }
              }
              
            }
          },
        },

          },
          
        detener: ''

            }
        },
       
        mounted() {

       window.Echo.channel(`public.playground.1`)
       .subscribed(()=>{
        console.log("subscribe");
       })
       .listen('.EventParetos',(event)=>{
        
      if (event!="") {
        console.log(event);
        this.chartOptions.labels=[];
        this.series[1].data=[];
        this.series[0].data=[];
        let totalfrecuencia=0;

        let datos=event;
        
        console.log(datos[0][3]+" "+datos[0][4]);

if (datos[0][3]==this.LinMod && datos[0][4]==this.fecha) {
  
  

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

this.$refs.myChart.refresh();
//clearInterval(this.detener);


}

      }  
        

          })

          this.consultarpareto();
//this.detener=setInterval(this.consultarpareto,60000);

        },
        methods: {
         
  consultarpareto()
  {
    console.log("Ingreso al timer")
    let params={"fecha":this.fecha, "modline":this.LinMod}

    this.chartOptions.labels=[];
this.series[1].data=[];
this.series[0].data=[];


axios.post("./index.php/paretos",params)
.then(res => {
console.log(res.data)
if (res.data!="") {

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

}

//console.log(this.series[0].data);

})
.catch(err => {
console.error(err); 
})


  }        


        },
    }
</script>