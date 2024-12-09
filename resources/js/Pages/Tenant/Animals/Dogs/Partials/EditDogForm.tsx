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
    const { data, setData, errors, post, reset, processing } = useForm({
        name: animal.name ?? '',
        date_of_birth: animal.date_of_birth ?? '',
        breed: animal.animalable.breed ?? '',
        bio: animal.bio ?? '',
        abstract: animal.abstract ?? '',
        images:
            animal.medially?.map((media) => String(media.id)) ?? ([] as any[]),
        _method: 'PATCH',
    })

    const { focusError } = useFormContext(DogFormWrapper, processing)

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        post(route('animals.dogs.update', animal.id), {
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }

    return (
        <DogForm
            formId={formId}
            data={data}
            images={animal.medially}
            setData={setData}
            errors={errors}
            submitHandler={submitHandler}
        />
    )
}
