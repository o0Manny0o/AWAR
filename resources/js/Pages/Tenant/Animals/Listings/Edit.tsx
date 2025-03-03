import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { ListingFormWrapper } from '@/Pages/Tenant/Animals/Listings/Lib/Listings.context'
import { FormActionButtons } from '@/Pages/Tenant/Animals/Lib/Animals.buttons'
import { FormContextProvider } from '@/shared/contexts/Form.context'
import EditListingForm from '@/Pages/Tenant/Animals/Listings/Partials/EditListingForm'
import Animal = App.Models.Animal
import Listing = App.Models.Listing

export default function Edit({
    listing,
    animals,
    type,
}: AppPageProps<{
    listing: Listing
    animals: AsOption<Animal>[]
    type: string
}>) {
    const __ = useTranslate()

    const FORM_ID = 'edit-listing'

    return (
        <AuthenticatedLayout
            title={__(`animals.listings.headers.edit`, {
                type: `animals.listings.${type}`,
            })}
            actionButtons={FormActionButtons(
                route(`animals.${type}.listings.index`),
                FORM_ID,
            )}
            formContext={ListingFormWrapper.Context}
        >
            <Head
                title={__(`animals.listings.titles.edit`, {
                    type: `animals.listings.${type}`,
                })}
            />

            <FormContextProvider context={ListingFormWrapper}>
                <EditListingForm
                    formId={FORM_ID}
                    listing={listing}
                    animals={animals}
                />
            </FormContextProvider>
        </AuthenticatedLayout>
    )
}
