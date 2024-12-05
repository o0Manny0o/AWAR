import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import ShowGroup from '@/Components/_Base/Input/ShowGroup'
import Dog = App.Models.Dog
import { ShowActionButtons } from '@/Pages/Tenant/Animals/Lib/Animals.buttons'

export default function Show({ animal }: AppPageProps<{ animal: Dog }>) {
    const __ = useTranslate()

    return (
        <AuthenticatedLayout
            title={animal.name}
            actionButtons={ShowActionButtons(
                animal,
                'general.resources.animals.dog',
                'animals.dogs',
            )}
            backUrl={route('animals.dogs.index')}
        >
            <Head title={`${animal.name} - Dogs`} />

            <Card>
                <ShowGroup
                    name="date_of_birth"
                    label={__('animals.dogs.form.date_of_birth.label')}
                    value={animal.date_of_birth}
                />
                <ShowGroup
                    name="breed"
                    label={__('animals.dogs.form.breed.label')}
                    value={animal.animalable.breed}
                />
            </Card>
        </AuthenticatedLayout>
    )
}
