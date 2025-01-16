import { PropsWithChildren } from 'react'
import { ToastMessages } from '@/Components/Layout/ToastMessages/ToastMessages'
import { Head, usePage } from '@inertiajs/react'

export function BaseLayout({ children }: PropsWithChildren) {
    const { tenant } = usePage().props
    return (
        <div className="bg-floor min-h-screen">
            {tenant?.public_settings?.favicon && (
                <Head>
                    <link
                        rel="icon"
                        type="image/png"
                        href={tenant?.public_settings?.favicon}
                    />
                </Head>
            )}
            <ToastMessages />
            {children}
        </div>
    )
}
