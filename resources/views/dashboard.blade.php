@extends('layouts.app')

@section('title', 'Dashboard de Eficiência - Planta A')

@section('content')
    <div class="container-xl py-4">

        <div class="d-flex align-items-baseline gap-2 mb-3">
            <h2 class="mb-0">Dashboard de Eficiência</h2>
            <span class="text-muted fs-6" id="period"></span>
        </div>

        <div class="row g-3 mb-3" style="min-height: 320px">
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <label class="fw-semibold mb-2" for="line">Linha de produção</label>
                        <select id="line" class="form-select">
                            <option value="">Todas as linhas</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <canvas id="chart" style="max-height:240px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div id="loading" class="text-center py-5 d-none">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2 text-muted">Carregando dados...</p>
        </div>

        <div class="card border-0 shadow-sm" id="table-wrap">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0" id="table">
                        <thead class="table-dark">
                        <tr>
                            <th style="width:40%">Linha</th>
                            <th style="width:20%">Produzido</th>
                            <th style="width:20%">Defeitos</th>
                            <th style="width:20%">Eficiência</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const selectLine  = document.getElementById('line');
            const tbody       = document.querySelector('#table tbody');
            const loading     = document.getElementById('loading');
            const tableWrap   = document.getElementById('table-wrap');
            const period      = document.getElementById('period');

            let chart = null;
            let linesLoaded = false;

            const now = new Date();
            const month = now.toLocaleString('pt-BR', { month: 'long' });
            period.textContent = `(${month[0].toUpperCase() + month.slice(1)}/${now.getFullYear()})`;

            const fmt = n => new Intl.NumberFormat('pt-BR').format(n);

            function toggleLoading(active) {
                loading.classList.toggle('d-none', !active);
                tableWrap.classList.toggle('d-none', active);
                selectLine.disabled = active;
            }

            function fillSelect(lines, selected) {
                if (linesLoaded) return;
                linesLoaded = true;

                lines.forEach(l => {
                    const opt = new Option(l.name, l.id, false, l.id == selected);
                    selectLine.add(opt);
                });
            }

            function renderTable(data) {
                if (!data?.length) {
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-4">Nenhum registro encontrado.</td></tr>';
                    return;
                }

                tbody.innerHTML = data.map(row => {
                    const ok = row.efficiency >= 95;
                    return `
                <tr>
                    <td><strong>${row.product_name}</strong></td>
                    <td>${fmt(row.total_produced)}</td>
                    <td>${fmt(row.total_defects)}</td>
                    <td class="fw-bold ${ok ? 'text-success' : 'text-danger'}"
                        title="Valor exato: ${row.efficiency.toFixed(3)}%"
                        style="cursor: help;">
                        ${row.efficiency.toFixed(2)}%
                    </td>
                </tr>`;
                }).join('');
            }

            function renderChart(data) {
                chart?.destroy();

                const colors = data.map(r => r.efficiency >= 95
                    ? { bg: 'rgba(25,135,84,.7)',  border: 'rgb(25,135,84)' }
                    : { bg: 'rgba(220,53,69,.7)', border: 'rgb(220,53,69)' }
                );

                chart = new Chart(document.getElementById('chart'), {
                    type: 'bar',
                    data: {
                        labels: data.map(r => r.product_name),
                        datasets: [{
                            data: data.map(r => r.efficiency),
                            backgroundColor: colors.map(c => c.bg),
                            borderColor: colors.map(c => c.border),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let value = context.parsed.y;
                                        return ` Eficiência: ${value.toFixed(2)}%`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                min: 0,
                                max: 100,
                                ticks: { callback: v => v + '%' }
                            }
                        }
                    }
                });
            }

            async function load(lineId = '') {
                toggleLoading(true);

                try {
                    const res  = await fetch(`/api/dashboard?linha_id=${lineId}`);
                    const json = await res.json();

                    fillSelect(json.availableLines, lineId);
                    renderTable(json.metrics);
                    renderChart(json.metrics);

                } catch (err) {
                    console.error(err);
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center text-danger py-4">Falha ao buscar os dados.</td></tr>';
                    chart?.destroy();
                }

                toggleLoading(false);
            }

            selectLine.addEventListener('change', e => load(e.target.value));

            load();
        });
    </script>
@endsection
