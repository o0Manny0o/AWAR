import { FormEventHandler } from 'react'
import { useForm } from '@inertiajs/react'
import { DogFormWrapper } from '@/Pages/Tenant/Animals/Dogs/Lib/Dog.context'
import useFormContext from '@/shared/hooks/useFormContext'
import { DogForm } from '@/Pages/Tenant/Animals/Dogs/Partials/DogForm'

export default function CreateDogForm({ formId }: { formId: string }) {
    const { data, setData, errors, post, reset, processing } = useForm({
        name: '',
        date_of_birth: '',
        breed: '',
        bio: '',
        abstract: '',
        images: [],
    })

    const { focusError } = useFormContext(DogFormWrapper, processing)

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        post(route('animals.dogs.store'), {
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }

    return (
        <DogForm
            formId={formId}
            data={data}
            setData={setData}
            errors={errors}
            submitHandler={submitHandler}
        />
    )
}
