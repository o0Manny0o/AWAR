import { Head } from '@inertiajs/react'
import { LanguageSelector } from '@/Components/LanguageSelector'
import useTranslate from '@/shared/hooks/useTranslate'
import PublicLayout from '@/Layouts/PublicLayout'

export default function Welcome({}: AppPageProps<{}>) {
    const __ = useTranslate()

    return (
        <>
            <Head title="Welcome" />
            <PublicLayout>
                <p>
                    {__('landing_page.welcome_message', {
                        name: 'John Doe',
                    })}
                </p>
                <div className="flex justify-end">
                    <LanguageSelector />
                </div>
            </PublicLayout>
        </>
    )
}
