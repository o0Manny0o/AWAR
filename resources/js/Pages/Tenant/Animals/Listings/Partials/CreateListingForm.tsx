import { FormEventHandler } from 'react'
import { useForm } from '@inertiajs/react'
import useFormContext from '@/shared/hooks/useFormContext'
import { ListingFormWrapper } from '@/Pages/Tenant/Animals/Listings/Lib/Listings.context'
import { ListingForm } from '@/Pages/Tenant/Animals/Listings/Partials/ListingForm'
import Animal = App.Models.Animal
import AnimalType = App.Models.AnimalType

export default function CreateListingForm({
    formId,
    animal,
    animals = [],
    type,
}: {
    formId: string
    animal?: Animal
    animals?: AsOption<Animal>[]
    type: AnimalType
}) {
    const {
        data,
        setData,
        errors,
        post,
        reset,
        processing,
        clearErrors,
        transform,
    } = useForm<ListingFormData>({
        excerpt: '',
        description: '',
        animals: animal ? [animal] : [],
        images: [],
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

        post(route('animals.cats.listings.store'), {
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
            type={type}
        />
    )
}
