import { Head, usePage } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import { Badge } from '@/Components/_Base/Badge'
import {
    badgeColor,
    badgeLabelKey,
} from '@/Pages/Settings/Application/Lib/OrganisationApplication.util'
import List from '@/Components/Resource/List'
import { SettingsLayout } from '@/Layouts/SettingsLayout'
import Application = App.Models.OrganisationApplication

export default function Index({
    applications,
}: AppPageProps<{ applications: Application[] }>) {
    const __ = useTranslate()
    const { canCreate } = usePage().props

    return (
        <SettingsLayout
            title={__('general.your_resource', {
                resource: 'general.resources.organisation.application',
            })}
            actionButtons={
                canCreate
                    ? [
                          {
                              label: __('general.button.new', {
                                  resource:
                                      'general.resources.organisation.application',
                              }),
                              variant: 'primary',
                              href: route('settings.applications.create'),
                          },
                      ]
                    : []
            }
        >
            <Head title="Organisation Applications" />
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
                    resourceUrl={'settings.applications'}
                    resourceLabel={'general.resources.organisation.application'}
                />
            </Card>
        </SettingsLayout>
    )
}
