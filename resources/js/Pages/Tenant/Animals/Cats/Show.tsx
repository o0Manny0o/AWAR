import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import ShowGroup from '@/Components/_Base/Input/ShowGroup'
import { ShowActionButtons } from '@/Pages/Tenant/Animals/Lib/Animals.buttons'
import Cat = App.Models.Cat

export default function Show({ animal }: AppPageProps<{ animal: Cat }>) {
    const __ = useTranslate()

    return (
        <AuthenticatedLayout
            title={animal.name}
            actionButtons={ShowActionButtons(
                animal,
                'general.resources.animals.cat',
                'animals.cats',
            )}
            backUrl={route('animals.cats.index')}
        >
            <Head title={`${animal.name} - Cats`} />

            <Card>
                <ShowGroup
                    name="date_of_birth"
                    label={__('animals.cats.form.date_of_birth.label')}
                    value={animal.date_of_birth}
                />
                <ShowGroup
                    name="breed"
                    label={__('animals.cats.form.breed.label')}
                    value={animal.animalable.breed}
                />
            </Card>
        </AuthenticatedLayout>
    )
}
