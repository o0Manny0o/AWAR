import { FormEventHandler } from 'react'
import { useForm } from '@inertiajs/react'
import useFormContext from '@/shared/hooks/useFormContext'
import { ListingFormWrapper } from '@/Pages/Tenant/Animals/Listings/Lib/Listings.context'
import { ListingForm } from '@/Pages/Tenant/Animals/Listings/Partials/ListingForm'

export default function CreateListingForm({ formId }: { formId: string }) {
    const { data, setData, errors, post, reset, processing, clearErrors } =
        useForm<ListingFormData>({
            excerpt: '',
            description: '',
        })

    const { focusError } = useFormContext(ListingFormWrapper, processing)

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
            submitHandler={submitHandler}
            clearErrors={clearErrors as any}
        />
    )
}
