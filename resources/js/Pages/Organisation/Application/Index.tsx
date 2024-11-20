import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'

export default function Index({
    applications,
}: AppPageProps<{ applications: any[] }>) {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Your Organisation Applications
                </h2>
            }
        >
            <Head title="Organisation Applications" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                    <div className="bg-ceiling p-4 shadow sm:rounded-lg sm:p-8">
                        {applications.map((application) => (
                            <p key={application.id}>
                                {JSON.stringify(application)}
                            </p>
                        ))}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
