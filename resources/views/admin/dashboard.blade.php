<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Dashboard') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Dashboard
    </x-slot>

    <main>
        <div class="row gy-4">
            <div class="col-lg-9">
                <!-- Grettings Box Start -->
                <div class="grettings-box position-relative rounded-16 bg-main-600 overflow-hidden gap-16 flex-wrap z-1">
                    <img src="{{ asset('assets/images/bg/grettings-pattern.png') }}" alt="" class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100 opacity-6">
                    <div class="row gy-4">
                        <div class="col-sm-7">
                            <div class="grettings-box__content py-xl-4">
                                <h2 class="text-white mb-0">Hello, Admin! </h2>
                                <p class="text-15 fw-light mt-4 text-white">Selamat datang di Shafta E-Raport</p>
                                <p class="text-lg fw-light mt-24 text-white">Semester 1 &mdash; 2025/2026</p>
                            </div>
                        </div>
                        <!-- <div class="col-sm-5 d-sm-block d-none">
                            <div class="text-center h-100 d-flex justify-content-center align-items-end ">
                                <img src="assets/images/thumbs/e-raport.jpg" alt="">
                            </div>
                        </div> -->
                    </div>
                </div>
                <!-- Grettings Box End -->

                <!-- Top Course Start -->
                <div class="card mt-24">
                    <div class="card-body">
                        <div class="mb-20 flex-between flex-wrap gap-8">
                            <h4 class="mb-0">Rata - Rata Nilai Siswa</h4>
                            <div class="flex-align gap-16 flex-wrap">
                                <div class="flex-align flex-wrap gap-16">
                                    <div class="flex-align flex-wrap gap-8">
                                        <span class="w-8 h-8 rounded-circle bg-main-600"></span>
                                        <span class="text-13 text-gray-600">Nilai Umum</span>
                                    </div>
                                    <div class="flex-align flex-wrap gap-8">
                                        <span class="w-8 h-8 rounded-circle bg-main-two-600"></span>
                                        <span class="text-13 text-gray-600">Nilai Keshaftaan</span>
                                    </div>
                                </div>
                                <select class="form-select form-control text-13 px-8 pe-24 py-8 rounded-8 w-auto">
                                    <option value="1">Yearly</option>
                                    <option value="1">Monthly</option>
                                    <option value="1">Weekly</option>
                                    <option value="1">Today</option>
                                </select>
                            </div>
                        </div>

                        <div id="doubleLineChart" class="tooltip-style y-value-left"></div>

                    </div>
                </div>
                <!-- Top Course End -->

            </div>

            <div class="col-lg-3">

                <!-- Calendar Start -->
                <div class="card">
                    <div class="card-body">
                        <div class="calendar">
                            <div class="calendar__header">
                                <button type="button" class="calendar__arrow left"><i class="ph ph-caret-left"></i></button>
                                <p class="display h6 mb-0">""</p>
                                <button type="button" class="calendar__arrow right"><i class="ph ph-caret-right"></i></button>
                            </div>

                            <div class="calendar__week week">
                                <div class="calendar__week-text">Su</div>
                                <div class="calendar__week-text">Mo</div>
                                <div class="calendar__week-text">Tu</div>
                                <div class="calendar__week-text">We</div>
                                <div class="calendar__week-text">Th</div>
                                <div class="calendar__week-text">Fr</div>
                                <div class="calendar__week-text">Sa</div>
                            </div>
                            <div class="days"></div>
                        </div>
                    </div>
                </div>
                <!-- Calendar End -->


                <!-- Assignment Start -->
                <div class="card mt-24">
                    <div class="card-body">
                        <div class="mb-20 flex-between flex-wrap gap-8">
                            <h4 class="mb-0">Semester</h4>
                            <!-- <a href="assignment.html" class="text-13 fw-medium text-main-600 hover-text-decoration-underline">See All</a> -->
                        </div>
                        <div class="p-xl-4 py-16 px-12 flex-between gap-8 rounded-8 border border-gray-100 hover-border-gray-200 transition-1 mb-16">
                            <div class="flex-align flex-wrap gap-8">
                                <span class="text-main-600 bg-main-50 w-44 h-44 rounded-circle flex-center text-2xl flex-shrink-0"><i class="ph-fill ph-graduation-cap"></i></span>
                                <div>
                                    <h6 class="mb-0">Semester 1</h6>
                                    <span class="text-13 text-gray-400">2023/2024</span>
                                </div>
                            </div>
                            <a href="assignment.html" class="text-gray-900 hover-text-main-600"><i class="ph ph-caret-right"></i></a>
                        </div>
                        <div class="p-xl-4 py-16 px-12 flex-between gap-8 rounded-8 border border-gray-100 hover-border-gray-200 transition-1 mb-16">
                            <div class="flex-align flex-wrap gap-8">
                                <span class="text-main-600 bg-main-50 w-44 h-44 rounded-circle flex-center text-2xl flex-shrink-0"><i class="ph-fill ph-graduation-cap"></i></span>
                                <div>
                                    <h6 class="mb-0">Semester 2</h6>
                                    <span class="text-13 text-gray-400">2023/2024</span>
                                </div>
                            </div>
                            <a href="assignment.html" class="text-gray-900 hover-text-main-600"><i class="ph ph-caret-right"></i></a>
                        </div>
                        <div class="p-xl-4 py-16 px-12 flex-between gap-8 rounded-8 border border-gray-100 hover-border-gray-200 transition-1 mb-16">
                            <div class="flex-align flex-wrap gap-8">
                                <span class="text-main-600 bg-main-50 w-44 h-44 rounded-circle flex-center text-2xl flex-shrink-0"><i class="ph-fill ph-graduation-cap"></i></span>
                                <div>
                                    <h6 class="mb-0">Semester 1</h6>
                                    <span class="text-13 text-gray-400">2024/2025</span>
                                </div>
                            </div>
                            <a href="assignment.html" class="text-gray-900 hover-text-main-600"><i class="ph ph-caret-right"></i></a>
                        </div>
                        <div class="p-xl-4 py-16 px-12 flex-between gap-8 rounded-8 border border-gray-100 hover-border-gray-200 transition-1 mb-16">
                            <div class="flex-align flex-wrap gap-8">
                                <span class="text-main-600 bg-main-50 w-44 h-44 rounded-circle flex-center text-2xl flex-shrink-0"><i class="ph-fill ph-graduation-cap"></i></span>
                                <div>
                                    <h6 class="mb-0">Semester 2</h6>
                                    <span class="text-13 text-gray-400">2024/2025</span>
                                </div>
                            </div>
                            <a href="assignment.html" class="text-gray-900 hover-text-main-600"><i class="ph ph-caret-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Assignment End -->

            </div>

        </div>
    </main>

    <x-slot name="scripts">
        <script>
            function createChart(chartId, chartColor) {

                let currentYear = new Date().getFullYear();

                var options = {
                    series: [{
                        name: 'series1',
                        data: [18, 25, 22, 40, 34, 55, 50, 60, 55, 65],
                    }, ],
                    chart: {
                        type: 'area',
                        width: 80,
                        height: 42,
                        sparkline: {
                            enabled: true // Remove whitespace
                        },

                        toolbar: {
                            show: false
                        },
                        padding: {
                            left: 0,
                            right: 0,
                            top: 0,
                            bottom: 0
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 1,
                        colors: [chartColor],
                        lineCap: 'round'
                    },
                    grid: {
                        show: true,
                        borderColor: 'transparent',
                        strokeDashArray: 0,
                        position: 'back',
                        xaxis: {
                            lines: {
                                show: false
                            }
                        },
                        yaxis: {
                            lines: {
                                show: false
                            }
                        },
                        row: {
                            colors: undefined,
                            opacity: 0.5
                        },
                        column: {
                            colors: undefined,
                            opacity: 0.5
                        },
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0
                        },
                    },
                    fill: {
                        type: 'gradient',
                        colors: [chartColor], // Set the starting color (top color) here
                        gradient: {
                            shade: 'light', // Gradient shading type
                            type: 'vertical', // Gradient direction (vertical)
                            shadeIntensity: 0.5, // Intensity of the gradient shading
                            gradientToColors: [`${chartColor}00`], // Bottom gradient color (with transparency)
                            inverseColors: false, // Do not invert colors
                            opacityFrom: .5, // Starting opacity
                            opacityTo: 0.3, // Ending opacity
                            stops: [0, 100],
                        },
                    },
                    // Customize the circle marker color on hover
                    markers: {
                        colors: [chartColor],
                        strokeWidth: 2,
                        size: 0,
                        hover: {
                            size: 8
                        }
                    },
                    xaxis: {
                        labels: {
                            show: false
                        },
                        categories: [`Jan ${currentYear}`, `Feb ${currentYear}`, `Mar ${currentYear}`, `Apr ${currentYear}`, `May ${currentYear}`, `Jun ${currentYear}`, `Jul ${currentYear}`, `Aug ${currentYear}`, `Sep ${currentYear}`, `Oct ${currentYear}`, `Nov ${currentYear}`, `Dec ${currentYear}`],
                        tooltip: {
                            enabled: false,
                        },
                    },
                    yaxis: {
                        labels: {
                            show: false
                        }
                    },
                    tooltip: {
                        x: {
                            format: 'dd/MM/yy HH:mm'
                        },
                    },
                };

                var chart = new ApexCharts(document.querySelector(`#${chartId}`), options);
                chart.render();
            }

            // Call the function for each chart with the desired ID and color
            // createChart('complete-course', '#2FB2AB');
            // createChart('earned-certificate', '#27CFA7');
            // createChart('course-progress', '#6142FF');
            // createChart('community-support', '#FA902F');


            // =========================== Double Line Chart Start ===============================
            function createLineChart(chartId, chartColor) {
                var options = {
                    series: [{
                            name: 'Study',
                            data: [8, 15, 9, 20, 10, 33, 13, 22, 8, 17, 10, 15],
                        },
                        {
                            name: 'Test',
                            data: [8, 24, 18, 40, 18, 48, 22, 38, 18, 30, 20, 28],
                        },
                    ],
                    chart: {
                        type: 'area',
                        width: '100%',
                        height: 300,
                        sparkline: {
                            enabled: false // Remove whitespace
                        },
                        toolbar: {
                            show: false
                        },
                        padding: {
                            left: 0,
                            right: 0,
                            top: 0,
                            bottom: 0
                        }
                    },
                    colors: ['#3D7FF9', chartColor], // Set the color of the series
                    dataLabels: {
                        enabled: false,
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 1,
                        colors: ["#3D7FF9", chartColor],
                        lineCap: 'round',
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.9, // Decrease this value to reduce opacity
                            opacityTo: 0.2, // Decrease this value to reduce opacity
                            stops: [0, 100]
                        }
                    },
                    grid: {
                        show: true,
                        borderColor: '#E6E6E6',
                        strokeDashArray: 3,
                        position: 'back',
                        xaxis: {
                            lines: {
                                show: false
                            }
                        },
                        yaxis: {
                            lines: {
                                show: true
                            }
                        },
                        row: {
                            colors: undefined,
                            opacity: 0.5
                        },
                        column: {
                            colors: undefined,
                            opacity: 0.5
                        },
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0
                        },
                    },
                    // Customize the circle marker color on hover
                    markers: {
                        colors: ["#3D7FF9", chartColor],
                        strokeWidth: 3,
                        size: 0,
                        hover: {
                            size: 8
                        }
                    },
                    xaxis: {
                        labels: {
                            show: false
                        },
                        categories: [`Jan`, `Feb`, `Mar`, `Apr`, `May`, `Jun`, `Jul`, `Aug`, `Sep`, `Oct`, `Nov`, `Dec`],
                        tooltip: {
                            enabled: false,
                        },
                        labels: {
                            formatter: function(value) {
                                return value;
                            },
                            style: {
                                fontSize: "14px"
                            }
                        },
                    },
                    yaxis: {
                        labels: {
                            formatter: function(value) {
                                return value;
                            },
                            style: {
                                fontSize: "14px"
                            }
                        },
                    },
                    tooltip: {
                        x: {
                            format: 'dd/MM/yy HH:mm'
                        },
                    },
                    legend: {
                        show: false,
                        position: 'top',
                        horizontalAlign: 'right',
                        offsetX: -10,
                        offsetY: -0
                    }
                };

                var chart = new ApexCharts(document.querySelector(`#${chartId}`), options);
                chart.render();
            }
            createLineChart('doubleLineChart', '#27CFA7');
            // =========================== Double Line Chart End ===============================

            // ================================= Multiple Radial Bar Chart Start =============================
            var options = {
                series: [100, 60, 25],
                chart: {
                    height: 172,
                    type: 'radialBar',
                },
                colors: ['#3D7FF9', '#27CFA7', '#020203'],
                stroke: {
                    lineCap: 'round',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '30%', // Adjust this value to control the bar width
                        },
                        dataLabels: {
                            name: {
                                fontSize: '16px',
                            },
                            value: {
                                fontSize: '16px',
                            },
                            total: {
                                show: true,
                                formatter: function(w) {
                                    return '82%'
                                }
                            }
                        }
                    }
                },
                labels: ['Completed', 'In Progress', 'Not Started'],
            };

            // var chart = new ApexCharts(document.querySelector("#radialMultipleBar"), options);
            // chart.render();
            // ================================= Multiple Radial Bar Chart End =============================

            // ========================== Export Js Start ==============================
            // document.getElementById('exportOptions').addEventListener('change', function() {
            //     const format = this.value;
            //     const table = document.getElementById('studentTable');
            //     let data = [];
            //     const headers = [];

            //     // Get the table headers
            //     table.querySelectorAll('thead th').forEach(th => {
            //         headers.push(th.innerText.trim());
            //     });

            //     // Get the table rows
            //     table.querySelectorAll('tbody tr').forEach(tr => {
            //         const row = {};
            //         tr.querySelectorAll('td').forEach((td, index) => {
            //             row[headers[index]] = td.innerText.trim();
            //         });
            //         data.push(row);
            //     });

            //     if (format === 'csv') {
            //         downloadCSV(data);
            //     } else if (format === 'json') {
            //         downloadJSON(data);
            //     }
            // });

            function downloadCSV(data) {
                const csv = data.map(row => Object.values(row).join(',')).join('\n');
                const blob = new Blob([csv], {
                    type: 'text/csv'
                });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'students.csv';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            }

            function downloadJSON(data) {
                const json = JSON.stringify(data, null, 2);
                const blob = new Blob([json], {
                    type: 'application/json'
                });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'students.json';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            }
            // ========================== Export Js End ==============================
        </script>
    </x-slot>

</x-app-layout>
