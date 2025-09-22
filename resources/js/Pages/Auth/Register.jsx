import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        username: '',
        password: '',
        password_confirmation: '',
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('register'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    return (
        <div className="min-h-screen bg-leaflight flex flex-col justify-center items-center">
            <Head title="Registro" />

            {/* Header con logo y título */}
            <div className="mb-8 text-center">
                <img src="/images/escudo.png" className="h-32 w-24 mx-auto mb-4" alt="Escudo" />
                <h1 className="text-2xl font-bold text-leafdarkest mb-2">Sistema de Control de Gastos</h1>
                <p className="text-lg text-leafsecond">Cooperadora Escolar - EET 3107 Juana Azurduy de Padilla</p>
            </div>

            {/* Formulario de registro */}
            <div className="w-full max-w-md">
                <div className="bg-leafdarkest shadow-lg rounded-lg px-8 py-6">
                    <h2 className="text-xl font-semibold text-white text-center mb-6">Crear Cuenta</h2>

                    <form onSubmit={submit}>
                        <div>
                            <label htmlFor="name" className="block text-sm font-medium text-white">
                                Nombre Completo
                            </label>

                            <TextInput
                                id="name"
                                name="name"
                                value={data.name}
                                className="mt-1 block w-full border-leafmedium focus:border-leaflight focus:ring-leaflight"
                                autoComplete="name"
                                isFocused={true}
                                onChange={(e) => setData('name', e.target.value)}
                                required
                            />

                            <InputError message={errors.name} className="mt-2 text-red-300" />
                        </div>

                        <div className="mt-4">
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
                                onChange={(e) => setData('username', e.target.value)}
                                required
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
                                autoComplete="new-password"
                                onChange={(e) => setData('password', e.target.value)}
                                required
                            />

                            <InputError message={errors.password} className="mt-2 text-red-300" />
                        </div>

                        <div className="mt-4">
                            <label htmlFor="password_confirmation" className="block text-sm font-medium text-white">
                                Confirmar Contraseña
                            </label>

                            <TextInput
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                value={data.password_confirmation}
                                className="mt-1 block w-full border-leafmedium focus:border-leaflight focus:ring-leaflight"
                                autoComplete="new-password"
                                onChange={(e) =>
                                    setData('password_confirmation', e.target.value)
                                }
                                required
                            />

                            <InputError
                                message={errors.password_confirmation}
                                className="mt-2 text-red-300"
                            />
                        </div>

                        <div className="mt-6">
                            <button
                                type="submit"
                                disabled={processing}
                                className="w-full bg-leafmedium hover:bg-leaflight text-leafdarkest font-semibold py-2 px-4 rounded transition-colors duration-200 disabled:opacity-50"
                            >
                                {processing ? 'Registrando...' : 'Crear Cuenta'}
                            </button>
                        </div>

                        <div className="mt-4 text-center">
                            <Link
                                href={route('login')}
                                className="text-sm text-leaflight hover:text-white underline"
                            >
                                ¿Ya tienes cuenta? Iniciar sesión
                            </Link>
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
