import { Head } from '@inertiajs/react'
import PublicLayout from '@/Layouts/PublicLayout'
import { AnimalList } from '@/Pages/Animals/Partials/AnimalList'
import PageHeader from '@/Components/Layout/PageHeader'
import Listing = App.Models.Listing

export default function Browse({
    listings,
}: AppPageProps<{ listings: Listing[] }>) {
    return (
        <>
            <Head title="Welcome" />
            <PublicLayout>
                <PageHeader title="Browse Animals" />

                {/* TODO: Filters */}

                <AnimalList listings={listings} />
            </PublicLayout>
        </>
    )
}
