import { Logo } from '@/Components/Layout/Logo'
import { PropsWithChildren } from 'react'

export default function FlowLayout({
    header,
    children,
}: PropsWithChildren<{ header: string }>) {
    return (
        <div className="bg-floor min-h-screen">
            <div className="fixed left-1/2 top-[min(20vh,256px)] w-full max-w-xl -translate-x-1/2 px-4">
                <div className="flex flex-col items-center gap-6">
                    <Logo />
                    <h1 className="text-xl font-semibold">{header}</h1>
                    {children}
                </div>
            </div>
        </div>
    )
}
