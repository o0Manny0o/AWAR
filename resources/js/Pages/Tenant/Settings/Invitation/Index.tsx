import { Head, usePage } from '@inertiajs/react'
import useTranslate, { toTranslationKey } from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import List from '@/Components/Resource/List'
import {
    badgeColor,
    badgeLabelKey,
} from '@/Pages/Tenant/Settings/Invitation/Lib/OrganisationInvitation.util'
import { Badge } from '@/Components/_Base/Badge'
import { SettingsLayout } from '@/Layouts/SettingsLayout'
import OrganisationInvitation = App.Models.OrganisationInvitation

export default function Index({
    invitations,
}: AppPageProps<{ invitations: OrganisationInvitation[] }>) {
    const __ = useTranslate()
    const { canCreate } = usePage().props

    return (
        <SettingsLayout
            title={__('organisations.invitations.headers.index')}
            actionButtons={
                canCreate
                    ? [
                          {
                              label: __('general.button.new', {
                                  resource:
                                      'general.resources.organisation.invitation',
                              }),
                              variant: 'primary',
                              href: route('settings.invitations.create'),
                          },
                      ]
                    : []
            }
        >
            <Head title={__('organisations.invitations.titles.index')} />

            <div className="">
                <Card>
                    <List
                        entities={invitations}
                        title={(i) => i.email}
                        subtitle={(e) =>
                            __(
                                toTranslationKey(
                                    'general.roles.tenant.' + e.role.name,
                                ),
                            )
                        }
                        badge={(i) => (
                            <Badge color={badgeColor(i)}>
                                {__(badgeLabelKey(i))}
                            </Badge>
                        )}
                        resourceUrl={'settings.invitations'}
                        resourceLabel={
                            'general.resources.organisation.invitation'
                        }
                    />
                </Card>
            </div>
        </SettingsLayout>
    )
}
