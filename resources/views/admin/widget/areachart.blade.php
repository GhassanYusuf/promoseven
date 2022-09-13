@php

    // Include Employees Controller
    //use App\Http\Controllers\ReportsController; 

    // Get The Boxes Values
    //$boxes = (new ReportsController)->boxes();

@endphp

<div class="row">

    {{-- Left Chart Section --}}
    <section class="col-sm-8">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card card-outline card-info">
            <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-area mr-1"></i>
                Sales
            </h3>
            <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                        <a class="btn btn-sm btn-info mr-2" href="#revenue-chart" data-toggle="tab">Line</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-sm btn-info" href="#sales-chart" data-toggle="tab">Donut</a>
                    </li>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </ul>
            </div>
            </div><!-- /.card-header -->
            <div class="card-body">
            <div class="tab-content p-0">
                <!-- Morris chart - Sales -->
                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                    <canvas id="genderchart" height="300" style="height=300px;"></canvas>
                    {{-- <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas> --}}
                </div>
                <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                </div>
            </div>
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>

    {{-- Right Chart Section --}}
    <section class="col-sm-4">
        <!-- BAR CHART -->
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Bar Chart
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a class="btn btn-sm btn-info mr-2" href="#revenue-chart" data-toggle="tab">Line</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-sm btn-info" href="#sales-chart" data-toggle="tab">Donut</a>
                        </li>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="chart">
                    {{-- <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas> --}}
                </div>
            </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>

</div>

<script>

    // Creating A Chart From An Element
    // let natChart = document.getElementById('natChart').getContext('2d');
    // let comChart = document.getElementById('comChart').getContext('2d');
    // let visChart = document.getElementById('visChart').getContext('2d');

    // Global Options
    Chart.defaults.global.defaultFontFamily = 'Arial';
    Chart.defaults.global.defaultFontSize = 12;
    Chart.defaults.global.defaultFontColor = '#777';

    // let massPopChart = new Chart(natChart, );

    const data1 = {
      type:'doughnut', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
      data:{
        labels:['Boston', 'Worcester', 'Springfield', 'Lowell', 'Cambridge', 'New Bedford'],
        // labels: ,
        datasets:[{
          label:'Population',
          data:[ 617594, 181045, 153060, 106519, 105162, 95072 ],
        //   data: ,
          backgroundColor:'green',
          backgroundColor:[
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
            'rgba(153, 102, 255, 0.6)',
            'rgba(255, 159, 64, 0.6)',
            'rgba(255, 99, 132, 0.6)'
          ],
          borderWidth:1,
          borderColor:'#777',
          hoverBorderWidth:3,
          hoverBorderColor:'#000'
        }]
      },
      options:{
        title:{
          display:false,
          text:'Largest Cities In Massachusetts',
          fontSize:25
        },
        legend:{
          display:false,
          position:'top',
          labels:{
            fontColor:'#000'
          }
        },
        layout:{
          padding:{
            left:50,
            right:0,
            bottom:0,
            top:0
          }
        },
        tooltips:{
          enabled:true
        }
      }
    };

    const data2 = {
      type:'pie', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
      data:{
        labels:['Boston', 'Worcester', 'Springfield', 'Lowell', 'Cambridge', 'New Bedford'],
        datasets:[{
          label:'Population',
          data:[
            617594,
            181045,
            153060,
            106519,
            105162,
            95072
          ],
          //backgroundColor:'green',
          backgroundColor:[
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
            'rgba(153, 102, 255, 0.6)',
            'rgba(255, 159, 64, 0.6)',
            'rgba(255, 99, 132, 0.6)'
          ],
          borderWidth:1,
          borderColor:'#777',
          hoverBorderWidth:3,
          hoverBorderColor:'#000'
        }]
      },
      options:{
        title:{
          display:false,
          text:'Largest Cities In Massachusetts',
          fontSize:25
        },
        legend:{
          display:false,
          position:'top',
          labels:{
            fontColor:'#000'
          }
        },
        layout:{
          padding:{
            left:50,
            right:0,
            bottom:0,
            top:0
          }
        },
        tooltips:{
          enabled:true
        }
      }
    };

    const data3 = {
      type:'polarArea', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
      data:{
        labels:['Boston', 'Worcester', 'Springfield', 'Lowell', 'Cambridge', 'New Bedford'],
        datasets:[{
          label:'Population',
          data:[
            617594,
            181045,
            153060,
            106519,
            105162,
            95072
          ],
          //backgroundColor:'green',
          backgroundColor:[
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
            'rgba(153, 102, 255, 0.6)',
            'rgba(255, 159, 64, 0.6)',
            'rgba(255, 99, 132, 0.6)'
          ],
          borderWidth:1,
          borderColor:'#777',
          hoverBorderWidth:3,
          hoverBorderColor:'#000'
        }]
      },
      options:{
        title:{
          display:false,
          text:'Largest Cities In Massachusetts',
          fontSize:25
        },
        legend:{
          display:false,
          position:'top',
          labels:{
            fontColor:'#000'
          }
        },
        layout:{
          padding:{
            left:50,
            right:0,
            bottom:0,
            top:0
          }
        },
        tooltips:{
          enabled:true
        }
      }
    };

    const natChart = new Chart(document.getElementById('natChart'), data1);
    const comChart = new Chart(document.getElementById('comChart'), data2);
    const visChart = new Chart(document.getElementById('visChart'), data3);

</script>