import { Logo } from '@/Components/Layout/Logo'
import { PropsWithChildren } from 'react'
import { Link } from '@inertiajs/react'

export default function FlowLayout({
    header,
    children,
    footer,
}: PropsWithChildren<{
    header: string
    footer?: { href: string; text?: string; label: string }
}>) {
    return (
        <div className="bg-floor min-h-screen">
            <div className="fixed left-1/2 top-[min(20vh,256px)] w-full max-w-xl -translate-x-1/2 px-4">
                <div className="flex flex-col items-center gap-6">
                    <Logo />
                    <h1 className="text-xl font-semibold">{header}</h1>
                    {children}
                    {footer && (
                        <div className="mt-8 flex w-full flex-col items-center">
                            <div
                                aria-hidden="true"
                                className="w-full max-w-48 border-t border-gray-300"
                            />
                            {footer.text && (
                                <p className="mt-4">{footer.text}</p>
                            )}
                            <Link
                                className="block font-bold"
                                href={footer.href}
                            >
                                {footer.label}
                            </Link>
                        </div>
                    )}
                </div>
            </div>
        </div>
    )
}
