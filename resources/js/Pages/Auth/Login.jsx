import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        username: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <div className="min-h-screen bg-leaflight flex flex-col justify-center items-center">
            <Head title="Iniciar Sesión" />

            {/* Header con logo y título */}
            <div className="mb-8 text-center">
                <img src="/images/escudo.png" className="h-32 w-24 mx-auto mb-4" alt="Escudo" />
                <h1 className="text-2xl font-bold text-leafdarkest mb-2">Sistema de Control de Gastos</h1>
                <p className="text-lg text-leafsecond">Cooperadora Escolar - EET 3107 Juana Azurduy de Padilla</p>
            </div>

            {/* Formulario de login */}
            <div className="w-full max-w-md">
                <div className="bg-leafdarkest shadow-lg rounded-lg px-8 py-6">
                    <h2 className="text-xl font-semibold text-white text-center mb-6">Iniciar Sesión</h2>

                    {status && (
                        <div className="mb-4 text-sm font-medium text-leaflight bg-leafsecond p-3 rounded">
                            {status}
                        </div>
                    )}

                    <form onSubmit={submit}>
                        <div>
                            <label htmlFor="username" className="block text-sm font-medium text-white">
                                Usuario
                            </label>

                            <TextInput
                                id="username"
                                type="text"
                                name="username"
                                value={data.username}
                                className="mt-1 block w-full border-leafmedium focus:border-leaflight focus:ring-leaflight"
                                autoComplete="username"
                                isFocused={true}
                                onChange={(e) => setData('username', e.target.value)}
                            />

                            <InputError message={errors.username} className="mt-2 text-red-300" />
                        </div>

                        <div className="mt-4">
                            <label htmlFor="password" className="block text-sm font-medium text-white">
                                Contraseña
                            </label>

                            <TextInput
                                id="password"
                                type="password"
                                name="password"
                                value={data.password}
                                className="mt-1 block w-full border-leafmedium focus:border-leaflight focus:ring-leaflight"
                                autoComplete="current-password"
                                onChange={(e) => setData('password', e.target.value)}
                            />

                            <InputError message={errors.password} className="mt-2 text-red-300" />
                        </div>

                        <div className="mt-4 block">
                            <label className="flex items-center">
                                <Checkbox
                                    name="remember"
                                    checked={data.remember}
                                    onChange={(e) =>
                                        setData('remember', e.target.checked)
                                    }
                                />
                                <span className="ms-2 text-sm text-white">
                                    Recordarme
                                </span>
                            </label>
                        </div>

                        <div className="mt-6">
                            <button
                                type="submit"
                                disabled={processing}
                                className="w-full bg-leafmedium hover:bg-leaflight text-leafdarkest font-semibold py-2 px-4 rounded transition-colors duration-200 disabled:opacity-50"
                            >
                                {processing ? 'Iniciando...' : 'Iniciar Sesión'}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {/* Footer */}
            <div className="mt-8 text-center text-leafsecond text-sm">
                <p>© 2025 EET 3107 Juana Azurduy de Padilla</p>
            </div>
        </div>
    );
}
