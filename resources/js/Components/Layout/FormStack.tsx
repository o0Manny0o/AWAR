import { Logo } from '@/Components/Layout/Logo'
import { Link } from '@inertiajs/react'
import { PropsWithChildren } from 'react'
import { twMerge } from 'tailwind-merge'

export function FormStack({
    header,
    children,
    footer,
    className,
}: PropsWithChildren<{
    header: string
    footer?: { href: string; text?: string; label: string }
    className?: string
}>) {
    return (
        <div
            className={twMerge(
                'flex flex-col items-center gap-6 h-full overflow-y-auto px-1',
                className,
            )}
        >
            <figure>
                <Logo />
            </figure>
            <h1 className="text-xl font-semibold">{header}</h1>
            {children}
            {footer && (
                <div className="flex w-full flex-col items-center">
                    <div
                        aria-hidden="true"
                        className="w-full max-w-48 border-t border-gray-300"
                    />
                    {footer.text && <p className="mt-4">{footer.text}</p>}
                    <Link className="block font-bold" href={footer.href}>
                        {footer.label}
                    </Link>
                </div>
            )}
        </div>
    )
}
