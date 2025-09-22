import Layout from '@/Layouts/Layout';
import { Head, Link } from '@inertiajs/react';

export default function Dashboard() {
    const menuItems = [
        { name: 'Ingresos', route: 'ingresos.index', icon: '💰', description: 'Gestionar ingresos de la cooperadora' },
        { name: 'Egresos', route: 'egresos.index', icon: '💸', description: 'Gestionar gastos y egresos' },
        { name: 'Alumnos', route: 'alumnos.index', icon: '👥', description: 'Administrar datos de alumnos' },
        { name: 'Conceptos', route: 'conceptos.index', icon: '📋', description: 'Gestionar conceptos de pago' },
        { name: 'Informes', route: 'informes.index', icon: '📊', description: 'Ver reportes y estadísticas' },
    ];

    return (
        <Layout>
            <Head title="Dashboard" />

            <div className="w-full max-w-6xl">
                <h2 className="text-2xl font-bold text-leafdarkest mb-6 text-center">Panel Principal</h2>
                <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    {menuItems.map((item) => (
                        <Link
                            key={item.route}
                            href={route(item.route)}
                            className="group block overflow-hidden rounded-lg bg-white p-6 shadow-md border border-leafmedium hover:shadow-lg hover:border-leafdarkest transition-all duration-200"
                        >
                            <div className="flex items-center">
                                <div className="text-3xl mr-4">{item.icon}</div>
                                <div className="flex-1">
                                    <h3 className="text-lg font-semibold text-leafdarkest group-hover:text-leafsecond">
                                        {item.name}
                                    </h3>
                                    <p className="mt-1 text-sm text-gray-700">
                                        {item.description}
                                    </p>
                                </div>
                            </div>
                        </Link>
                    ))}
                </div>
            </div>
        </Layout>
    );
}
