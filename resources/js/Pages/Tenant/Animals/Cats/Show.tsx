import { Head } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import ShowGroup from '@/Components/_Base/Input/ShowGroup'
import { ShowActionButtons } from '@/Pages/Tenant/Animals/Lib/Animals.buttons'
import {
    badgeColor,
    badgeLabelKey,
} from '@/Pages/Tenant/Animals/Lib/Animals.util'
import { ShowImages } from '@/Components/_Base/Input/Images/ShowImages'
import { AnimalShowLayout } from '@/Layouts/AnimalShowLayout'
import Cat = App.Models.Cat
import History = App.Models.History

export default function Show({
    animal,
    history,
}: AppPageProps<{ animal: Cat; history: History[] }>) {
    const __ = useTranslate()

    return (
        <AnimalShowLayout
            animal={animal}
            baseRoute={'animals.cats'}
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
                    <ShowImages images={animal.gallery ?? []} />
                </Card>

                <Card header={__('history.title')}>
                    <ul className="space-y-4">
                        {history.map((item, idx) => (
                            <li key={idx}>{item.text}</li>
                        ))}
                    </ul>
                </Card>
            </div>
        </AnimalShowLayout>
    )
}
