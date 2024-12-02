import { PropsWithChildren } from 'react'
import { ToastMessages } from '@/Components/Layout/ToastMessages/ToastMessages'

export function BaseLayout({ children }: PropsWithChildren) {
    return (
        <div className="bg-floor min-h-screen">
            <ToastMessages />
            {children}
        </div>
    )
}
