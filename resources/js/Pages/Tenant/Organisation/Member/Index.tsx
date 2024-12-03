import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate, { toTranslationKey } from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import List from '@/Components/Resource/List'
import Member = App.Models.Member

export default function Index({
    members,
}: AppPageProps<{ members: Member[] }>) {
    const __ = useTranslate()

    return (
        <AuthenticatedLayout title={__('organisations.members.headers.index')}>
            <Head title={__('organisations.members.titles.index')} />

            <div className="">
                <Card>
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
