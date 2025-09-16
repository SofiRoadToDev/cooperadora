function ConceptoBlock({ 
    block, 
    conceptos, 
    onConceptoChange, 
    onRemove, 
    canRemove 
}) {
    return (
        <div className="grid grid-cols-4 gap-x-1 mt-2">
            <select 
                className="border border-slate-600 bg-white px-2"
                value={block.concepto_id || ''}
                onChange={(e) => onConceptoChange(block.id, 'concepto_id', e.target.value)}
            >
                <option value="">Seleccionar concepto</option>
                {conceptos.map(concepto => (
                    <option key={concepto.id} value={concepto.id}>
                        {concepto.nombre}
                    </option>
                ))}
            </select>
            
            <input 
                type="number" 
                step="1"
                min="1"
                max="20"
                className="border border-slate-600 p-1"
                value={block.cantidad || ''}
                onChange={(e) => onConceptoChange(block.id, 'cantidad', e.target.value)}
                placeholder="Cantidad"
            />
            
            <input 
                type="text" 
                className="border border-slate-600 p-1"
                value={block.total_concepto || '0.00'}
                readOnly
            />
            
            {canRemove && (
                <button 
                    className="bg-red-500 text-white py-1 px-2" 
                    type="button"
                    onClick={() => onRemove(block.id)}
                >
                    Quitar
                </button>
            )}
        </div>
    );
}

export default ConceptoBlock;