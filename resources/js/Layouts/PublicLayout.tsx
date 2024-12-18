import { HeaderBar } from '@/Components/Layout/HeaderBar'
import { PropsWithChildren } from 'react'
import { Footer } from '@/Components/Layout/Footer'
import { BaseLayout } from '@/Layouts/BaseLayout'
import { usePage } from '@inertiajs/react'

export default function PublicLayout({ children }: PropsWithChildren) {
    const { tenant } = usePage().props
    return (
        <BaseLayout>
            <HeaderBar />

            <main className="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                {children}
            </main>

            {!tenant && <Footer />}
        </BaseLayout>
    )
}
