import { Slide, toast, ToastContainer } from 'react-toastify'
import { usePage } from '@inertiajs/react'
import { useEffect } from 'react'

export function ToastMessages() {
    const { messages } = usePage().props

    useEffect(() => {
        messages?.forEach((message) => {
            switch (message.type) {
                case 'success':
                    toast.success(message.message, message.config)
                    break
                case 'info':
                    toast.info(message.message, message.config)
                    break
                case 'warning':
                    toast.warning(message.message, message.config)
                    break
                case 'error':
                    toast.error(message.message, message.config)
                    break
                default:
                    toast(message.message, message.config)
            }
        })
    }, [messages])

    return (
        <ToastContainer
            stacked
            position="top-right"
            autoClose={5000}
            newestOnTop={false}
            closeOnClick
            rtl={false}
            pauseOnFocusLoss
            draggable
            theme="light"
            transition={Slide}
        />
    )
}
