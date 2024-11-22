import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import OrganisationApplicationList from '@/Pages/Organisation/Application/Partials/OrganisationApplicationList'
import Application = App.Models.OrganisationApplication
import useTranslate from '@/shared/hooks/useTranslate'

export default function Index({
    applications,
}: AppPageProps<{ applications: Application[] }>) {
    const __ = useTranslate()
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {/* TODO: Pluralize */}
                    {__('general.your_resource', {
                        resource: 'organisations.applications.application',
                    })}
                </h2>
            }
        >
            <Head title="Organisation Applications" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                    <div className="bg-ceiling p-4 shadow sm:rounded-lg sm:p-8">
                        <OrganisationApplicationList
                            applications={applications}
                        />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
