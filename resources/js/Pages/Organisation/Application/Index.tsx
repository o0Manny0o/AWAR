import { Head, usePage } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import OrganisationApplicationList from '@/Pages/Organisation/Application/Partials/OrganisationApplicationList'
import useTranslate from '@/shared/hooks/useTranslate'
import PageHeader from '@/Components/Layout/PageHeader'
import { Card } from '@/Components/Layout/Card'
import Application = App.Models.OrganisationApplication
import usePermission from '@/shared/hooks/usePermission'

export default function Index({
    applications,
}: AppPageProps<{ applications: Application[] }>) {
    const __ = useTranslate()
    const { can } = usePermission()

    return (
        <AuthenticatedLayout
            header={
                <PageHeader
                    title={__('general.your_resource', {
                        resource: 'general.resources.organisation.application',
                    })}
                    actionButtons={
                        can('organisations.applications.create')
                            ? [
                                  {
                                      label: __('general.button.new', {
                                          resource:
                                              'general.resources.organisation.application',
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
                    {/* TODO: Pluralize title */}
                </PageHeader>
            }
        >
            <Head title="Organisation Applications" />

            <div className="py-12">
                <Card>
                    <OrganisationApplicationList applications={applications} />
                </Card>
            </div>
        </AuthenticatedLayout>
    )
}
