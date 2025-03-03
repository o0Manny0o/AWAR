import { FormEventHandler } from 'react'
import { useForm } from '@inertiajs/react'
import useFormContext from '@/shared/hooks/useFormContext'
import { ListingFormWrapper } from '@/Pages/Tenant/Animals/Listings/Lib/Listings.context'
import { ListingForm } from '@/Pages/Tenant/Animals/Listings/Partials/ListingForm'
import Animal = App.Models.Animal
import Listing = App.Models.Listing

export default function EditListingForm({
    formId,
    listing,
    animals = [],
}: {
    formId: string
    listing: Listing
    animals?: AsOption<Animal>[]
}) {
    const {
        data,
        setData,
        errors,
        patch,
        reset,
        processing,
        clearErrors,
        transform,
    } = useForm<ListingFormData>({
        excerpt: listing.excerpt ?? '',
        description: listing.description ?? '',
        animals: listing.animals ?? [],
        images: listing.media ?? [],
    })

    const { focusError } = useFormContext(ListingFormWrapper, processing)

    transform((data) => {
        return {
            ...data,
            animals: data.animals.map((animal) => animal.id),
        } as unknown as ListingFormData
    })

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        patch(route('animals.cats.listings.update', listing.id), {
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }

    return (
        <ListingForm
            formId={formId}
            data={data}
            setData={setData}
            errors={errors}
            animals={animals}
            submitHandler={submitHandler}
            clearErrors={clearErrors as any}
        />
    )
}
