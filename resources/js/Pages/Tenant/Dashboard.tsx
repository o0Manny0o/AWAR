import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate, { toTranslationKey } from '@/shared/hooks/useTranslate'
import PageHeader from '@/Components/Layout/PageHeader'
import { Card } from '@/Components/Layout/Card'
import List from '@/Components/Resource/List'
import Member = App.Models.Member

export default function Index({
    members,
    auth: {
        user: { name },
    },
    tenant: { name: organisation },
}: AppPageProps<{ members: Member[] }>) {
    const __ = useTranslate()

    return (
        <AuthenticatedLayout
            header={
                <PageHeader
                    title={__('general.navigation.dashboard')}
                    actionButtons={[]}
                />
            }
        >
            <Head title={__('general.navigation.dashboard')} />

            <div className="py-12 space-y-6">
                <Card>
                    {__('organisations.dashboard.welcome', {
                        name: name,
                        organisation: organisation,
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
