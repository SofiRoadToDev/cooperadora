function ConceptoList({ conceptos }) {
    return (
        <table class="mt-5">
            <thead>
                <tr class="table-header">
                    <th class="px-4 py-3 ">Nombre</th>
                    <th class="px-4 py-3">Importe</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {
                   conceptos.map((concepto) => (
                        <tr class="border border-slate-600">
                            <td class="px-4 py-2 border border-slate-600">
                                {concepto.nombre}
                            </td>
                            <td class="px-4 py-2 border border-slate-600">
                                {concepto.importe}
                            </td>
                            <td class="px-4 py-2 border border-slate-600"></td>
                        </tr>
                    ))}
            </tbody>
        </table>
    );
}

export default ConceptoList;
