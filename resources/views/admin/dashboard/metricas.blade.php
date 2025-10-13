<div class="row">
    <!-- Cards para métricas totales -->
    <div class="col-xl-3">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Total Interacciones</h4>
                <div class="text-center">
                    <h2 id="total-interacciones" class="text-primary">0</h2>
                    <p class="text-muted">Clics en el botón del chat</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Total Mensajes Enviados</h4>
                <div class="text-center">
                    <h2 id="total-mensajes" class="text-success">0</h2>
                    <p class="text-muted">Mensajes de usuarios</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Tasa de Éxito</h4>
                <div class="text-center">
                    <h2 id="tasa-exito" class="text-info">0%</h2>
                    <p class="text-muted">Respuestas exitosas / total</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Total Errores</h4>
                <div class="text-center">
                    <h2 id="total-errores" class="text-danger">0</h2>
                    <p class="text-muted">Respuestas fallidas</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Filtro por período -->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Filtros</h4>
                <select id="period-filter" class="form-select">
                    <option value="total">Total</option>
                    <option value="day">Últimos 7 días</option>
                    <option value="week">Últimas 4 semanas</option>
                    <option value="month">Últimos 12 meses</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Gráfico de líneas: Interacciones y mensajes por período -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Interacciones y Mensajes por Período</h4>
                <div id="grafico1"></div>
            </div>
        </div>
    </div>

    <!-- Gráfico de barras: Respuestas exitosas vs. fallidas -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Respuestas Exitosas vs. Fallidas</h4>
                <div id="grafico2"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Gráfico de pie: Modelos utilizados -->
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Distribución de Modelos Utilizados</h4>
                <div id="grafico3"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let chart1, chart2, chart3;

        function loadMetrics(period = 'total') {
            fetch(`chatbot/metrics?period=${period}`)
                .then(response => response.json())
                .then(data => {
                    // Actualizar cards
                    document.getElementById('total-interacciones').textContent = data.totalInteracciones;
                    document.getElementById('total-mensajes').textContent = data.totalMensajes;
                    document.getElementById('tasa-exito').textContent = data.tasaExito + '%';
                    document.getElementById('total-errores').textContent = data.totalFallidas;

                    // Gráfico 1: Líneas (interacciones y mensajes)
                    const options1 = {
                        chart: {
                            type: 'line',
                            height: 350,
                            toolbar: {
                                show: true
                            }
                        },
                        series: [{
                                name: 'Interacciones',
                                data: data.dataInteracciones
                            },
                            {
                                name: 'Mensajes Enviados',
                                data: data.dataMensajes
                            }
                        ],
                        xaxis: {
                            categories: data.labels
                        },
                        yaxis: {
                            title: {
                                text: 'Cantidad'
                            }
                        },
                        colors: ['#00E396', '#FEB019'],
                        stroke: {
                            curve: 'smooth'
                        },
                        fill: {
                            opacity: 0.3
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }]
                    };
                    if (chart1) chart1.destroy();
                    chart1 = new ApexCharts(document.querySelector("#grafico1"), options1);
                    chart1.render();

                    // Gráfico 2: Barras (exitosas vs. fallidas)
                    const options2 = {
                        chart: {
                            type: 'bar',
                            height: 350,
                            toolbar: {
                                show: true
                            }
                        },
                        series: [{
                                name: 'Respuestas Exitosas',
                                data: data.dataExitosas
                            },
                            {
                                name: 'Respuestas Fallidas',
                                data: data.dataFallidas
                            }
                        ],
                        xaxis: {
                            categories: data.labels
                        },
                        yaxis: {
                            title: {
                                text: 'Cantidad'
                            }
                        },
                        colors: ['#00E396', '#FEB019'],
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%'
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }]
                    };
                    if (chart2) chart2.destroy();
                    chart2 = new ApexCharts(document.querySelector("#grafico2"), options2);
                    chart2.render();

                    // Gráfico 3: Pie (modelos usados)
                    const modelLabels = Object.keys(data.modelosUsados);
                    const modelData = Object.values(data.modelosUsados);

                    if (chart3) chart3.destroy();

                    // Si no hay datos o todos son 0, mostrar mensaje
                    if (modelData.length === 0 || modelData.every(val => val <= 0)) {
                        document.getElementById('grafico3').innerHTML =
                            '<div class="text-center p-8"><p class="text-muted">Sin datos de modelos disponibles para este período.</p></div>';
                    } else {
                        const options3 = {
                            chart: {
                                type: 'donut', // Cambié a 'donut' para mejor visualización con pocos slices
                                height: 350
                            },
                            series: modelData,
                            labels: modelLabels,
                            colors: ['#00E396', '#FEB019', '#FF4560', '#775DD0', '#546E7A'],
                            legend: {
                                show: true,
                                position: 'bottom' // Posición inferior para mejor layout
                            },
                            plotOptions: {
                                pie: {
                                    donut: {
                                        size: '70%', // Tamaño del donut para centrar y hacer visible con 2 slices
                                        labels: {
                                            show: true,
                                            total: {
                                                show: true
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
                            }]
                        };
                        chart3 = new ApexCharts(document.querySelector("#grafico3"), options3);
                        chart3.render();
                    }


                })
                .catch(error => console.error('Error cargando métricas:', error));
        }

        // Cargar métricas iniciales
        loadMetrics();

        // Event listener para filtro
        document.getElementById('period-filter').addEventListener('change', function() {
            const period = this.value;
            loadMetrics(period);
        });
    });
</script>
