import Listing = App.Models.Listing
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import { Card } from '@/Components/Layout/Card'
import ShowGroup from '@/Components/_Base/Input/ShowGroup'
import { ShowImages } from '@/Components/_Base/Input/Images/ShowImages'
import { ShowActionButtons } from '@/Pages/Tenant/Animals/Listings/Lib/Listings.buttons'

export default function Show({
    listing,
    type,
}: AppPageProps<{ listing: Listing; type: string }>) {
    return (
        <AuthenticatedLayout
            title={
                listing.listing_animals
                    ?.map((animal) => animal.animal.name)
                    .join(', ') ?? ''
            }
            actionButtons={ShowActionButtons(
                listing,
                'general.resources.animals.listing',
                `animals.${type}.listings`,
            )}
            backUrl={route(`animals.${type}.listings.index`)}
        >
            <div className="space-y-6">
                <Card>
                    <ShowGroup
                        name={'excerpt'}
                        label={'excerpt'}
                        value={listing.excerpt}
                    />
                    <ShowGroup
                        name={'description'}
                        label={'description'}
                        value={listing.description}
                    />
                </Card>
                <Card>
                    <ShowImages
                        images={
                            listing.listing_animals
                                ?.map((listingAnimal) => listingAnimal.media)
                                .flat() ?? []
                        }
                    />
                </Card>
            </div>
        </AuthenticatedLayout>
    )
}
