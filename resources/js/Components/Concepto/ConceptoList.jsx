function ConceptoList({ conceptos = []}) {
    return (
        <table className="mt-5">
            <thead>
                <tr className="table-header">
                    <th className="px-4 py-3 ">Nombre</th>
                    <th className="px-4 py-3">Importe</th>
                    <th className="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
<<<<<<< HEAD
                {conceptos.length > 0 &&
                    conceptos.map((concepto) => (
=======
                {
                   conceptos.map((concepto) => (
>>>>>>> 1ba139bfe203a2faec68059d7f328d06fa1533f9
                        <tr key={concepto.id} className="border border-slate-600">
                            <td className="px-4 py-2 border border-slate-600">
                                {concepto.nombre}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                {concepto.importe}
                            </td>
                            <td className="px-4 py-2 border border-slate-600"></td>
                        </tr>
                    ))}
            </tbody>
        </table>
    );
}

export default ConceptoList;
