import { useState, useEffect } from 'react';
import Layout from "@/Layouts/Layout";
import axios from 'axios';

export default function Informes({ fecha_inicio_default, fecha_fin_default }) {
    const [fechaInicio, setFechaInicio] = useState(fecha_inicio_default);
    const [fechaFin, setFechaFin] = useState(fecha_fin_default);
    const [activeTab, setActiveTab] = useState('dashboard');
    const [loading, setLoading] = useState(false);

    // Estados para los datos
    const [ingresosPorConcepto, setIngresosPorConcepto] = useState([]);
    const [egresosPorCategoria, setEgresosPorCategoria] = useState([]);
    const [saldoGeneral, setSaldoGeneral] = useState(null);
    const [ingresosDetallados, setIngresosDetallados] = useState([]);
    const [egresosDetallados, setEgresosDetallados] = useState([]);

    const fetchData = async () => {
        setLoading(true);
        try {
            const params = {
                fecha_inicio: fechaInicio,
                fecha_fin: fechaFin
            };

            const [
                ingresos,
                egresos,
                saldo,
                ingresosDetalle,
                egresosDetalle
            ] = await Promise.all([
                axios.get('/api/informes/ingresos-por-concepto', { params }),
                axios.get('/api/informes/egresos-por-categoria', { params }),
                axios.get('/api/informes/saldo-general', { params }),
                axios.get('/api/informes/ingresos-detallados', { params }),
                axios.get('/api/informes/egresos-detallados', { params })
            ]);

            setIngresosPorConcepto(ingresos.data);
            setEgresosPorCategoria(egresos.data);
            setSaldoGeneral(saldo.data);
            setIngresosDetallados(ingresosDetalle.data);
            setEgresosDetallados(egresosDetalle.data);
        } catch (error) {
            console.error('Error fetching data:', error);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchData();
    }, [fechaInicio, fechaFin]);

    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('es-AR', {
            style: 'currency',
            currency: 'ARS'
        }).format(amount);
    };

    const formatDate = (date) => {
        return new Date(date).toLocaleDateString('es-AR');
    };

    const getMaxValue = (data, key) => {
        return Math.max(...data.map(item => parseFloat(item[key])));
    };

    const BarChart = ({ data, dataKey, label, color }) => {
        if (!data.length) return <p className="text-gray-500">No hay datos disponibles</p>;

        const maxValue = getMaxValue(data, dataKey);

        return (
            <div className="space-y-3">
                <h3 className="text-lg font-semibold text-leafdarkest mb-4">{label}</h3>
                {data.map((item, index) => (
                    <div key={index} className="flex items-center space-x-3">
                        <div className="w-32 text-sm text-leafdarkest font-medium truncate">
                            {item.concepto_nombre || item.categoria_display}
                        </div>
                        <div className="flex-1 bg-gray-200 rounded-full h-6 relative">
                            <div
                                className={`${color} h-6 rounded-full transition-all duration-500`}
                                style={{
                                    width: `${(parseFloat(item[dataKey]) / maxValue) * 100}%`
                                }}
                            ></div>
                            <span className="absolute inset-0 flex items-center justify-center text-xs font-medium text-leafdarkest">
                                {formatCurrency(item[dataKey])}
                            </span>
                        </div>
                    </div>
                ))}
            </div>
        );
    };

    const KPICard = ({ title, value, color, icon }) => (
        <div className={`${color} rounded-lg p-6 text-white`}>
            <div className="flex items-center justify-between">
                <div>
                    <p className="text-sm opacity-80">{title}</p>
                    <p className="text-2xl font-bold">{value}</p>
                </div>
                <div className="text-3xl opacity-80">{icon}</div>
            </div>
        </div>
    );

    const TabButton = ({ id, label, active, onClick }) => (
        <button
            onClick={() => onClick(id)}
            className={`px-4 py-2 rounded-lg font-medium transition-colors ${
                active
                    ? 'bg-leafmedium text-white'
                    : 'bg-leafdarkest text-white hover:bg-leafsecond'
            }`}
        >
            {label}
        </button>
    );

    return (
        <Layout>
            <div className="w-full max-w-7xl mx-auto">
                {/* Header con filtros de fecha */}
                <div className="bg-leafdarkest rounded-lg shadow-md p-6 mb-6">
                    <h1 className="text-2xl font-bold text-white mb-4">Informes y Dashboard</h1>
                    <div className="flex space-x-4 items-end">
                        <div>
                            <label className="block text-sm font-medium text-white mb-1">
                                Fecha Inicio
                            </label>
                            <input
                                type="date"
                                value={fechaInicio}
                                onChange={(e) => setFechaInicio(e.target.value)}
                                className="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-leafmedium"
                            />
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-white mb-1">
                                Fecha Fin
                            </label>
                            <input
                                type="date"
                                value={fechaFin}
                                onChange={(e) => setFechaFin(e.target.value)}
                                className="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-leafmedium"
                            />
                        </div>
                        {loading && (
                            <div className="text-white">
                                <span className="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span>
                                Cargando...
                            </div>
                        )}
                    </div>
                </div>

                {/* Tabs */}
                <div className="mb-6">
                    <div className="flex space-x-1 bg-leafdarkest p-1 rounded-lg">
                        <TabButton
                            id="dashboard"
                            label="Dashboard"
                            active={activeTab === 'dashboard'}
                            onClick={setActiveTab}
                        />
                        <TabButton
                            id="ingresos"
                            label="Ingresos Detallados"
                            active={activeTab === 'ingresos'}
                            onClick={setActiveTab}
                        />
                        <TabButton
                            id="egresos"
                            label="Egresos Detallados"
                            active={activeTab === 'egresos'}
                            onClick={setActiveTab}
                        />
                        <TabButton
                            id="exportar"
                            label="Exportar"
                            active={activeTab === 'exportar'}
                            onClick={setActiveTab}
                        />
                    </div>
                </div>

                {/* Contenido por tabs */}
                {activeTab === 'dashboard' && (
                    <>
                        {/* KPI Cards */}
                        {saldoGeneral && (
                            <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                                <KPICard
                                    title="Total Ingresos"
                                    value={formatCurrency(saldoGeneral.total_ingresos)}
                                    color="bg-leafmedium"
                                    icon="💰"
                                />
                                <KPICard
                                    title="Total Egresos"
                                    value={formatCurrency(saldoGeneral.total_egresos)}
                                    color="bg-leafsecond"
                                    icon="💸"
                                />
                                <KPICard
                                    title="Saldo"
                                    value={formatCurrency(saldoGeneral.saldo)}
                                    color={saldoGeneral.saldo >= 0 ? "bg-green-600" : "bg-red-600"}
                                    icon={saldoGeneral.saldo >= 0 ? "✅" : "⚠️"}
                                />
                            </div>
                        )}

                        {/* Gráficos */}
                        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div className="bg-white rounded-lg shadow-md p-6">
                                <BarChart
                                    data={ingresosPorConcepto}
                                    dataKey="total_importe"
                                    label="Ingresos por Concepto"
                                    color="bg-leafmedium"
                                />
                            </div>
                            <div className="bg-white rounded-lg shadow-md p-6">
                                <BarChart
                                    data={egresosPorCategoria}
                                    dataKey="total_importe"
                                    label="Egresos por Categoría"
                                    color="bg-leafsecond"
                                />
                            </div>
                        </div>
                    </>
                )}

                {activeTab === 'ingresos' && (
                    <div className="bg-white rounded-lg shadow-md overflow-hidden">
                        <div className="p-6">
                            <h2 className="text-xl font-bold text-leafdarkest mb-4">Ingresos Detallados</h2>
                            <div className="overflow-x-auto">
                                <table className="min-w-full divide-y divide-gray-200">
                                    <thead className="bg-leaflight">
                                        <tr>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-leafdarkest uppercase tracking-wider">ID</th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-leafdarkest uppercase tracking-wider">Fecha</th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-leafdarkest uppercase tracking-wider">Alumno</th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-leafdarkest uppercase tracking-wider">Importe</th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-leafdarkest uppercase tracking-wider">Observaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody className="bg-white divide-y divide-gray-200">
                                        {ingresosDetallados.map((ingreso) => (
                                            <tr key={ingreso.id} className="hover:bg-leaflighest">
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{ingreso.id}</td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{formatDate(ingreso.fecha)}</td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{ingreso.alumno_nombre}</td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">{formatCurrency(ingreso.importe_total)}</td>
                                                <td className="px-6 py-4 text-sm text-gray-500">{ingreso.observaciones || '-'}</td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                )}

                {activeTab === 'egresos' && (
                    <div className="bg-white rounded-lg shadow-md overflow-hidden">
                        <div className="p-6">
                            <h2 className="text-xl font-bold text-leafdarkest mb-4">Egresos Detallados</h2>
                            <div className="overflow-x-auto">
                                <table className="min-w-full divide-y divide-gray-200">
                                    <thead className="bg-leaflight">
                                        <tr>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-leafdarkest uppercase tracking-wider">ID</th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-leafdarkest uppercase tracking-wider">Fecha</th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-leafdarkest uppercase tracking-wider">Concepto</th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-leafdarkest uppercase tracking-wider">Categoría</th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-leafdarkest uppercase tracking-wider">Importe</th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-leafdarkest uppercase tracking-wider">Empresa</th>
                                        </tr>
                                    </thead>
                                    <tbody className="bg-white divide-y divide-gray-200">
                                        {egresosDetallados.map((egreso) => (
                                            <tr key={egreso.id} className="hover:bg-leaflighest">
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{egreso.id}</td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{formatDate(egreso.fecha)}</td>
                                                <td className="px-6 py-4 text-sm text-gray-900">{egreso.concepto}</td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{egreso.categoria_nombre}</td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600">{formatCurrency(egreso.importe)}</td>
                                                <td className="px-6 py-4 text-sm text-gray-500">{egreso.empresa || '-'}</td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                )}

                {activeTab === 'exportar' && (
                    <div className="bg-white rounded-lg shadow-md p-6">
                        <h2 className="text-xl font-bold text-leafdarkest mb-6">Exportar Datos</h2>

                        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                            {/* Exportar Ingresos */}
                            <div className="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                                <div className="text-center">
                                    <div className="text-4xl mb-4">📊</div>
                                    <h3 className="text-lg font-semibold text-leafdarkest mb-2">Ingresos Detallados</h3>
                                    <p className="text-sm text-gray-600 mb-4">
                                        Exporta todos los ingresos del período con detalles de alumnos y conceptos
                                    </p>
                                    <a
                                        href={`/informes/exportar-ingresos?fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}`}
                                        className="bg-leafmedium hover:bg-leafsecond text-white px-4 py-2 rounded-md transition-colors inline-block"
                                        download
                                    >
                                        Descargar CSV
                                    </a>
                                </div>
                            </div>

                            {/* Exportar Egresos */}
                            <div className="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                                <div className="text-center">
                                    <div className="text-4xl mb-4">💸</div>
                                    <h3 className="text-lg font-semibold text-leafdarkest mb-2">Egresos Detallados</h3>
                                    <p className="text-sm text-gray-600 mb-4">
                                        Exporta todos los egresos del período con categorías y detalles completos
                                    </p>
                                    <a
                                        href={`/informes/exportar-egresos?fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}`}
                                        className="bg-leafmedium hover:bg-leafsecond text-white px-4 py-2 rounded-md transition-colors inline-block"
                                        download
                                    >
                                        Descargar CSV
                                    </a>
                                </div>
                            </div>

                            {/* Exportar Resumen */}
                            <div className="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                                <div className="text-center">
                                    <div className="text-4xl mb-4">📋</div>
                                    <h3 className="text-lg font-semibold text-leafdarkest mb-2">Resumen Ejecutivo</h3>
                                    <p className="text-sm text-gray-600 mb-4">
                                        Resumen consolidado con saldos, ingresos por concepto y egresos por categoría
                                    </p>
                                    <a
                                        href={`/informes/exportar-resumen?fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}`}
                                        className="bg-leafmedium hover:bg-leafsecond text-white px-4 py-2 rounded-md transition-colors inline-block"
                                        download
                                    >
                                        Descargar CSV
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div className="mt-8 p-4 bg-leaflighest rounded-lg">
                            <h4 className="font-semibold text-leafdarkest mb-2">Información sobre las exportaciones:</h4>
                            <ul className="text-sm text-gray-700 space-y-1">
                                <li>• Los archivos se descargan en formato CSV, compatibles con Excel</li>
                                <li>• Las fechas se formatean como DD/MM/YYYY</li>
                                <li>• Los importes usan formato argentino (comas para decimales, puntos para miles)</li>
                                <li>• El separador de columnas es punto y coma (;) para compatibilidad con Excel en español</li>
                                <li>• Los archivos incluyen codificación UTF-8 para caracteres especiales</li>
                            </ul>
                        </div>
                    </div>
                )}
            </div>
        </Layout>
    );
}