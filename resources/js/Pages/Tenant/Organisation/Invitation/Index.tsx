import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import PageHeader from '@/Components/Layout/PageHeader'
import { Card } from '@/Components/Layout/Card'
import usePermission from '@/shared/hooks/usePermission'
import List from '@/Components/Resource/List'
import {
    badgeColor,
    badgeLabelKey,
} from '@/Pages/Tenant/Organisation/Invitation/Lib/OrganisationInvitation.util'
import { Badge } from '@/Components/_Base/Badge'
import OrganisationInvitation = App.Models.OrganisationInvitation

export default function Index({
    invitations,
}: AppPageProps<{ invitations: OrganisationInvitation[] }>) {
    const __ = useTranslate()
    const { can } = usePermission()

    return (
        <AuthenticatedLayout
            header={
                <PageHeader
                    title={__('general.your_resource', {
                        resource: 'general.resources.organisation.invitation',
                    })}
                    actionButtons={
                        can('organisations.invitations.create')
                            ? [
                                  {
                                      label: __('general.button.new', {
                                          resource:
                                              'general.resources.organisation.invitation',
                                      }),
                                      variant: 'primary',
                                      href: route(
                                          'organisation.invitations.create',
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
            <Head title="Organisation Invitations" />

            <div className="py-12">
                <Card>
                    <List
                        entities={invitations}
                        title={(i) => i.email}
                        subtitle={(e) =>
                            __(
                                ('general.roles.tenant.' +
                                    e.role) as TranslationKey,
                            )
                        }
                        badge={(i) => (
                            <Badge color={badgeColor(i)}>
                                {__(badgeLabelKey(i))}
                            </Badge>
                        )}
                        resourceUrl={'organisation.invitations'}
                        resourceLabel={
                            'general.resources.organisation.invitation'
                        }
                    />
                </Card>
            </div>
        </AuthenticatedLayout>
    )
}
