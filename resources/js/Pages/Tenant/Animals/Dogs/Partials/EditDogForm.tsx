import { FormEventHandler } from 'react'
import { useForm } from '@inertiajs/react'
import useFormContext from '@/shared/hooks/useFormContext'
import { DogFormWrapper } from '@/Pages/Tenant/Animals/Dogs/Lib/Dog.context'
import { DogForm } from '@/Pages/Tenant/Animals/Dogs/Partials/DogForm'
import Dog = App.Models.Dog

export default function EditDogForm({
    animal,
    formId,
}: {
    animal: Dog
    formId: string
}) {
    const { data, setData, errors, patch, reset, processing } = useForm({
        name: animal.name ?? '',
        date_of_birth: animal.date_of_birth ?? '',
        breed: animal.animalable.breed ?? '',
    })

    const { focusError } = useFormContext(DogFormWrapper, processing)

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        patch(route('animals.dogs.update', animal.id), {
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
