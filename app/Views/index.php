<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">
          Dashboard
        </h2>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">

        </div>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="row row-cards">
      <div class="col-12">
        <h3>Asset Details</h3>
        <div id="Assetchart"></div>

      </div>
    </div>
    <br> <br>
    <div class="row row-cards">
      <div class="col-12">


      <div class="d-flex " style="justify-content: right;">
        <select id="year_vendor" onchange="yearchangeVendor()" >
          <option value="">Select</option>
          <option value="2023">2023</option>
          <option value="2024">2024</option>
          <option value="2025">2025</option>
        </select>
        </div>
        <div  id="VendorListChart" ></div>

      </div>
    </div>
<br> <br>

    <div class="row row-cards">
      <div class="col-6" >
        <div class="d-flex " style="justify-content: right;">
        <select id="year" onchange="yearchange()" >
          <option value="">Select</option>
          <option value="2023">2023</option>
          <option value="2024">2024</option>
          <option value="2025">2025</option>
        </select>
        </div>
        <div  id="Vendorchart" ></div>

      </div>

      <div class="col-6" >



      <h3>License Details</h3>
        <div id="Licensechart"></div>

      </div>

    </div>

  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
  //asset chart
  var options = {
    series: [{
      name: 'SPARE ASSET',
      data: [<?php echo $spareAsset ?>]
    }, {
      name: 'ASSIGNED ASSET',
      data: [<?php echo $assignAsset ?>]
    }, ],
    chart: {
      type: 'bar',
      height: 400,
      stacked: true,
      toolbar: {
        show: true
      },
      zoom: {
        enabled: true
      }
    },
    responsive: [{
      breakpoint: 480,
      options: {
        legend: {
          position: 'bottom',
          offsetX: -10,
          offsetY: 0
        }
      }
    }],
    plotOptions: {
      bar: {
        horizontal: false,
        borderRadius: 10,
        dataLabels: {
          total: {
            enabled: true,
            style: {
              fontSize: '13px',
              fontWeight: 900
            }
          }
        }
      },
    },
    xaxis: {
      type: 'category',
      categories: [<?php echo $category ?>],
      tickPlacement: 'on',
      labels: {
        rotate: -45,

      }, title: {
          text: 'Assets'
        },

    },
    yaxis: {
        title: {
          text: 'Count'
        },
      },
    legend: {
      position: 'top',
      offsetY: 10
    },
    fill: {
      opacity: 1
    }
  };

  var chart = new ApexCharts(document.querySelector("#Assetchart"), options);
  chart.render();


  //license chart



  var options1 = {
    series: [{
      name: 'Active License',
      data: [<?php echo $LicenseActiveCount ?>]
    }, {
      name: 'Expire License',
      data: [<?php echo $LicenseExpiryCount ?>]
    }, ],
    chart: {
      type: 'bar',
      height: 400,
      stacked: true,
      toolbar: {
        show: true
      },
      zoom: {
        enabled: true
      }
    },
    colors: ['#2fb344', '#D63939'],
    responsive: [{
      breakpoint: 480,
      options: {
        legend: {
          position: 'bottom',
          offsetX: -10,
          offsetY: 0
        }
      }
    }],
    plotOptions: {
      bar: {
        horizontal: false,
        borderRadius: 10,
        dataLabels: {
          total: {
            enabled: true,
            style: {
              fontSize: '13px',
              fontWeight: 900
            }
          }
        }
      },
    },
    xaxis: {
      type: 'category',
      categories: <?php echo $LicenseNames ?>,
      title: {
          text: 'Licenses'
        }
    }, yaxis: {
        title: {
          text: 'Count'
        },
      },
    legend: {
      position: 'top',
      offsetY: 10
    },
    fill: {
      opacity: 1
    }

  };

  var chart = new ApexCharts(document.querySelector("#Licensechart"), options1);
  chart.render();

  //
  let year = new Date().getFullYear();
  var data_vendor = <?php echo json_encode($vendor_invoice) ?>;

  const currentYearData = data_vendor['2024'];
    var resultArray = currentYearData.split(',').map(Number);

  // var jsonString = data_vendor['2024'];
  // var resultString = jsonString.replace(/'/g, '');
  // var resultArray = jsonString.split(',').map(Number);


    var options = {
      series: [{
          name: "Vendor Invoices - " + year,
          data: resultArray,
        },

      ],
      chart: {
        height:400,
        type: 'line',
        dropShadow: {
          enabled: true,
          color: '#000',
          top: 18,
          left: 7,
          blur: 10,
          opacity: 0.2
        },
        toolbar: {
          show: false
        }
      },
      colors: ['#77B6EA', '#545454'],
      dataLabels: {
        enabled: true,
      },
      stroke: {
        curve: 'smooth'
      },
      title: {
        text: "Total Vendor Invoices - " + year,
        align: 'left'
      },
      grid: {
        borderColor: '#e7e7e7',
        row: {
          colors: ['#f3f3f3', 'transparent'],
          opacity: 0.5
        },
      },
      markers: {
        size: 1
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        title: {
          text: 'Month'
        }
      },
      yaxis: {
        title: {
          text: 'Price'
        },

        forceNiceScale: Boolean,

      },
      legend: {
        position: 'top',
        horizontalAlign: 'right',
        floating: true,
        offsetY: -25,
        offsetX: -5
      }
    };

    var chart1 = new ApexCharts(document.querySelector("#Vendorchart"), options);
    chart1.render();

  function yearchange() {
  //   year = document.getElementById('year').value;
  //  chart1.updateSeries([{
  //   data: [yeardata()]
  // }])


  year = document.getElementById('year').value;

      const currentYearData = data_vendor[year];
      var resultArray1 = currentYearData.split(',').map(Number);

      chart1.updateOptions({
        title: {
          text: "Total Vendor Invoices - " + year,
        },
      });

      chart1.updateSeries([{
        data: resultArray1,
      }]);

  }

  // function yeardata() {
  //   const currentYearData = data_vendor[year];
  //   var resultArray1 = currentYearData.split(',').map(Number);
  //   console.log(resultArray1);
  //   return resultArray1;

  // }

  //vendor list chart
  let year_vendor = new Date().getFullYear();
  var vendor_list = <?php echo $vendor_details ?>;
  var vendor_names = <?php echo $vendor_names ?>;
  var currentYearVendorData = vendor_list[year_vendor];
  var result_vendors = currentYearVendorData.map(Number);
  var options = {
          series: [{
          name: 'Vendor List',
          data: result_vendors
        }],
          chart: {
          type: 'bar',
          height: 350,
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        title: {
        text: "Vendor Invoices -  " + year_vendor,
        align: 'left'
      },
        xaxis: {
          categories: vendor_names,
          title: {
          text: 'Vendors'
        },
        labels: {
            formatter:(value)=>{
              var len = value.length
              return len > 20 ? (value.substring(0,18) +".."): value
            }
          }
        },
        yaxis: {
          title: {
            text: 'price'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val
            }
          }
        }
        };

        var chart_vendor = new ApexCharts(document.querySelector("#VendorListChart"), options);
        chart_vendor.render();

        function yearchangeVendor() {
          year_vendor = document.getElementById('year_vendor').value;
      var currentYearDataVendor = vendor_list[year_vendor];

      var resultArray_vendor = currentYearDataVendor.map(Number);

      chart_vendor.updateOptions({
        title: {
          text: "Vendor Invoices - " + year_vendor,
        },
      });


      chart_vendor.updateSeries([{
        data: resultArray_vendor,
      }]);
  }

</script>

<script type="text/javascript">
  sessionStorage.setItem("nav-active", '');
</script>