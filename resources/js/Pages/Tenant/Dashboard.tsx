import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate, { toTranslationKey } from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import List from '@/Components/Resource/List'
import Member = App.Models.Member

export default function Index({
    members,
    auth: {
        user: { name },
    },
    tenant,
}: AppPageProps<{ members: Member[] }>) {
    const __ = useTranslate()

    return (
        <AuthenticatedLayout title={__('general.navigation.dashboard')}>
            <Head title={__('general.navigation.dashboard')} />

            <div className="space-y-6">
                <Card>
                    {__('organisations.dashboard.welcome', {
                        name: name,
                        organisation: tenant?.name ?? 'AWAR',
                    })}
                </Card>
                <Card header={__('organisations.members.headers.index')}>
                    <List
                        entities={members}
                        title={(i) => i.name}
                        subtitle={(e) => e.email}
                        secondarySubtitle={(e) =>
                            e.roles
                                ?.map((r) =>
                                    __(
                                        toTranslationKey(
                                            'general.roles.tenant.' + r.name,
                                        ),
                                    ),
                                )
                                .join(', ')
                        }
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
