import  { useState, useEffect } from 'react';
import { useForm, router } from '@inertiajs/react';
import Alert from '@/Components/Alert';
import ConceptoBlock from './ConceptoBlock';

// Función para obtener la hora actual en formato H:i
const getCurrentTime = () => {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    return `${hours}:${minutes}`;
};

const IngresoForm = ({ ingreso = null, conceptos = [], emailSesion = null }) => {
    const [conceptoBlocks, setConceptoBlocks] = useState([{
        id: Date.now(),
        concepto_id: '',
        cantidad: '',
        total_concepto: '0.00'
    }]);
    
    const [alumnoEncontrado, setAlumnoEncontrado] = useState('');
    const [alert, setAlert] = useState({ show: false, type: '', message: '' });
    
    const { data, setData, post, put, processing, errors, reset } = useForm({
        fecha: new Date().toISOString().split('T')[0],
        hora: '',
        dni: '',
        alumno_id: '',
        alumno: '',
        email: '',
        conceptos: [], // Asegurarse de que conceptos esté inicializado como array vacío
        importe_total: '0.00'
    });

    // useEffect para inicializar la hora cuando el componente se monta
    useEffect(() => {
        if (!ingreso) {
            setData(prev => ({
                ...prev,
                hora: getCurrentTime()
            }));
        }
    }, []);

    useEffect(() => {
        if (ingreso) {
            // Preparar los conceptos iniciales si existen
            let initialConceptos = [];
            
            if (ingreso.conceptos && ingreso.conceptos.length > 0) {
                // Mapear los conceptos existentes al formato esperado por el backend
                initialConceptos = ingreso.conceptos.map(concepto => ({
                    id: concepto.id,
                    cantidad: concepto.pivot.cantidad,
                    total_concepto: parseFloat(concepto.pivot.total_concepto)
                }));
                
                // Configurar los bloques de conceptos para la UI
                setConceptoBlocks(ingreso.conceptos.map((concepto, index) => ({
                    id: Date.now() + index,
                    concepto_id: concepto.id,
                    cantidad: concepto.pivot.cantidad,
                    total_concepto: concepto.pivot.total_concepto
                })));
            }
            
            // Actualizar el estado del formulario con los datos del ingreso
            // Si hora es dateTime, extraer solo HH:MM
            let horaFormatted = getCurrentTime();
            if (ingreso.hora) {
                if (ingreso.hora.includes(' ')) {
                    // Formato datetime: "2024-01-15 14:30:00" -> "14:30"
                    horaFormatted = ingreso.hora.split(' ')[1].substring(0, 5);
                } else {
                    // Formato time: "14:30:00" -> "14:30"
                    horaFormatted = ingreso.hora.substring(0, 5);
                }
            }

            setData({
                fecha: ingreso.fecha || new Date().toISOString().split('T')[0],
                hora: horaFormatted,
                dni: ingreso.alumno?.dni || '',
                alumno_id: ingreso.alumno_id || '',
                alumno: ingreso.alumno?.nombre || '',
                email: emailSesion || ingreso.alumno?.email || '',
                conceptos: initialConceptos, // Inicializar conceptos con los datos existentes
                importe_total: ingreso.importe_total || '0.00'
            });
            
            if (ingreso.alumno) {
                setAlumnoEncontrado(`${ingreso.alumno.nombre} ${ingreso.alumno.apellido}`);
            }
        }
    }, [ingreso, emailSesion]);

    const buscarAlumno = async () => {
        if (!data.dni) return;
        
        try {
            const response = await fetch(`/ingresos/buscar-alumno/${data.dni}`);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const alumno = await response.json();
            
            if (alumno && alumno.id && alumno.nombre && alumno.apellido) {
                setData(prev => ({
                    ...prev,
                    alumno_id: alumno.id,
                    alumno: `${alumno.nombre} ${alumno.apellido}`,
                    email: alumno.email || ''
                }));
                setAlumnoEncontrado(`${alumno.nombre} ${alumno.apellido}`);
                setAlert({
                    show: true,
                    type: 'success',
                    message: `Alumno encontrado: ${alumno.nombre} ${alumno.apellido}`
                });
            } else {
                setAlert({
                    show: true,
                    type: 'error',
                    message: 'Alumno no encontrado'
                });
                setData(prev => ({
                    ...prev,
                    alumno_id: '',
                    alumno: '',
                    email: ''
                }));
                setAlumnoEncontrado('');
            }
        } catch (error) {
            console.error('Error buscando alumno:', error);
            setAlert({
                show: true,
                type: 'error',
                message: 'Error al buscar alumno'
            });
            setData(prev => ({
                ...prev,
                alumno_id: '',
                alumno: '',
                email: ''
            }));
            setAlumnoEncontrado('');
        }
    };

    const agregarConcepto = () => {
        setConceptoBlocks(prev => [...prev, {
            id: Date.now(),
            concepto_id: '',
            cantidad: '',
            total_concepto: '0.00'
        }]);
    };

    const quitarConcepto = (id) => {
        if (conceptoBlocks.length > 1) {
            setConceptoBlocks(prev => prev.filter(block => block.id !== id));
        }
    };

    const actualizarConcepto = (id, field, value) => {
        setConceptoBlocks(prev => prev.map(block => {
            if (block.id === id) {
                const updatedBlock = { ...block, [field]: value };
                
                // Calcular total si cambia concepto_id o cantidad
                if (field === 'concepto_id' || field === 'cantidad') {
                    const concepto = conceptos.find(c => c.id == updatedBlock.concepto_id);
                    if (concepto && updatedBlock.cantidad && updatedBlock.cantidad !== '') {
                        const importe = concepto.importe || 0;
                        const cantidad = parseInt(updatedBlock.cantidad) || 0;
                        updatedBlock.total_concepto = (importe * cantidad).toFixed(2);
                    } else if (concepto && (!updatedBlock.cantidad || updatedBlock.cantidad === '')) {
                        updatedBlock.total_concepto = '0.00';
                    } else {
                        updatedBlock.total_concepto = '0.00';
                    }
                }
                
                return updatedBlock;
            }
            return block;
        }));
    };

    // Calcular total general y actualizar conceptos en el formulario
    useEffect(() => {
        const total = conceptoBlocks.reduce((sum, block) => {
            return sum + (parseFloat(block.total_concepto) || 0);
        }, 0);
        
        // Filtrar conceptos válidos para mantener actualizado el campo conceptos
        const validConceptos = conceptoBlocks
            .filter(block => {
                return block.concepto_id && 
                       parseInt(block.cantidad) > 0 && 
                       parseFloat(block.total_concepto) > 0;
            })
            .map(block => ({
                id: parseInt(block.concepto_id),
                cantidad: parseInt(block.cantidad),
                total_concepto: parseFloat(block.total_concepto)
            }));
            
        // Actualizar tanto el importe total como los conceptos
        setData(prev => ({ 
            ...prev, 
            importe_total: total.toFixed(2),
            conceptos: validConceptos.length > 0 ? validConceptos : []
        }));
        
        // Depuración para verificar la actualización de conceptos
        console.log('Conceptos actualizados:', validConceptos);
    }, [conceptoBlocks]);

    const handleSubmit = (e) => {
        e.preventDefault();
        
        // Filtrar conceptos válidos directamente antes de enviar
        const validConceptos = conceptoBlocks
            .filter(block => {
                return block.concepto_id && 
                       parseInt(block.cantidad) > 0 && 
                       parseFloat(block.total_concepto) > 0;
            })
            .map(block => ({
                id: parseInt(block.concepto_id),
                cantidad: parseInt(block.cantidad),
                total_concepto: parseFloat(block.total_concepto)
            }));
            
        // Actualizar los conceptos justo antes de enviar
        setData(prev => ({ ...prev, conceptos: validConceptos }));
        
        // Verificar que hay conceptos válidos
        if (!validConceptos || validConceptos.length === 0) {
            setAlert({
                show: true,
                type: 'error',
                message: 'Debe agregar al menos un concepto válido (con cantidad y total mayor a cero).'
            });
            return;
        }

        // Verificar que hay un alumno seleccionado
        if (!data.alumno_id) {
            setAlert({
                show: true,
                type: 'error', 
                message: 'Debe buscar y seleccionar un alumno'
            });
            return;
        }
        
        // Crear un objeto con los datos actualizados para enviar
        const formData = {
            ...data,
            conceptos: validConceptos,
            // Combinar fecha y hora en formato dateTime si es necesario
            hora: data.hora // Mantener el formato H:i para la validación
        };
        
        // Depuración para verificar los datos antes de enviar
        console.log('Datos a enviar:', formData);
        console.log('Conceptos a enviar:', formData.conceptos);
        console.log('Hora a enviar:', formData.hora);
        
        // Enviar el formulario
        if (ingreso?.id) {
            put(`/ingresos/${ingreso.id}`, formData);
        } else {
            post('/ingresos', formData);
        }
    };

    return (
        <form onSubmit={handleSubmit} className="flex flex-col p-5 bg-leaflighest shadow-md md:w-1/2 mb-5">
            <h3 className="form-header">Agregar Ingreso</h3>
            
            <Alert
                type={alert.type}
                message={alert.message}
                show={alert.show}
                onClose={() => setAlert({ show: false, type: '', message: '' })}
            />
            
            <div className="grid grid-cols-2 gap-3">
                <label htmlFor="fecha">Fecha</label>
                <label htmlFor="hora">Hora</label>
                
                <input 
                    type="date" 
                    className="my-2 border border-slate-600 p-1" 
                    name="fecha" 
                    readOnly 
                    value={data.fecha}
                />
                <input 
                    type="time" 
                    className="my-2 border border-slate-600 p-1" 
                    name="hora" 
                    value={data.hora}
                    onChange={(e) => setData('hora', e.target.value)}
                />
                
                <div className="flex flex-col">
                    <label htmlFor="dni">DNI</label>
                    <input 
                        type="text" 
                        placeholder="dni" 
                        className="my-2 border border-slate-600 p-1 w-full" 
                        name="dni" 
                        value={data.dni}
                        onChange={(e) => setData('dni', e.target.value)}
                    />
                    {errors.dni && <span className="text-red-500 text-sm">{errors.dni}</span>}
                </div>
                
                <div className="grid grid-cols-2 gap-1">
                    <a href="/alumnos/create" className="bg-leafdarkest text-white w-full mt-8 mb-1 text-center py-1">
                        Nuevo
                    </a>
                    <button 
                        className="bg-leafdarkest text-white w-full mt-8 mb-1" 
                        type="button" 
                        onClick={buscarAlumno}
                    >
                        Buscar
                    </button>
                </div>
            </div>

            <label htmlFor="alumno">Alumno encontrado</label>
            <input 
                type="text" 
                name="alumno" 
                className="p-1 border border-slate-600" 
                value={alumnoEncontrado || data.alumno}
                readOnly
            />
            {errors.alumno_id && <span className="text-red-500 text-sm">{errors.alumno_id}</span>}
            
            <label htmlFor="email">Email</label>
            <input 
                type="email" 
                name="email" 
                className="p-1 border border-slate-600"
                value={data.email}
                onChange={(e) => setData('email', e.target.value)}
            />

            <button 
                className="bg-leafdarkest text-white mx-auto py-1 px-2 mt-2" 
                type="button" 
                onClick={agregarConcepto}
            >
                Agregar Concepto
            </button>

            <div id="concepto-container">
                <div className="grid grid-cols-4 gap-x-1 mt-3">
                    <label>Concepto</label>
                    <label>Cantidad</label>
                    <label>Total concepto</label>
                    <label>Borrar</label>
                </div>
                
                {conceptoBlocks.map((block, index) => (
                    <ConceptoBlock
                        key={block.id}
                        block={block}
                        conceptos={conceptos}
                        onConceptoChange={actualizarConcepto}
                        onRemove={quitarConcepto}
                        canRemove={conceptoBlocks.length > 1}
                    />
                ))}
                {errors.conceptos && <span className="text-red-500 text-sm">{errors.conceptos}</span>}
            </div>

            <label htmlFor="total" className="mx-auto mt-3">Total</label>
            <input 
                type="text" 
                name="importe_total" 
                className="w-1/2 mx-auto border border-slate-600 p-1"
                value={data.importe_total}
                readOnly
            />
            {errors.importe_total && <span className="text-red-500 text-sm">{errors.importe_total}</span>}

            <div className="grid grid-cols-3 gap-4 mt-3">
                {/* Email Button - enabled if ingreso is created */}
                {ingreso?.id ? (
                    <a href='/mail' className="mx-auto mt-2 flex flex-col items-center hover:opacity-80">
                        <i className="fas fa-envelope text-leafdarkest text-4xl"></i>
                        <span className="text-sm text-leafdarkest mt-1">Enviar Email</span>
                    </a>
                ) : (
                    <div className="mx-auto mt-2 flex flex-col items-center opacity-50 cursor-not-allowed">
                        <i className="fas fa-envelope text-gray-400 text-4xl"></i>
                        <span className="text-sm text-gray-400 mt-1">Enviar Email</span>
                    </div>
                )}
                
                <button 
                    className="bg-leafsecond text-white py-2 my-4" 
                    type="submit"
                    disabled={processing}
                >
                    {processing ? 'Enviando...' : (ingreso?.id ? 'Actualizar' : 'Crear Ingreso')}
                </button>
                
                {/* Print Button - disabled if ingreso not created */}
                {ingreso?.id ? (
                    <a href={`/ingresos/${ingreso.id}/print`} target="_blank" className="mx-auto mt-2 flex flex-col items-center hover:opacity-80">
                        <i className="fas fa-print text-leafdarkest text-4xl"></i>
                        <span className="text-sm text-leafdarkest mt-1">Imprimir</span>
                    </a>
                ) : (
                    <div className="mx-auto mt-2 flex flex-col items-center opacity-50 cursor-not-allowed">
                        <i className="fas fa-print text-gray-400 text-4xl"></i>
                        <span className="text-sm text-gray-400 mt-1">Imprimir</span>
                    </div>
                )}
            </div>
        </form>
    );
};

export default IngresoForm;