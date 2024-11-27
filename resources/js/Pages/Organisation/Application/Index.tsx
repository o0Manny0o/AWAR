import { Head, usePage } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import OrganisationApplicationList from '@/Pages/Organisation/Application/Partials/OrganisationApplicationList'
import useTranslate from '@/shared/hooks/useTranslate'
import PageHeader from '@/Components/Layout/PageHeader'
import Application = App.Models.OrganisationApplication

export default function Index({
    applications,
}: AppPageProps<{ applications: Application[] }>) {
    const __ = useTranslate()
    const { permissions } = usePage().props

    const canCreate = permissions?.organisationApplications?.create

    console.log(canCreate)

    return (
        <AuthenticatedLayout
            header={
                <PageHeader
                    title={__('general.your_resource', {
                        resource: 'organisations.applications.application',
                    })}
                    actionButtons={
                        canCreate
                            ? [
                                  {
                                      label: __('general.button.new', {
                                          resource:
                                              'organisations.applications.application',
                                      }),
                                      variant: 'primary',
                                      href: route(
                                          'organisations.applications.create',
                                      ),
                                  },
                              ]
                            : []
                    }
                >
                    {/* TODO: Pluralize */}
                </PageHeader>
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
