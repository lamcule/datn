<template>
  <div>
    <div
      class="row"
      v
    >
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div
            v-if="data.board"
            class="inner"
          >
            <h3>{{ data.board.total_student }}</h3>

            <p>{{ $t('dashboard.board.total student') }}</p>
          </div>
          <div class="icon">
            <i class="ion ion-university" />
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div
            v-if="data.board"
            class="inner"
          >
            <h3>{{ data.board.total_course }}</h3>

            <p>{{ $t('dashboard.board.total course') }}</p>
          </div>
          <div class="icon">
            <i class="ion ion-cube" />
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div
            v-if="data.board"
            class="inner"
          >
            <h3>{{ data.board.total_grade }}</h3>

            <p>{{ $t('dashboard.board.total grade') }}</p>
          </div>
          <div class="icon">
            <i class="ion ion-android-apps" />
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div
            v-if="data.board"
            class="inner"
          >
            <h3>{{ data.board.total_address }}</h3>

            <p>{{ $t('dashboard.board.total address') }}</p>
          </div>
          <div class="icon">
            <i class="ion ion-ios-book-outline" />
          </div>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">
              Chart of participant by time
            </h3>
          </div>
          <div

            class="box-body"
          >
            <BarChar
              v-if="loadedChart1"
              :chartdata="chart1.chartdata"
              :options="chart1.options"
              :height="301"
            />
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">
              Chart of participant by area
            </h3>
          </div>
          <div

                  class="box-body"
          >
            <div class="row">
              <div class="col-md-6">
                <PieChart
                        v-if="loadedChart2"
                        :chartdata="chart2.chartdata"
                        :options="chart2.options"
                        :height="301"
                />
              </div>
              <div class="col-md-6">
                <ul style="list-style-type: none;">
                  <li v-for="(label,lblIndex) in chart2.chartdata.labels" :key="lblIndex"> <span class="legend-box" :style="{background: getColor(chart2.chartdata.datasets[0].backgroundColor,lblIndex)}"></span>{{label}}</li>
                </ul>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">
              Chart of course by time
            </h3>
          </div>
          <div

                  class="box-body"
          >
            <LineChart
                    v-if="loadedChart3"
                    :chartdata="chart3.chartdata"
                    :options="chart3.options"
                    :height="301"
            />
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">
              Chart of course by area
            </h3>
          </div>
          <div

                  class="box-body"
          >
            <div class="row">
              <div class="col-md-6">
                <PieChart
                        v-if="loadedChart4"
                        :chartdata="chart4.chartdata"
                        :options="chart4.options"
                        :height="301"
                />
              </div>
              <div class="col-md-6">
                <ul style="list-style-type: none;">
                  <li v-for="(label,lblIndex) in chart4.chartdata.labels" :key="lblIndex"> <span class="legend-box" :style="{background: getColor(chart4.chartdata.datasets[0].backgroundColor,lblIndex)}"></span>{{label}}</li>
                </ul>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
import axios from 'axios'
import BarChar from '../chart/BarChart'
import PieChart from '../chart/PieChart'
import LineChart from '../chart/LineChart'

export default {
  components: {
    BarChar,
    PieChart,
    LineChart
  },
  props: {
    locales: { default: null },
    pageTitle: { default: null, String }
  },
  data () {
    return {
      loadedChart1: false,
      loadedChart2: false,
      loadedChart3: false,
      loadedChart4: false,
      data: {

      },
      chart1: {

        chartdata: {
          labels: [],
          datasets: []
        },
        options: {
          responsive: true,
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }],
            xAxes: [{
              maxBarThickness: 100
            }]
          },
          maintainAspectRatio: false,
          legend: {
            display: false
          }
        }
      },
      chart2: {

        chartdata: {
          labels: [],
          datasets: []
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            display: false
          }
        }
      },
      chart3: {

        chartdata: {
          labels: [],
          datasets: []
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            display: false
          }
        }
      },
      chart4: {

        chartdata: {
          labels: [],
          datasets: []
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            display: false
          }
        }
      }

    }
  },
  computed: {},
  mounted () {
    this.fetchData()
  },
  methods: {
    getColor(source, index) {
      let cIndex = index
      if (index > (source.length -1)) {
        cIndex = source.length -1
      }
      return source[cIndex]
    },
    fetchData () {
      axios.get(route('api.dashboard.index'))
        .then((response) => {
          this.loading = false
          this.data = response.data
        })
      axios.get(route('api.dashboard.chart1'))
        .then((response) => {
          this.chart1.chartdata.datasets = response.data.datasets
          this.chart1.chartdata.labels = response.data.labels
          this.loadedChart1 = true
        })
      axios.get(route('api.dashboard.chart2'))
        .then((response) => {
          this.chart2.chartdata.datasets = response.data.datasets
          this.chart2.chartdata.labels = response.data.labels
          this.loadedChart2 = true
        })
      axios.get(route('api.dashboard.chart3'))
        .then((response) => {
          this.chart3.chartdata.datasets = response.data.datasets
          this.chart3.chartdata.labels = response.data.labels
          this.loadedChart3 = true
        })
      axios.get(route('api.dashboard.chart4'))
        .then((response) => {
          this.chart4.chartdata.datasets = response.data.datasets
          this.chart4.chartdata.labels = response.data.labels
          this.loadedChart4 = true
        })
    }
  }
}
</script>

<style  >
  .legend-box {
    display: inline-block;
    width: 10px;
    height: 10px;
    margin-right: 10px;
  }

</style>
