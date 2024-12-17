import { PropsWithChildren } from 'react'
import { BaseLayout } from '@/Layouts/BaseLayout'
import { twMerge } from 'tailwind-merge'
import { FormStack } from '@/Components/Layout/FormStack'

export default function FlowLayout({
    className,
    children,
    ...props
}: PropsWithChildren<{
    header: string
    footer?: { href: string; text?: string; label: string }
    className?: string
}>) {
    return (
        <BaseLayout>
            <div
                className={twMerge(
                    'fixed left-1/2 top-[min(20vh,256px)] w-full max-w-xl -translate-x-1/2 px-4',
                    className,
                )}
            >
                <FormStack {...props}>{children}</FormStack>
            </div>
        </BaseLayout>
    )
}
