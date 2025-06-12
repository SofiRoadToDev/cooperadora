import { Link, useForm } from "@inertiajs/react";

function EditDelete({ editRoute, deleteRoute }) {
    const { delete: destroy } = useForm();

    const submit = (e) => {
        e.preventDefault();
        destroy(deleteRoute);
    };
    return (
        <div class="grid grid-cols-2 gap-2">
            <Link href={editRoute}>
                <i class="fa-solid fa-pen-to-square text-green-500"></i>
            </Link>
            <form class="ml-2" onSubmit={submit}>
                <button type="submit">
                    <i class="fa-solid fa-trash text-red-500"></i>
                </button>
            </form>
        </div>
    );
}

export default EditDelete;
