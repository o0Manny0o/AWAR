import { FormEventHandler } from 'react'
import { useForm } from '@inertiajs/react'
import { CatFormWrapper } from '@/Pages/Tenant/Animals/Cats/Lib/Cat.context'
import useFormContext from '@/shared/hooks/useFormContext'
import { CatForm } from '@/Pages/Tenant/Animals/Cats/Partials/CatForm'
import { CatFormData } from '@/Pages/Tenant/Animals/Lib/Animals.types'
import Cat = App.Models.Cat

export default function EditCatForm({
    animal,
    formId,
}: {
    animal: Cat
    formId: string
}) {
    const { data, setData, errors, post, reset, processing, clearErrors } =
        useForm<CatFormData>({
            name: animal.name ?? '',
            date_of_birth: animal.date_of_birth ?? '',
            breed: animal.animalable.breed ?? '',
            sex: animal.sex ?? 'female',
            bio: animal.bio ?? '',
            images: animal.media?.map((media) => String(media.id)) ?? [],
            _method: 'PATCH',
            // If no family is selected, use the first family as parent instead
            // TODO: Add better support for setting maternal and paternal families
            family:
                animal.animal_family_id ??
                animal.maternal_families?.[0]?.id ??
                animal.paternal_families?.[0]?.id ??
                undefined,
            father:
                animal.father ??
                animal.maternal_families?.[0]?.father?.id ??
                animal.paternal_families?.[0]?.father?.id ??
                undefined,
            mother:
                animal.mother ??
                animal.maternal_families?.[0]?.mother?.id ??
                animal.paternal_families?.[0]?.mother?.id ??
                undefined,
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
            images={animal.media}
            setData={setData}
            errors={errors}
            submitHandler={submitHandler}
            clearErrors={clearErrors as any}
        />
    )
}
