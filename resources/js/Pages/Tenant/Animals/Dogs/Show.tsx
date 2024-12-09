import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import ShowGroup from '@/Components/_Base/Input/ShowGroup'
import { ShowActionButtons } from '@/Pages/Tenant/Animals/Lib/Animals.buttons'
import Dog = App.Models.Dog
import {
    badgeColor,
    badgeLabelKey,
} from '@/Pages/Tenant/Animals/Lib/Animals.util'
import { ShowImages } from '@/Components/_Base/Input/Images/ShowImages'

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
            badge={{
                color: badgeColor(animal),
                label: __(badgeLabelKey(animal)),
            }}
            backUrl={route('animals.dogs.index')}
        >
            <Head title={`${animal.name} - Dogs`} />
            <div className="space-y-4">
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

                <Card>
                    <ShowGroup
                        name="bio"
                        label={__('animals.dogs.form.bio.label')}
                        value={animal.bio}
                    />
                    <ShowGroup
                        name="abstract"
                        label={__('animals.dogs.form.abstract.label')}
                        value={animal.abstract}
                    />
                </Card>

                <Card header={__('general.images')}>
                    <ShowImages animal={animal} />
                </Card>
            </div>
        </AuthenticatedLayout>
    )
}
