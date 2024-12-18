import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import { Head } from '@inertiajs/react'
import { Card } from '@/Components/Layout/Card'

export default function Dashboard() {
    return (
        <AuthenticatedLayout title="Dashboard">
            <Head title="Dashboard" />

            <Card>You're logged in!</Card>
        </AuthenticatedLayout>
    )
}
