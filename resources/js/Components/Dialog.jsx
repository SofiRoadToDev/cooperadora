import { useState } from 'react';

function Dialog({ isOpen, onClose, title, message, onConfirm, confirmText = "Confirmar", cancelText = "Cancelar" }) {
    if (!isOpen) return null;

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center">
            {/* Backdrop */}
            <div 
                className="fixed inset-0 bg-black bg-opacity-50"
                onClick={onClose}
            ></div>
            
            {/* Dialog */}
            <div className="relative bg-leaflighest border-2 border-leafsecond rounded-lg shadow-lg max-w-md w-full mx-4">
                {/* Header */}
                <div className="bg-leafdarkest text-white px-6 py-4 rounded-t-lg">
                    <h3 className="text-lg font-semibold">{title}</h3>
                </div>
                
                {/* Content */}
                <div className="p-6">
                    <p className="text-gray-700 mb-6">{message}</p>
                    
                    {/* Buttons */}
                    <div className="flex justify-end gap-3">
                        <button
                            onClick={onClose}
                            className="px-4 py-2 border border-slate-400 text-gray-700 rounded hover:bg-gray-50"
                        >
                            {cancelText}
                        </button>
                        <button
                            onClick={onConfirm}
                            className="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
                        >
                            {confirmText}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Dialog;