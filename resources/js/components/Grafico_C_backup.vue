<template>
    <div>
      <apexchart
        ref="myChart"
        type="donut"
        height="500"
        width="500"
        :options="chartOptions"
        :series="series"
      ></apexchart>
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
        series: [],
        chartOptions: {
          chart: {
            width: 1000,
            type: "donut",
          },
  
          title: {
            text: "Resumen FTT: " + this.LinMod,
          },
  
          labels: [],
  
          colors: [
            function ({ value, seriesIndex, w }) {
              //   console.log(w);
  
              // console.log(w.config.series);
  
              if (
                w.config.labels[seriesIndex] == "Nivel De Calidad" &&
                Number(w.config.series[1]) > 75
              ) {
                return "#89ed61";
              } else if (
                w.config.labels[seriesIndex] == "Defectos" &&
                Number(w.config.series[0]) != 0
              ) {
                return "#f5574e";
              } else return "#33c1f5";
            },
          ],
  
          dataLabels: {
            enabled: true,
            formatter: function (value, { seriesIndex, dataPointIndex, w }) {
              /*    return w.config.labels[seriesIndex]+' -'+" % "+w.config.series[seriesIndex]*/
              return w.config.series[seriesIndex] + "%";
            },
            textAnchor: "middle",
            style: {
              fontSize: "14px",
              colors: ["#FFFFFF"],
            },
            
          },
  
          plotOptions: {
            pie: {
              donut: {
                size: "65%",
                background: "transparent",
                labels: {
                  show: true,
                  name: {
                    show: true,
                    fontFamily: "Helvetica, Arial, fantasy",
                    fontWeight: "bold",
                    color: undefined,
                  },
                  value: {
                    show: true,
                    fontFamily: "Helvetica, Arial, fantasy",
                    fontWeight: "bold",
                    color: undefined,
                  },
                  total: {
                    show: true,
                    showAlways: false,
                    fontSize: "22px",
                    label: "Total",
                    fontFamily: "Helvetica, Arial, fantasy",
                    fontWeight: "bold",
                    color: undefined,
                    formatter: function (w) {
                      return w.globals.seriesTotals.reduce((a, b) => {
                        return a + b;
                      }, 0);
                    },
                  },
                },
              },
            },
          },
  
          responsive: [
            {
              breakpoint: 580,
              options: {
                chart: {
                  width: 300,
                },
  
                legend: {
                  position: "bottom",
                },
              },
            },
          ],
        },
        detener: "",
      };
    },
  
    mounted() {
      window.Echo.channel(`public.piecast.1`)
        .subscribed(() => {
          console.log("subscribe");
        })
        .listen(".EventPie", (event) => {
          console.log(event);
  
          this.series = [];
          this.chartOptions.labels = [];
  
          let datos = event;
  
          console.log(datos[0][0] + " " + datos[0][1]);
          if (datos[0][0] == this.fecha && datos[0][1] == this.LinMod) {
            for (let i = 0; i < datos.length; i++) {
              this.series.push(Number(datos[i][5]));
              this.series.push(Number(datos[i][6]));
              this.chartOptions.labels.push("Nivel De Calidad");
              this.chartOptions.labels.push("Defectos");
              this.chartOptions.labels.push("Produccion: " + datos[i][2]);
              this.chartOptions.labels.push("Cantidad Defectos: " + datos[i][3]);
              this.chartOptions.labels.push("Cantidad Aceptada: " + datos[i][4]);
              //this.chartOptions.labels.push("Producción: "+datos[i][2]+"-"+datos[i][2]);
            }
  
            this.$refs.myChart.refresh();
  
            clearInterval(this.detener);
          }
        });
  
      this.capturapie();
      this.detener = setInterval(this.capturapie, 60000);
    },
    methods: {
      capturapie() {
        let params = { fecha: this.fecha, modline: this.LinMod };
  
        this.series = [];
        this.chartOptions.labels = [];
  
        axios
          .post("./index.php/grafico2", params)
          .then((res) => {
            // console.log('Datos-',res.data)
  
            let datos = res.data;
  
            for (let i = 0; i < datos.length; i++) {
              this.series.push(Number(datos[i][5]));
              this.series.push(Number(datos[i][6]));
              this.chartOptions.labels.push("Nivel De Calidad");
              this.chartOptions.labels.push("Defectos");
              this.chartOptions.labels.push("Produccion: " + datos[i][2]);
              this.chartOptions.labels.push("Cantidad Defectos: " + datos[i][3]);
              this.chartOptions.labels.push("Cantidad Aceptada: " + datos[i][4]);
              //this.chartOptions.labels.push("Producción: "+datos[i][2]+"-"+datos[i][2]);
            }
  
            this.$refs.myChart.refresh();
            //console.log('ver Data---',this.series);
            //console.log('ver Nombres', this.chartOptions.labels)
          })
          .catch((err) => {
            console.error(err);
          });
      },
    },
  };
  </script>
  