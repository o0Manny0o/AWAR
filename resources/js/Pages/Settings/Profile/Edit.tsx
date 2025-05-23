import { Head } from '@inertiajs/react'
import DeleteUserForm from './Partials/DeleteUserForm'
import UpdatePasswordForm from './Partials/UpdatePasswordForm'
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm'
import { SettingsLayout } from '@/Layouts/SettingsLayout'
import { Card } from '@/Components/Layout/Card'

export default function Edit({
    mustVerifyEmail,
    status,
}: AppPageProps<{ mustVerifyEmail: boolean; status?: string }>) {
    return (
        <SettingsLayout title="Profile">
            <Head title="Profile" />

            <div className="space-y-4">
                <Card>
                    <UpdateProfileInformationForm
                        mustVerifyEmail={mustVerifyEmail}
                        status={status}
                    />
                </Card>

                <Card>
                    <UpdatePasswordForm />
                </Card>

                <Card>
                    <DeleteUserForm />
                </Card>
            </div>
        </SettingsLayout>
    )
}
