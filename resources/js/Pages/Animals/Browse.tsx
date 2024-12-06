import { Head } from '@inertiajs/react'
import PublicLayout from '@/Layouts/PublicLayout'
import List from '@/Components/Resource/List'
import Animal = App.Models.Animal
import { AnimalList } from '@/Pages/Animals/Partials/AnimalList'
import PageHeader from '@/Components/Layout/PageHeader'

export default function Browse({
    animals,
    tenant,
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
