<div class="row">
    <div class="col-12">
        <div class="page-title-box">            
            <h4 class="page-title">Métricas de Notificaciones</h4>
        </div>
    </div>
</div>

<!-- Métricas principales -->
<div class="row">
    <div class="col-xl-3">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="header-title">Tasa de Apertura</h4>
                <h2 id="tasa-apertura" class="text-primary">0%</h2>
                <p class="text-muted">Notificaciones abiertas / enviadas</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="header-title">No Abiertas</h4>
                <h2 id="no-abiertas" class="text-danger">0%</h2>
                <p class="text-muted">Notificaciones no abiertas</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="header-title">Tiempo Promedio</h4>
                <h2 id="promedio-apertura" class="text-info">0 min</h2>
                <p class="text-muted">Entre envío y apertura</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="header-title">Usuarios Inactivos</h4>
                <h2 id="usuarios-inactivos" class="text-warning">0%</h2>
                <p class="text-muted">Nunca abren notificaciones</p>
            </div>
        </div>
    </div>
</div>

<!-- Filtro por período -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Filtros</h4>
                <select id="period-filter" class="form-select" onchange="loadMetrics()">
                    <option value="total">Total</option>
                    <option value="week">Últimos 7 días</option>
                    <option value="month">Último mes</option>
                    <option value="year">Último año</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos -->
<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Tasa de Apertura en el Tiempo</h4>
                <div id="grafico-apertura-tiempo"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Usuarios Más Activos</h4>
                <div id="grafico-usuarios-activos"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Apertura por Tipo de Ticket</h4>
                <div id="grafico-tipo-ticket"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Distribución por Hora del Día</h4>
                <div id="grafico-horas"></div>
            </div>
        </div>
    </div>
</div>

{{-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> --}}
<script src="{{ url('assets/js/vendor/apexcharts.min.js') }}"></script>
<script>
    async function loadMetrics() {
        const period = document.getElementById('period-filter').value;
        const res = await fetch(`notificaciones/metrics?period=${period}`);
        const data = await res.json();

        // 🔹 Formateador de números
        const format = (num) => Number(num).toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        // 🔹 Actualiza tarjetas
        document.getElementById('tasa-apertura').textContent = format(data.tasa_apertura) + '%';
        document.getElementById('no-abiertas').textContent = format(data.no_abiertas) + '%';
        document.getElementById('promedio-apertura').textContent = format(data.promedio_apertura) + ' min';
        document.getElementById('usuarios-inactivos').textContent = format(data.usuarios_inactivos) + '%';

        // 🔸 Limpia contenedores antes de renderizar (evita duplicar gráficos)
        document.querySelectorAll("#grafico-apertura-tiempo, #grafico-usuarios-activos, #grafico-tipo-ticket, #grafico-horas")
            .forEach(el => el.innerHTML = "");

        // 🎯 1. Gráfico de línea: Tasa de apertura en el tiempo
        new ApexCharts(document.querySelector("#grafico-apertura-tiempo"), {
            chart: {
                type: 'line',
                height: 320,
                toolbar: { show: false },
                zoom: { enabled: false },
                background: 'transparent'
            },
            stroke: { curve: 'smooth', width: 3 },
            markers: { size: 5, colors: ['#fff'], strokeColors: '#00b894', strokeWidth: 2 },
            colors: ['#00b894'],
            series: [{
                name: "Tasa de Apertura (%)",
                data: data.apertura_tiempo.map(x => parseFloat(x.tasa))
            }],
            xaxis: {
                categories: data.apertura_tiempo.map(x => x.fecha),
                labels: { rotate: -45, style: { fontSize: '12px' } }
            },
            yaxis: {
                labels: { formatter: val => val + '%' }
            },
            tooltip: {
                y: { formatter: val => format(val) + '%' }
            }
        }).render();

        // 🎯 2. Gráfico de barras: Usuarios más activos
        new ApexCharts(document.querySelector("#grafico-usuarios-activos"), {
            chart: { type: 'bar', height: 320, toolbar: { show: false } },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    horizontal: true,
                    distributed: true,
                    barHeight: '60%'
                }
            },
            colors: [
                '#6c5ce7', '#00b894', '#0984e3', '#fdcb6e', '#e17055',
                '#74b9ff', '#fab1a0', '#55efc4', '#ffeaa7', '#a29bfe'
            ],
            series: [{ name: "Aperturas", data: data.usuarios_activos.map(x => x.total) }],
            xaxis: {
                categories: data.usuarios_activos.map(x => x.nombre),
                labels: { style: { fontSize: '13px' } }
            },
            tooltip: {
                y: { formatter: val => format(val) + " aperturas" }
            }
        }).render();

        // 🎯 3. Gráfico de barras: Tasa de apertura por tipo de ticket
        new ApexCharts(document.querySelector("#grafico-tipo-ticket"), {
            chart: { type: 'bar', height: 320, toolbar: { show: false } },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '55%',
                    distributed: true
                }
            },
            colors: ['#00cec9', '#6c5ce7', '#fd79a8', '#e17055', '#74b9ff'],
            series: [{ name: "Tasa Apertura (%)", data: data.tasa_por_tipo.map(x => parseFloat(x.tasa)) }],
            xaxis: {
                categories: data.tasa_por_tipo.map(x => x.soporte),
                labels: {
                    rotate: -45,
                    style: { fontSize: '11px' },
                    formatter: val => val.length > 12 ? val.substring(0, 12) + '…' : val
                }
            },
            yaxis: { labels: { formatter: val => val + '%' } },
            tooltip: { y: { formatter: val => format(val) + '%' } }
        }).render();

        // 🎯 4. Heatmap: Distribución de notificaciones por hora
        new ApexCharts(document.querySelector("#grafico-horas"), {
            chart: { type: 'heatmap', height: 300 },
            series: [{
                name: 'Aperturas',
                data: data.distribucion_horas.map(x => ({ x: x.hora, y: x.total }))
            }]
        }).render();
    }

    document.addEventListener("DOMContentLoaded", loadMetrics);
</script>

