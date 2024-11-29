import Application = App.Models.OrganisationApplication
import useTranslate from '@/shared/hooks/useTranslate'
import { Badge } from '@/Components/_Base/Badge'
import { usePage } from '@inertiajs/react'
import {
    badgeColor,
    badgeLabelKey,
    canDelete,
    canEdit,
    canRestore,
} from '@/Pages/Organisation/Application/Lib/OrganisationApplication.util'
import List from '@/Components/Resource/List'

export default function OrganisationApplicationList({
    applications,
}: {
    applications: Application[]
}) {
    const __ = useTranslate()
    const { locale } = usePage().props

    return (
        <List
            entities={applications}
            title={(a) => a.name}
            subtitle={(a) => a.type}
            badge={(a) => (
                <Badge color={badgeColor(a)}>{__(badgeLabelKey(a))}</Badge>
            )}
            resourceUrl={'organisations.applications'}
            resourceLabel={'general.resources.organisation.application'}
            permissions={{
                path: 'organisations.applications',
                canUpdate: canEdit,
                canDelete: canDelete,
                canRestore: canRestore,
            }}
        />
    )
}
