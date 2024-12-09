import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import ShowGroup from '@/Components/_Base/Input/ShowGroup'
import { ShowActionButtons } from '@/Pages/Tenant/Animals/Lib/Animals.buttons'
import {
    badgeColor,
    badgeLabelKey,
} from '@/Pages/Tenant/Animals/Lib/Animals.util'
import Cat = App.Models.Cat
import { ShowImages } from '@/Components/_Base/Input/Images/ShowImages'

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
            badge={{
                color: badgeColor(animal),
                label: __(badgeLabelKey(animal)),
            }}
            backUrl={route('animals.cats.index')}
        >
            <Head title={`${animal.name} - Cats`} />

            <div className="space-y-4">
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

                <Card>
                    <ShowGroup
                        name="bio"
                        label={__('animals.cats.form.bio.label')}
                        value={animal.bio}
                    />
                    <ShowGroup
                        name="abstract"
                        label={__('animals.cats.form.abstract.label')}
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
