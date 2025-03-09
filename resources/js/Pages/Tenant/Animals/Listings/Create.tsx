import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { ListingFormWrapper } from '@/Pages/Tenant/Animals/Listings/Lib/Listings.context'
import { FormActionButtons } from '@/Pages/Tenant/Animals/Lib/Animals.buttons'
import { FormContextProvider } from '@/shared/contexts/Form.context'
import CreateListingForm from '@/Pages/Tenant/Animals/Listings/Partials/CreateListingForm'
import Animal = App.Models.Animal
import AnimalType = App.Models.AnimalType

export default function Create({
    animal,
    animals,
    type,
}: AppPageProps<{
    animal?: Animal
    animals: AsOption<Animal>[]
    type: AnimalType
}>) {
    const __ = useTranslate()

    const FORM_ID = 'create-listing'

    return (
        <AuthenticatedLayout
            title={__(`animals.listings.headers.create`, {
                type: `animals.listings.${type}`,
            })}
            actionButtons={FormActionButtons(
                route(`animals.${type}.listings.index`),
                FORM_ID,
            )}
            formContext={ListingFormWrapper.Context}
        >
            <Head
                title={__(`animals.listings.titles.create`, {
                    type: `animals.listings.${type}`,
                })}
            />

            <FormContextProvider context={ListingFormWrapper}>
                <CreateListingForm
                    formId={FORM_ID}
                    animal={animal}
                    animals={animals}
                    type={type}
                />
            </FormContextProvider>
        </AuthenticatedLayout>
    )
}
