import { Head } from '@inertiajs/react'
import PublicLayout from '@/Layouts/PublicLayout'
import PageHeader from '@/Components/Layout/PageHeader'
import { Card } from '@/Components/Layout/Card'
import ShowGroup from '@/Components/_Base/Input/ShowGroup'
import { ShowImages } from '@/Components/_Base/Input/Images/ShowImages'
import useTranslate from '@/shared/hooks/useTranslate'
import History = App.Models.History
import Listing = App.Models.Listing

export default function Show({
    listing,
    histories,
}: AppPageProps<{ listing: Listing; histories: History[][] }>) {
    const __ = useTranslate()
    return (
        <>
            <Head title="Welcome" />
            <PublicLayout>
                <PageHeader
                    title={listing.animals.map((a) => a.name).join(', ')}
                    backUrl={route('listings.browse')}
                />

                <div className="space-y-4">
                    <Card>
                        <ShowGroup
                            name="date_of_birth"
                            label={__('animals.dogs.form.date_of_birth.label')}
                            value={listing.animals[0].date_of_birth}
                        />
                        <ShowGroup
                            name="breed"
                            label={__('animals.dogs.form.breed.label')}
                            value={listing.animals[0].animalable.breed}
                        />
                    </Card>

                    <Card>
                        <ShowGroup
                            name="bio"
                            label={__('animals.dogs.form.bio.label')}
                            value={listing.animals[0].bio}
                        />
                    </Card>

                    <Card header={__('general.images')}>
                        <ShowImages
                            images={listing.media?.map((m) => m.gallery) ?? []}
                        />
                    </Card>

                    <Card header={__('history.title')}>
                        <ul className="space-y-4">
                            {histories[0].map((item, idx) => (
                                <li key={idx}>{item.text}</li>
                            ))}
                        </ul>
                    </Card>
                </div>
            </PublicLayout>
        </>
    )
}
