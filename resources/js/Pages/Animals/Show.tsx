import { Head } from '@inertiajs/react'
import PublicLayout from '@/Layouts/PublicLayout'
import PageHeader from '@/Components/Layout/PageHeader'
import { Card } from '@/Components/Layout/Card'
import ShowGroup from '@/Components/_Base/Input/ShowGroup'
import { ShowImages } from '@/Components/_Base/Input/Images/ShowImages'
import useTranslate from '@/shared/hooks/useTranslate'
import Animal = App.Models.Animal
import History = App.Models.History

export default function Show({
    animal,
    history,
}: AppPageProps<{ animal: Animal; history: History[] }>) {
    const __ = useTranslate()
    return (
        <>
            <Head title="Welcome" />
            <PublicLayout>
                <PageHeader
                    title={animal.name}
                    backUrl={route('animals.browse')}
                />

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
                    </Card>

                    <Card header={__('general.images')}>
                        <ShowImages animal={animal} />
                    </Card>

                    <Card header={__('history.title')}>
                        <ul className="space-y-4">
                            {history.map((item, idx) => (
                                <li key={idx}>{item.text}</li>
                            ))}
                        </ul>
                    </Card>
                </div>
            </PublicLayout>
        </>
    )
}
