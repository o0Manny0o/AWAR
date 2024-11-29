import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import PageHeader from '@/Components/Layout/PageHeader'
import { Card } from '@/Components/Layout/Card'
import usePermission from '@/shared/hooks/usePermission'
import { Badge } from '@/Components/_Base/Badge'
import {
    badgeColor,
    badgeLabelKey,
} from '@/Pages/Organisation/Application/Lib/OrganisationApplication.util'
import List from '@/Components/Resource/List'
import Application = App.Models.OrganisationApplication

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
                    <List
                        entities={applications}
                        title={(a) => a.name}
                        subtitle={(a) => a.type}
                        badge={(a) => (
                            <Badge color={badgeColor(a)}>
                                {__(badgeLabelKey(a))}
                            </Badge>
                        )}
                        resourceUrl={'organisations.applications'}
                        resourceLabel={
                            'general.resources.organisation.application'
                        }
                    />
                </Card>
            </div>
        </AuthenticatedLayout>
    )
}
