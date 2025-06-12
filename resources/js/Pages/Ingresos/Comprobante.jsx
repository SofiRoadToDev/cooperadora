import React, { useState } from 'react';
import { useForm } from '@inertiajs/react';

const ConceptoBlock = ({ concepto, onDelete, index }) => {
  return (
    <div className="grid grid-cols-4 gap-x-1 mt-3">
      <label htmlFor={`concepto-${index}`}>Concepto</label>
      <label htmlFor={`importe-${index}`}>Importe</label>
      <label htmlFor={`total-${index}`}>Total concepto</label>
      <label>Borrar</label>

      <select
        name={`concepto[${index}]`}
        id={`concepto-${index}`}
        className="border border-slate-600 bg-white px-2"
      >
        <option value="">Seleccione un concepto</option>
      </select>
      <input
        type="text"
        disabled
        name="importe_concepto"
        id={`importe-${index}`}
        className="border border-slate-600"
      />
      <input
        type="text"
        disabled
        name="total_concepto"
        id={`total-${index}`}
        className="border border-slate-600"
      />
      <button
        type="button"
        onClick={() => onDelete(index)}
        className="bg-red-500 text-white px-2 py-1 rounded"
      >
        Eliminar
      </button>
    </div>
  );
};

export default function Comprobante() {
  const [conceptos, setConceptos] = useState([{ id: 0 }]);
  const { data, setData, post } = useForm({
    fecha: new Date().toISOString().split('T')[0],
    hora: new Date().toLocaleTimeString(),
    dni: '',
    alumno: '',
    conceptos: [],
    total: 0,
  });

  const addConcepto = () => {
    setConceptos([...conceptos, { id: conceptos.length }]);
  };

  const removeConcepto = (index) => {
    setConceptos(conceptos.filter((_, i) => i !== index));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    post(route('ingresos.store'));
  };

  return (
    <form onSubmit={handleSubmit} className="flex flex-col p-5 shadow-md w-full mb-5">
      <h3 className="text-center py-4">Comprobante</h3>

      <div className="grid grid-cols-2 gap-3">
        <label htmlFor="fecha">Fecha</label>
        <label htmlFor="hora">Hora</label>
        <input
          type="date"
          className="my-2 border border-slate-600 p-1"
          name="fecha"
          value={data.fecha}
          onChange={e => setData('fecha', e.target.value)}
          disabled
        />
        <input
          type="time"
          className="my-2 border border-slate-600 p-1"
          name="hora"
          value={data.hora}
          onChange={e => setData('hora', e.target.value)}
          disabled
        />
        <div className="flex flex-col">
          <label htmlFor="dni">DNI</label>
          <input
            type="text"
            placeholder="dni"
            className="my-2 border border-slate-600 p-1 w-full"
            name="dni"
            value={data.dni}
            onChange={e => setData('dni', e.target.value)}
          />
        </div>

        <button
          className="bg-slate-900 text-white w-1/4 mx-auto py-2 my-4"
          type="button"
          onClick={() => window.location.href = route('alumnos.crear')}
        >
          Nuevo
        </button>
      </div>

      <label htmlFor="alumno">Alumno encontrado</label>
      <input
        type="text"
        name="alumno"
        className="p-1 border border-slate-600"
        value={data.alumno}
        onChange={e => setData('alumno', e.target.value)}
      />

      <button
        className="bg-slate-900 text-white mx-auto py-1 px-2 mt-2"
        type="button"
        onClick={addConcepto}
      >
        Agregar Concepto
      </button>

      <div id="concepto-container">
        {conceptos.map((concepto, index) => (
          <ConceptoBlock
            key={concepto.id}
            concepto={concepto}
            index={index}
            onDelete={removeConcepto}
          />
        ))}
      </div>

      <label htmlFor="total" className="mx-auto mt-3">
        Total
      </label>
      <input
        type="text"
        disabled
        name="total"
        className="w-1/2 mx-auto border border-slate-600 p-1"
        value={data.total}
      />
    </form>
  );
}