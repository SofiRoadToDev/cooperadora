# Alumnos TODO - Problema con Select de Cursos

## Problema identificado

El formulario JSX de alumnos no está cargando los cursos en el select.

### Análisis del código:
1. **Controlador**: Envía correctamente `cursos` y `alumno` a `'Alumno/AlumnoCreate'`
2. **Página JSX**: Recibe correctamente las props y las pasa al componente  
3. **Formulario JSX**: Usa correctamente `curso_codigo` que coincide con la validación del controlador

### Posibles causas del problema:

1. **`cursos` está vacío**: Si no hay cursos en la base de datos, el select aparecerá vacío
2. **Error en la consulta**: Si `Curso::all()` falla, `cursos` podría ser `null`
3. **Problema de renderizado**: Si `cursos` no es un array válido

### Para debuggear:

1. **Verificar en el navegador** si `cursos` llega con datos usando las DevTools de React
2. **Agregar console.log** temporal en AlumnoForm: `console.log('cursos:', cursos)`
3. **Verificar la base de datos** si tiene registros en la tabla `cursos`

### Archivos revisados:
- `app/Http/Controllers/AlumnoController.php` - ✅ Correcto
- `resources/js/Pages/Alumno/AlumnoCreate.jsx` - ✅ Correcto  
- `resources/js/Components/Alumno/AlumnoForm.jsx` - ✅ Correcto

### Próximos pasos:
- Verificar datos en tabla `cursos`
- Revisar consola del navegador por errores
- Agregar debugging temporal si es necesario