function Alert({ type, message, show, onClose }) {
    if (!show) return null;

    const typeClasses = {
        success: 'bg-green-100 border-green-500 text-green-700',
        error: 'bg-red-100 border-red-500 text-red-700'
    };

    return (
        <div className={`border-l-4 p-4 mb-4 ${typeClasses[type]}`}>
            <div className="flex justify-between items-center">
                <p className="font-medium">{message}</p>
                {onClose && (
                    <button
                        onClick={onClose}
                        className="text-gray-400 hover:text-gray-600"
                    >
                        ×
                    </button>
                )}
            </div>
        </div>
    );
}

export default Alert;