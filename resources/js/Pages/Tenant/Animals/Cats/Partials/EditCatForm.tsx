import { FormEventHandler } from 'react'
import { useForm } from '@inertiajs/react'
import { CatFormWrapper } from '@/Pages/Tenant/Animals/Cats/Lib/Cat.context'
import useFormContext from '@/shared/hooks/useFormContext'
import { CatForm } from '@/Pages/Tenant/Animals/Cats/Partials/CatForm'
import Cat = App.Models.Cat

export default function EditCatForm({
    animal,
    formId,
}: {
    animal: Cat
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

    const { focusError } = useFormContext(CatFormWrapper, processing)

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        post(route('animals.cats.update', animal.id), {
            method: 'patch',
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }

    return (
        <CatForm
            formId={formId}
            data={data}
            images={animal.medially}
            setData={setData}
            errors={errors}
            submitHandler={submitHandler}
        />
    )
}
