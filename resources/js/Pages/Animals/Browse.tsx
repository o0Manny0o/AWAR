import { Head } from '@inertiajs/react'
import PublicLayout from '@/Layouts/PublicLayout'
import { AnimalList } from '@/Pages/Animals/Partials/AnimalList'
import PageHeader from '@/Components/Layout/PageHeader'
import Animal = App.Models.Animal

export default function Browse({
    animals,
}: AppPageProps<{ animals: Animal[] }>) {
    return (
        <>
            <Head title="Welcome" />
            <PublicLayout>
                <PageHeader title="Browse Animals" />

                {/* TODO: Filters */}

                <AnimalList animals={animals} />
            </PublicLayout>
        </>
    )
}
